<?php
// Read last error from Laravel log - extract actual error messages
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    // Find all error lines with timestamps
    preg_match_all('/\[\d{4}-\d{2}-\d{2}.*?\] \w+\.\w+: (.+?)(?=\n\[|\n#|$)/s', $content, $matches);
    if (!empty($matches[0])) {
        // Get last 3 errors
        $lastErrors = array_slice($matches[0], -3);
        foreach ($lastErrors as $error) {
            // Only first 500 chars of each
            echo htmlspecialchars(substr($error, 0, 500)) . "\n\n---\n\n";
        }
    } else {
        echo "No error patterns found.\nLast 1000 chars:\n";
        echo htmlspecialchars(substr($content, -1000));
    }
} else {
    echo "No log file found";
}
