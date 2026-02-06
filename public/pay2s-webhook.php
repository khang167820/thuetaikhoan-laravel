<?php
/**
 * Pay2s Webhook Handler (Standalone PHP - no Laravel bootstrap needed for speed)
 * URL: https://thuetaikhoan.net/pay2s-webhook.php
 * 
 * Flow: Pay2s sends transaction → We verify → Update order → Call ADY API
 */

// Quick response first (Pay2s requires fast response)
header('Content-Type: application/json');

// Get raw input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Log for debug
$logFile = __DIR__ . '/../storage/logs/pay2s-webhook.log';
$logEntry = date('Y-m-d H:i:s') . " | " . $input . "\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Validate token
$token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$token = str_replace('Bearer ', '', $token);
$expectedToken = '6b175e25a84efff064416aa36add80be93925e532126939af6';

if ($token !== $expectedToken) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR: Invalid token\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => 'Invalid token']);
    exit;
}

// Check transactions
if (empty($data['transactions']) || !is_array($data['transactions'])) {
    echo json_encode(['success' => true, 'message' => 'No transactions']);
    exit;
}

// Database connection
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

foreach ($data['transactions'] as $tx) {
    try {
        $content = $tx['content'] ?? '';
        $amount = (int)($tx['transferAmount'] ?? 0);
        $type = $tx['transferType'] ?? '';
        
        // Only process incoming transfers
        if ($type !== 'IN') continue;
        
        // Extract tracking code from content (GHxxxxxx format)
        preg_match('/(GH\d+)/i', $content, $matches);
        $trackingCode = strtoupper($matches[1] ?? '');
        
        if (empty($trackingCode)) {
            Log::info("Pay2s: No tracking code found in content: $content");
            continue;
        }
        
        Log::info("Pay2s: Processing $trackingCode, amount: $amount");
        
        // Check ADY orders first
        $adyOrder = DB::table('ady_orders')
            ->where('tracking_code', $trackingCode)
            ->where('status', 'pending')
            ->first();
            
        if ($adyOrder) {
            processAdyOrder($trackingCode, $amount);
        } else {
            // Check regular orders
            processRegularOrder($trackingCode, $amount);
        }
        
    } catch (Exception $e) {
        Log::error("Pay2s Webhook Error: " . $e->getMessage());
    }
}

echo json_encode(['success' => true]);

/**
 * Process ADY order - call ADY API
 */
function processAdyOrder($trackingCode, $amount) {
    $order = DB::table('ady_orders')
        ->where('tracking_code', $trackingCode)
        ->where('status', 'pending')
        ->first();
    
    if (!$order) {
        Log::info("Pay2s: ADY order not found or already processed: $trackingCode");
        return;
    }
    
    // Verify amount (allow 1% tolerance for fees)
    if ($amount < $order->price_vnd * 0.99) {
        Log::warning("Pay2s: Amount mismatch for $trackingCode. Expected: {$order->price_vnd}, Got: $amount");
        return;
    }
    
    // Mark as paid
    DB::table('ady_orders')->where('id', $order->id)->update([
        'status' => 'paid',
        'paid_at' => now(),
        'paid_amount' => $amount,
    ]);
    
    // Call ADY API
    $adyService = app(\App\Services\AdyService::class);
    $fields = json_decode($order->fields, true) ?? [];
    $feedbackUrl = url('/ady-webhook.php');
    
    $result = $adyService->placeOrder(
        $order->product_uuid,
        $fields,
        $order->tracking_code,
        $feedbackUrl
    );
    
    if ($result['success']) {
        DB::table('ady_orders')->where('id', $order->id)->update([
            'ady_order_uuid' => $result['order_uuid'],
            'status' => 'processing',
        ]);
        Log::info("Pay2s: ADY order placed successfully: $trackingCode");
    } else {
        DB::table('ady_orders')->where('id', $order->id)->update([
            'status' => 'failed',
            'error' => $result['error'] ?? 'Unknown error',
        ]);
        Log::error("Pay2s: ADY order failed: $trackingCode - " . ($result['error'] ?? 'Unknown'));
    }
}

/**
 * Process regular order (thuê tài khoản UnlockTool, Vietmap, etc.)
 */
function processRegularOrder($trackingCode, $amount) {
    $order = DB::table('orders')
        ->where('order_code', $trackingCode)
        ->where('status', 'pending')
        ->first();
    
    if (!$order) {
        Log::info("Pay2s: Order not found or already processed: $trackingCode");
        return;
    }
    
    // Verify amount
    if ($amount < $order->total_amount * 0.99) {
        Log::warning("Pay2s: Amount mismatch for $trackingCode. Expected: {$order->total_amount}, Got: $amount");
        return;
    }
    
    // Mark as paid and assign account
    DB::beginTransaction();
    try {
        // Get available account
        $account = DB::table('accounts')
            ->where('service_type', $order->service_type)
            ->where('status', 'available')
            ->lockForUpdate()
            ->first();
        
        if (!$account) {
            Log::warning("Pay2s: No available account for order $trackingCode");
            DB::table('orders')->where('id', $order->id)->update([
                'status' => 'paid',
                'paid_at' => now(),
                'note' => 'Đã thanh toán - Chờ cấp tài khoản',
            ]);
            DB::commit();
            return;
        }
        
        // Assign account
        DB::table('accounts')->where('id', $account->id)->update([
            'status' => 'in_use',
            'order_id' => $order->id,
            'used_at' => now(),
        ]);
        
        // Update order
        DB::table('orders')->where('id', $order->id)->update([
            'status' => 'completed',
            'account_id' => $account->id,
            'paid_at' => now(),
            'completed_at' => now(),
        ]);
        
        // Add loyalty points to user
        if ($order->user_id) {
            $points = floor($order->total_amount / 1000); // 1 point per 1000 VND
            DB::table('users')->where('id', $order->user_id)->increment('loyalty_points', $points);
        }
        
        DB::commit();
        Log::info("Pay2s: Order completed: $trackingCode, assigned account: {$account->id}");
        
    } catch (Exception $e) {
        DB::rollBack();
        Log::error("Pay2s: Error processing order $trackingCode: " . $e->getMessage());
    }
}
