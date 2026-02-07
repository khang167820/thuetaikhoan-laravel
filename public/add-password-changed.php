<?php
// One-time migration: Add password_changed column if not exists
// DELETE THIS FILE AFTER RUNNING

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $pdo = DB::connection()->getPdo();
    
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM accounts LIKE 'password_changed'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Column 'password_changed' already exists!\n";
    } else {
        $pdo->exec("ALTER TABLE accounts ADD COLUMN password_changed TINYINT(1) NOT NULL DEFAULT 0 AFTER note_date");
        echo "✅ Column 'password_changed' added successfully!\n";
    }
    
    // Verify
    $stmt = $pdo->query("SHOW COLUMNS FROM accounts LIKE 'password_changed'");
    $col = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Column info: " . json_encode($col);
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
