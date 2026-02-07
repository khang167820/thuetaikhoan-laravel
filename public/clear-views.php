<?php
// Clear view cache and check rendered page
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Clear all caches
Artisan::call('view:clear');
echo "Views cleared: " . Artisan::output();
Artisan::call('cache:clear');
echo "Cache cleared: " . Artisan::output();
Artisan::call('route:clear');
echo "Routes cleared: " . Artisan::output();

// Check if the blade file has the toggleSelect function
$bladeFile = resource_path('views/admin/accounts/index.blade.php');
$content = file_get_contents($bladeFile);
if (strpos($content, 'toggleSelect') !== false) {
    echo "✅ toggleSelect found in blade file\n";
} else {
    echo "❌ toggleSelect NOT found in blade file\n";
}
if (strpos($content, 'batch-toggle') !== false) {
    echo "✅ batch-toggle found in blade file\n";
} else {
    echo "❌ batch-toggle NOT found in blade file\n";
}

// Check compiled views
$viewsDir = storage_path('framework/views');
$files = glob($viewsDir . '/*.php');
echo "\nCompiled views: " . count($files) . " files\n";
