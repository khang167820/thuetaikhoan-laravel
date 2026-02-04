<?php
/**
 * Optimize Laravel Cache for Production
 * Access via: /optimize-cache.php
 * This caches config, routes, and views for better performance
 */

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h1>🚀 Optimize Cache for Production</h1>";
echo "<pre>";

try {
    // Clear existing cache first
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "✅ Application cache cleared\n";
    
    // Cache config for faster loading
    Illuminate\Support\Facades\Artisan::call('config:cache');
    echo "✅ Config cached\n";
    
    // Cache routes for faster routing
    Illuminate\Support\Facades\Artisan::call('route:cache');
    echo "✅ Routes cached\n";
    
    // Cache views for faster rendering
    Illuminate\Support\Facades\Artisan::call('view:cache');
    echo "✅ Views cached\n";
    
    // Optimize autoloader
    echo "\n📦 Optimization Notes:\n";
    echo "- Run 'composer install --optimize-autoloader --no-dev' for production\n";
    echo "- Enable OPcache in PHP for 2-3x speed boost\n";
    
    echo "\n✅ ALL OPTIMIZATIONS APPLIED!\n";
    echo "Your site should now load faster.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString();
}

echo "</pre>";
