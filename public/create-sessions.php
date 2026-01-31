<?php
/**
 * Create Sessions Table Only
 */

chdir(dirname(__DIR__));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "<h1>Create Sessions Table</h1>";
echo "<pre style='background:#222;color:#0f0;padding:20px;'>";

try {
    if (!Schema::hasTable('sessions')) {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        echo "✅ Table 'sessions' created successfully!\n";
    } else {
        echo "ℹ️ Table 'sessions' already exists.\n";
    }
    
    // Also create cache table if needed
    if (!Schema::hasTable('cache')) {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });
        echo "✅ Table 'cache' created successfully!\n";
    }
    
    if (!Schema::hasTable('cache_locks')) {
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
        echo "✅ Table 'cache_locks' created successfully!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p><a href='/'>← Try Homepage</a> | <a href='/admin/login'>Try Admin Login</a></p>";
echo "<p style='color:red'>⚠️ DELETE this file after use!</p>";
