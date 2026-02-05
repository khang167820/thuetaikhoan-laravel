<?php
/**
 * Pay2S Webhook for Laravel
 * Handles deposit notifications from Pay2S.vn
 * 
 * Endpoint: https://staging.thuetaikhoan.net/pay2s-webhook.php
 * Configure this URL in Pay2S dashboard
 */

header('Content-Type: application/json');
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/../storage/logs/pay2s-webhook.log';

// Log raw body
$raw = file_get_contents('php://input');
file_put_contents($logFile, date('Y-m-d H:i:s') . " | RAW: " . $raw . "\n", FILE_APPEND);

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Webhook secret (configure in .env as PAY2S_SECRET)
$webhookSecret = env('PAY2S_SECRET', '');

// Verify token
$auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (preg_match('/^\s*Bearer\s+(.+)$/i', $auth, $m)) {
    $tokenHeader = trim($m[1]);
} else {
    $tokenHeader = $_SERVER['HTTP_X_TOKEN'] ?? $_SERVER['HTTP_X_WEBHOOK_TOKEN'] ?? '';
}

if (!empty($webhookSecret) && $tokenHeader !== $webhookSecret) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | UNAUTHORIZED\n", FILE_APPEND);
    http_response_code(401);
    echo json_encode(['ok' => false, 'message' => 'Unauthorized']);
    exit;
}

// Parse JSON
$data = json_decode($raw, true);
if (!$data) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | Invalid JSON\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Invalid JSON']);
    exit;
}

// Handle both formats
$txList = [];
if (isset($data['transactions']) && is_array($data['transactions'])) {
    $txList = $data['transactions'];
} else {
    $txList[] = [
        'transferType' => $data['transferType'] ?? 'IN',
        'transferAmount' => $data['amount'] ?? 0,
        'content' => $data['comment'] ?? ($data['content'] ?? ''),
    ];
}

$updated = [];

foreach ($txList as $tx) {
    // Only process incoming transfers
    if (strtoupper($tx['transferType'] ?? 'IN') !== 'IN') {
        continue;
    }

    $amount = (int)($tx['transferAmount'] ?? 0);
    $content = trim($tx['content'] ?? '');

    if ($amount <= 0 || $content === '') {
        continue;
    }

    // Extract tracking code
    $tracking = '';
    if (preg_match('/(NAP\d+)/i', $content, $m)) {
        $tracking = strtoupper($m[1]);
    }

    file_put_contents($logFile, date('Y-m-d H:i:s') . " | PARSED: tracking={$tracking}, amount={$amount}\n", FILE_APPEND);

    if (empty($tracking)) {
        continue;
    }

    // Handle deposit (NAP...)
    if (preg_match('/^NAP/i', $tracking)) {
        try {
            DB::beginTransaction();

            // Find pending deposit
            $deposit = DB::table('deposits')
                ->where('transaction_id', $tracking)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->first();

            if (!$deposit) {
                DB::rollBack();
                file_put_contents($logFile, date('Y-m-d H:i:s') . " | DEPOSIT NOT FOUND: {$tracking}\n", FILE_APPEND);
                continue;
            }

            // Check amount
            if ($amount < $deposit->amount) {
                DB::rollBack();
                file_put_contents($logFile, date('Y-m-d H:i:s') . " | UNDERPAID: Expected {$deposit->amount}, Got {$amount}\n", FILE_APPEND);
                continue;
            }

            // Update deposit status
            DB::table('deposits')
                ->where('id', $deposit->id)
                ->update([
                    'status' => 'success',
                    'updated_at' => now()
                ]);

            // Add balance to user
            DB::table('users')
                ->where('id', $deposit->user_id)
                ->increment('balance', $amount);

            // Update total_deposit if column exists
            try {
                DB::table('users')
                    ->where('id', $deposit->user_id)
                    ->increment('total_deposit', $amount);
            } catch (\Exception $e) {
                // Column might not exist
            }

            DB::commit();

            $updated[] = [
                'type' => 'deposit',
                'deposit_id' => $deposit->id,
                'user_id' => $deposit->user_id,
                'amount' => $amount,
                'status' => 'completed'
            ];

            file_put_contents($logFile, date('Y-m-d H:i:s') . " | DEPOSIT COMPLETED: ID={$deposit->id}, Amount={$amount}\n", FILE_APPEND);

        } catch (\Exception $e) {
            DB::rollBack();
            file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }
}

echo json_encode(['ok' => true, 'updated' => $updated]);
