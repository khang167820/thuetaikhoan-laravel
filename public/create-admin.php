<?php
/**
 * Create Admins Table & Admin User
 */

chdir(dirname(__DIR__));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "<h1>Create Admins Table</h1>";
echo "<pre style='background:#222;color:#0f0;padding:20px;'>";

try {
    // Create admins table if not exists
    if (!Schema::hasTable('admins')) {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        echo "✅ Table 'admins' created!\n";
    } else {
        echo "ℹ️ Table 'admins' already exists.\n";
    }
    
    // Create admin user
    $password = 'Tkk123@';
    $hashedPassword = Hash::make($password);
    
    $admin = DB::table('admins')->where('username', 'admin')->first();
    
    if ($admin) {
        DB::table('admins')->where('username', 'admin')->update([
            'password' => $hashedPassword,
            'updated_at' => now()
        ]);
        echo "✅ Admin password updated!\n";
    } else {
        DB::table('admins')->insert([
            'username' => 'admin',
            'password' => $hashedPassword,
            'name' => 'Administrator',
            'email' => 'admin@thuetaikhoan.net',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ Admin user created!\n";
    }
    
    echo "\n=============================\n";
    echo "Username: admin\n";
    echo "Password: $password\n";
    echo "=============================\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p><a href='/admin/login'>← Try Admin Login</a></p>";
echo "<p style='color:red'>⚠️ DELETE this file after use!</p>";
