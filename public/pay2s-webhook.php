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
use Illuminate\Support\Facades\Schema;

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
        
        // Extract tracking code (GH/DH/ADY/NAP format)
        preg_match('/(GH\d+|DH\d+|ADY\d+|NAP\d+)/i', $content, $matches);
        $trackingCode = strtoupper($matches[1] ?? '');
        
        if (empty($trackingCode)) {
            Log::info("Pay2s: No tracking code in content: $content");
            continue;
        }
        
        Log::info("Pay2s: Processing $trackingCode, amount: $amount");
        
        // Handle deposit (NAP prefix)
        if (str_starts_with($trackingCode, 'NAP')) {
            processDeposit($trackingCode, $amount);
            continue;
        }
        
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
    if ($amount < $order->amount * 0.99) {
        Log::warning("Pay2s: Amount mismatch for $trackingCode. Expected: {$order->amount}, Got: $amount");
        return;
    }
    
    // First mark as paid
    DB::table('orders')->where('id', $order->id)->update([
        'status' => 'paid',
        'paid_at' => now(),
    ]);
    Log::info("Pay2s: Order $trackingCode marked as paid");
    
    // Try to allocate account using the proper service
    try {
        $orderModel = \App\Models\Order::find($order->id);
        if ($orderModel) {
            $result = \App\Services\AccountAllocationService::allocateAccount($orderModel);
            if ($result['success']) {
                Log::info("Pay2s: Order $trackingCode completed with account #{$result['account']->id}");
            } else {
                Log::warning("Pay2s: No account available for $trackingCode: " . ($result['error'] ?? 'Unknown'));
            }
        }
    } catch (Exception $e) {
        Log::error("Pay2s: Allocation error for $trackingCode: " . $e->getMessage());
    }
}

/**
 * Process deposit (NAP prefix)
 * Code format: NAP{user_id}{ddmmyy} or NAP{timestamp}{user_id}
 */
function processDeposit($trackingCode, $amount) {
    if ($amount <= 0) {
        Log::info("Pay2s: Skipping deposit $trackingCode - zero amount");
        return;
    }
    
    // Check if this deposit was already processed (prevent double credit)
    if (Schema::hasTable('deposits')) {
        $existing = DB::table('deposits')
            ->where('transaction_id', $trackingCode)
            ->where('status', 'completed')
            ->exists();
        
        if ($existing) {
            Log::info("Pay2s: Deposit $trackingCode already processed");
            return;
        }
    }
    
    // Try to find pending deposit by transaction_id
    $deposit = null;
    if (Schema::hasTable('deposits')) {
        $deposit = DB::table('deposits')
            ->where('transaction_id', $trackingCode)
            ->where('status', 'pending')
            ->first();
    }
    
    if ($deposit) {
        // Credit user balance
        DB::table('users')->where('id', $deposit->user_id)->increment('balance', $amount);
        
        // Mark deposit as completed
        DB::table('deposits')->where('id', $deposit->id)->update([
            'status' => 'completed',
            'amount' => $amount,
            'updated_at' => now(),
        ]);
        
        Log::info("Pay2s: Deposit $trackingCode completed for user #{$deposit->user_id}, amount: $amount");
    } else {
        // No pending deposit found - try to extract user_id from code
        // Format: NAP{user_id}{ddmmyy} e.g. NAP1070226
        // Extract user_id: strip NAP prefix and last 6 digits (date)
        $codeBody = substr($trackingCode, 3); // Remove NAP
        
        // Try format: NAP + timestamp + user_id (e.g. NAP17386547231)
        // Or format: NAP + user_id + ddmmyy (e.g. NAP1070226)
        // We'll try to find user by searching recent pending deposits
        Log::warning("Pay2s: No pending deposit found for $trackingCode, amount: $amount. Manual review needed.");
    }
}
