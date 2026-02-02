<?php
/**
 * Clear Laravel Cache
 * Access via: /clear-cache.php
 */

// Bootstrap Laravel - adjust path for public folder
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h1>🧹 Clear Cache</h1>";
echo "<pre>";

try {
    // Clear view cache
    Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "✅ View cache cleared\n";
    
    // Clear config cache
    Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "✅ Config cache cleared\n";
    
    // Clear route cache  
    Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "✅ Route cache cleared\n";
    
    // Clear application cache
    Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "✅ Application cache cleared\n";
    
    echo "\n✅ ALL CACHES CLEARED SUCCESSFULLY!\n";
    echo "\n👉 Refresh your browser (Ctrl + F5) to see changes.";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "</pre>";
