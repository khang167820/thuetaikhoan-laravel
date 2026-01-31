<?php
/**
 * Fix Admin Password - Simple version
 */

chdir(dirname(__DIR__));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "<h1>Fix Admin Password</h1>";
echo "<pre style='background:#222;color:#0f0;padding:20px;'>";

try {
    $password = 'Tkk123@';
    $hashedPassword = Hash::make($password);
    
    // Update without updated_at
    DB::table('admin')->where('username', 'admin')->update([
        'password' => $hashedPassword
    ]);
    
    echo "✅ Admin password updated!\n\n";
    echo "=============================\n";
    echo "Username: admin\n";
    echo "Password: $password\n";
    echo "=============================\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p><a href='/admin/login'>← Try Admin Login</a></p>";
echo "<p style='color:red'>⚠️ DELETE this file after use!</p>";
