<?php
// One-time migration: Add password_changed column if not exists
// DELETE THIS FILE AFTER RUNNING

try {
    $host = '127.0.0.1';
    $db = 'u620980434_thuetaikhoan';
    $user = 'u620980434_root';
    $pass = 'Kh@ng1678';
    
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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
