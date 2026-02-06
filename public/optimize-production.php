<?php
/**
 * Production Optimization Script
 * Run after deploy: https://thuetaikhoan.net/optimize-production.php?key=YOUR_SECRET_KEY
 */

// Security key - change this!
$secretKey = 'thuetaikhoan2026-optimize';

if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    http_response_code(403);
    die('Forbidden - Invalid key');
}

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h1>🚀 Production Optimization</h1>";
echo "<pre>";

// Clear all caches first
echo "Clearing caches...\n";
$kernel->call('cache:clear');
echo "✅ Cache cleared\n";

$kernel->call('config:clear');
echo "✅ Config cache cleared\n";

$kernel->call('route:clear');
echo "✅ Route cache cleared\n";

$kernel->call('view:clear');
echo "✅ View cache cleared\n";

// Rebuild optimized caches
echo "\nRebuilding optimized caches...\n";

$kernel->call('config:cache');
echo "✅ Config cached\n";

$kernel->call('route:cache');
echo "✅ Routes cached\n";

$kernel->call('view:cache');
echo "✅ Views cached\n";

// Optimize autoloader
echo "\nOptimizing autoloader...\n";
$kernel->call('optimize');
echo "✅ Autoloader optimized\n";

echo "</pre>";
echo "<h2>✅ All optimizations complete!</h2>";
echo "<p>Your Laravel app is now running in optimized production mode.</p>";
echo "<p style='color:red'><strong>Security: Consider deleting this file or changing the secret key!</strong></p>";
