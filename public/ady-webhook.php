<?php
/**
 * ADY-Unlocker Webhook Handler for Laravel
 * Receives order completion notifications from ADY
 * 
 * Endpoint: https://thuetaikhoan.net/ady-webhook.php
 */

header('Content-Type: application/json');
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log file
$logFile = __DIR__ . '/../storage/logs/ady-webhook.log';

// Log raw body
$raw = file_get_contents('php://input');
file_put_contents($logFile, date('Y-m-d H:i:s') . " | RAW: " . $raw . "\n", FILE_APPEND);

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Services\AdyService;

// Parse JSON
$data = json_decode($raw, true);
if (!$data) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | Invalid JSON\n", FILE_APPEND);
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Invalid JSON']);
    exit;
}

// Handle webhook
try {
    $adyService = new AdyService();
    $result = $adyService->handleWebhook($data);
    
    if ($result['success']) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " | PROCESSED: Order #{$result['order_id']}, Status: {$result['status']}\n", FILE_APPEND);
        echo json_encode(['ok' => true, 'order_id' => $result['order_id']]);
    } else {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " | ERROR: {$result['error']}\n", FILE_APPEND);
        echo json_encode(['ok' => false, 'message' => $result['error']]);
    }
} catch (Exception $e) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Server error']);
}
