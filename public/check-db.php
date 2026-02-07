<?php
// Check accounts table columns
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    $columns = Illuminate\Support\Facades\Schema::getColumnListing('accounts');
    echo "<h2>Accounts Table Columns</h2>";
    echo "<pre>" . print_r($columns, true) . "</pre>";
    
    echo "<h2>Last Git Commit</h2>";
    echo "<pre>" . shell_exec('cd ' . base_path() . ' && git log -1 --oneline 2>&1') . "</pre>";
    
    echo "<h2>Latest Error (first 5 lines)</h2>";
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lastLines = array_slice($lines, -20);
        echo "<pre>";
        foreach ($lastLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
