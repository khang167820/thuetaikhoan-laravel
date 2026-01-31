<?php
/**
 * Laravel Migration Runner
 * Run this script to execute database migrations
 */

// Change to Laravel root directory
chdir(dirname(__DIR__));

// Load Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h1>Laravel Migration Runner</h1>";
echo "<pre style='background:#222;color:#0f0;padding:20px;'>";

// Run migrations
echo "Running migrations...\n\n";

try {
    $exitCode = Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();
    
    if ($exitCode === 0) {
        echo "\n✅ Migrations completed successfully!\n";
    } else {
        echo "\n❌ Migration failed with exit code: $exitCode\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";

echo "<hr>";
echo "<p><a href='/'>← Try Homepage</a> | <a href='/admin/login'>Try Admin Login</a></p>";
echo "<p style='color:red'>⚠️ DELETE this file after use! (run-migrate.php)</p>";
