<?php
// Read last error from Laravel log
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    // Get last 3000 chars
    $tail = substr($content, -3000);
    echo "<pre>" . htmlspecialchars($tail) . "</pre>";
} else {
    echo "No log file found at: " . $logFile;
}
