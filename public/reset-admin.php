<?php
/**
 * Reset Admin Password
 */

chdir(dirname(__DIR__));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "<h1>Reset Admin Password</h1>";

// New password
$newPassword = 'Tkk123@';
$hashedPassword = Hash::make($newPassword);

try {
    // Check if admin exists
    $admin = DB::table('admins')->where('username', 'admin')->first();
    
    if ($admin) {
        // Update password
        DB::table('admins')
            ->where('username', 'admin')
            ->update(['password' => $hashedPassword]);
        
        echo "<pre style='background:#222;color:#0f0;padding:20px;'>";
        echo "✅ Password for 'admin' has been reset!\n\n";
        echo "Username: admin\n";
        echo "Password: $newPassword\n";
        echo "</pre>";
    } else {
        // Create admin if not exists
        DB::table('admins')->insert([
            'username' => 'admin',
            'password' => $hashedPassword,
            'name' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "<pre style='background:#222;color:#0f0;padding:20px;'>";
        echo "✅ Admin account created!\n\n";
        echo "Username: admin\n";
        echo "Password: $newPassword\n";
        echo "</pre>";
    }
} catch (Exception $e) {
    echo "<pre style='background:#222;color:#f00;padding:20px;'>";
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "</pre>";
}

echo "<p><a href='/admin/login'>← Try Admin Login</a></p>";
echo "<p style='color:red'>⚠️ DELETE this file after use!</p>";
