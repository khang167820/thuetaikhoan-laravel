<?php
/**
 * ADY-Unlocker Webhook Handler for Laravel
 * Receives order completion notifications from ADY
 * 
 * SECURITY:
 * - Only accepts requests with valid order references in database
 * - Logs all requests for audit trail
 * - Does not reveal sensitive info in error messages
 * 
 * Endpoint: https://thuetaikhoan.net/ady-webhook.php
 */

header('Content-Type: application/json');
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Log directory
$logDir = __DIR__ . '/../storage/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
$logFile = $logDir . '/ady-webhook.log';

// Helper function to log
function logWebhook($message) {
    global $logFile;
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " | IP: {$ip} | {$message}\n", FILE_APPEND);
}

// Rate limiting - Max 10 requests per minute per IP
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rateLimitFile = $logDir . '/webhook_rate_' . md5($ip) . '.tmp';
$rateLimitWindow = 60; // seconds
$maxRequests = 10;

$now = time();
$requests = [];
if (file_exists($rateLimitFile)) {
    $data = json_decode(file_get_contents($rateLimitFile), true);
    if (is_array($data)) {
        $requests = array_filter($data, fn($t) => $t > ($now - $rateLimitWindow));
    }
}

if (count($requests) >= $maxRequests) {
    logWebhook("RATE_LIMITED");
    http_response_code(429);
    echo json_encode(['ok' => false, 'message' => 'Too many requests']);
    exit;
}

$requests[] = $now;
file_put_contents($rateLimitFile, json_encode($requests));

// Log raw body
$raw = file_get_contents('php://input');
logWebhook("RAW: " . substr($raw, 0, 500)); // Only log first 500 chars for security

// Parse JSON
$data = json_decode($raw, true);
if (!$data) {
    logWebhook("Invalid JSON");
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Invalid JSON']);
    exit;
}

// Validate required fields - must have reference_id or order_id
if (empty($data['reference_id']) && empty($data['order_id'])) {
    logWebhook("Missing order identifiers");
    http_response_code(400);
    echo json_encode(['ok' => false, 'message' => 'Invalid request']);
    exit;
}

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Services\AdyService;
use Illuminate\Support\Facades\DB;

// SECURITY: Verify that the order exists in our database before processing
// This prevents attackers from injecting fake webhook data
$order = null;
if (!empty($data['reference_id'])) {
    $order = DB::table('ady_orders')->where('tracking_code', $data['reference_id'])->first();
}
if (!$order && !empty($data['order_id'])) {
    $order = DB::table('ady_orders')->where('ady_order_uuid', $data['order_id'])->first();
}

if (!$order) {
    // Order not found in our database - could be fake webhook
    logWebhook("ORDER_NOT_FOUND: ref={$data['reference_id']}, ady_id={$data['order_id']}");
    http_response_code(404);
    echo json_encode(['ok' => false, 'message' => 'Order not found']);
    exit;
}

// Handle webhook
try {
    $adyService = new AdyService();
    $result = $adyService->handleWebhook($data);
    
    if ($result['success']) {
        logWebhook("PROCESSED: Order #{$result['order_id']}, Status: {$result['status']}");
        echo json_encode(['ok' => true, 'order_id' => $result['order_id']]);
    } else {
        logWebhook("HANDLE_ERROR: {$result['error']}");
        echo json_encode(['ok' => false, 'message' => 'Processing failed']);
    }
} catch (Exception $e) {
    logWebhook("EXCEPTION: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Server error']);
}
