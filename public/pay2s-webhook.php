<?php
/**
 * Pay2s Webhook Handler
 * URL: https://thuetaikhoan.net/pay2s-webhook.php
 */

header('Content-Type: application/json');

// Log all requests for debugging
$logFile = __DIR__ . '/../storage/logs/pay2s-webhook.log';
$input = file_get_contents('php://input');
$headers = json_encode(getallheaders());
$logEntry = "\n=== " . date('Y-m-d H:i:s') . " ===\n";
$logEntry .= "Headers: $headers\n";
$logEntry .= "Body: $input\n";
@file_put_contents($logFile, $logEntry, FILE_APPEND);

// Parse input
$data = json_decode($input, true);

// If no transactions, return success immediately
if (empty($data['transactions']) || !is_array($data['transactions'])) {
    echo json_encode(['success' => true, 'message' => 'No transactions']);
    exit;
}

// Bootstrap Laravel for database access
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
} catch (Exception $e) {
    @file_put_contents($logFile, "Bootstrap Error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => 'Bootstrap failed']);
    exit;
}

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

foreach ($data['transactions'] as $tx) {
    try {
        $content = $tx['content'] ?? '';
        $amount = (int)($tx['transferAmount'] ?? 0);
        $type = $tx['transferType'] ?? '';
        
        // Only process incoming transfers
        if ($type !== 'IN') {
            Log::info("Pay2s: Skipping non-IN transaction: $type");
            continue;
        }
        
        // Extract tracking code (GHxxxxxx or ADYxxxxxx format)
        preg_match('/(GH\d+|ADY\d+)/i', $content, $matches);
        $trackingCode = strtoupper($matches[1] ?? '');
        
        if (empty($trackingCode)) {
            Log::info("Pay2s: No tracking code in content: $content");
            continue;
        }
        
        Log::info("Pay2s: Processing $trackingCode, amount: $amount");
        
        // Check ADY orders first
        $adyOrder = DB::table('ady_orders')
            ->where('tracking_code', $trackingCode)
            ->where('status', 'pending')
            ->first();
            
        if ($adyOrder) {
            processAdyOrder($adyOrder, $amount);
        } else {
            // Check regular orders
            processRegularOrder($trackingCode, $amount);
        }
        
    } catch (Exception $e) {
        Log::error("Pay2s Error: " . $e->getMessage());
    }
}

echo json_encode(['success' => true]);
exit;

/**
 * Process ADY order
 */
function processAdyOrder($order, $amount) {
    // Verify amount (allow 1% tolerance)
    if ($amount < $order->price_vnd * 0.99) {
        Log::warning("Pay2s: Amount mismatch for {$order->tracking_code}. Expected: {$order->price_vnd}, Got: $amount");
        return;
    }
    
    // Mark as paid
    DB::table('ady_orders')->where('id', $order->id)->update([
        'status' => 'paid',
        'paid_at' => now(),
    ]);
    
    Log::info("Pay2s: Order {$order->tracking_code} marked as paid");
    
    // Call ADY API
    try {
        $adyService = app(\App\Services\AdyService::class);
        $fields = json_decode($order->fields, true) ?? [];
        $feedbackUrl = url('/ady-webhook.php');
        
        Log::info("Pay2s: Calling ADY for {$order->tracking_code}", [
            'product_uuid' => $order->product_uuid,
            'fields' => $fields
        ]);
        
        $result = $adyService->placeOrder(
            $order->product_uuid,
            $fields,
            $order->tracking_code,
            $feedbackUrl
        );
        
        Log::info("Pay2s: ADY Response for {$order->tracking_code}", ['result' => $result]);
        
        if ($result['success']) {
            DB::table('ady_orders')->where('id', $order->id)->update([
                'ady_order_uuid' => $result['order_uuid'] ?? null,
                'status' => 'processing',
            ]);
            Log::info("Pay2s: ADY order placed: {$order->tracking_code}");
        } else {
            $errorMsg = $result['error'] ?? 'Unknown';
            if (isset($result['response'])) {
                $errorMsg .= ' - ' . $result['response'];
            }
            DB::table('ady_orders')->where('id', $order->id)->update([
                'status' => 'failed',
                'error' => substr($errorMsg, 0, 500),
            ]);
            Log::error("Pay2s: ADY failed: $errorMsg");
        }
    } catch (Exception $e) {
        Log::error("Pay2s: ADY API error: " . $e->getMessage());
        DB::table('ady_orders')->where('id', $order->id)->update([
            'status' => 'failed',
            'error' => $e->getMessage(),
        ]);
    }
}

/**
 * Process regular order
 */
function processRegularOrder($trackingCode, $amount) {
    $order = DB::table('orders')
        ->where('tracking_code', $trackingCode)
        ->where('status', 'pending')
        ->first();
    
    if (!$order) {
        Log::info("Pay2s: No pending order found: $trackingCode");
        return;
    }
    
    // Verify amount
    if ($amount < $order->total_amount * 0.99) {
        Log::warning("Pay2s: Amount mismatch for $trackingCode");
        return;
    }
    
    DB::beginTransaction();
    try {
        // Get available account
        $account = DB::table('accounts')
            ->where('service_type', $order->service_type)
            ->where('status', 'available')
            ->lockForUpdate()
            ->first();
        
        if (!$account) {
            DB::table('orders')->where('id', $order->id)->update([
                'status' => 'paid',
                'paid_at' => now(),
                'note' => 'Đã TT - Chờ cấp account',
            ]);
            DB::commit();
            Log::warning("Pay2s: No account available for $trackingCode");
            return;
        }
        
        // Assign
        DB::table('accounts')->where('id', $account->id)->update([
            'status' => 'in_use',
            'order_id' => $order->id,
            'used_at' => now(),
        ]);
        
        DB::table('orders')->where('id', $order->id)->update([
            'status' => 'completed',
            'account_id' => $account->id,
            'paid_at' => now(),
            'completed_at' => now(),
        ]);
        
        DB::commit();
        Log::info("Pay2s: Order $trackingCode completed");
        
    } catch (Exception $e) {
        DB::rollBack();
        Log::error("Pay2s: Error: " . $e->getMessage());
    }
}
