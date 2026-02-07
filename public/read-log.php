<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    preg_match_all('/\[\d{4}-\d{2}-\d{2}.*?\] \w+\.\w+: (.+?)(?=\n\[|\n#|$)/s', $content, $matches);
    if (!empty($matches[0])) {
        $lastErrors = array_slice($matches[0], -3);
        foreach ($lastErrors as $error) {
            echo htmlspecialchars(substr($error, 0, 500)) . "\n\n---\n\n";
        }
    } else {
        echo "Last 1000:\n" . htmlspecialchars(substr($content, -1000));
    }
}
