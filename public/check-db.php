<?php
// Quick DB diagnostic - no framework needed
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    foreach (file($envFile) as $line) {
        $line = trim($line);
        if ($line && $line[0] !== '#' && strpos($line, '=') !== false) {
            list($key, $val) = explode('=', $line, 2);
            $env[trim($key)] = trim($val);
        }
    }
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$db = $env['DB_DATABASE'] ?? '';  
$user = $env['DB_USERNAME'] ?? '';
$pass = $env['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    
    echo "<h2>Accounts Table Columns</h2>";
    $cols = $pdo->query("SHOW COLUMNS FROM accounts")->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
    foreach ($cols as $col) {
        echo "<tr><td>{$col['Field']}</td><td>{$col['Type']}</td><td>{$col['Null']}</td><td>{$col['Default']}</td></tr>";
    }
    echo "</table>";
    
    echo "<h2>Git Info</h2>";
    echo "<pre>" . shell_exec('cd ' . dirname(__DIR__) . ' && git log -1 --oneline 2>&1') . "</pre>";
    
    echo "<h2>Last 30 lines of error log</h2>";
    $logFile = dirname(__DIR__) . '/storage/logs/laravel.log';
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lastLines = array_slice($lines, -30);
        echo "<pre>";
        foreach ($lastLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    } else {
        echo "No log file found";
    }
} catch (Exception $e) {
    echo "DB Error: " . $e->getMessage();
}
