<?php
// Clear ALL caches and verify blade content
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// 1. Clear all
Artisan::call('view:clear');
echo "1. Views cleared\n";
Artisan::call('cache:clear');
echo "2. Cache cleared\n";
Artisan::call('route:clear');
echo "3. Routes cleared\n";
Artisan::call('config:clear');
echo "4. Config cleared\n";

// 2. Check blade file content
$blade = file_get_contents(resource_path('views/admin/accounts/index.blade.php'));

// Check for old form-based toggle
if (strpos($blade, "route('admin.accounts.toggle'") !== false) {
    echo "❌ OLD toggle form still in blade!\n";
} else {
    echo "✅ Old toggle form removed\n";
}

// Check for new JS toggle  
if (strpos($blade, 'toggleSelect(this)') !== false) {
    echo "✅ New toggleSelect onclick found\n";
} else {
    echo "❌ toggleSelect onclick NOT found!\n";
}

// Check CSS colors
if (strpos($blade, '#ef4444') !== false) {
    echo "✅ Red color for Dang thue found\n";
} else {
    echo "❌ Red color NOT found (still old blue?)\n";
}
if (strpos($blade, '#22c55e') !== false) {
    echo "✅ Green color for Cho thue found\n";
} else {
    echo "❌ Green color NOT found\n";
}

// 3. Re-cache
Artisan::call('config:cache');
Artisan::call('route:cache');
echo "\n5. Config + Routes re-cached\n";
echo "Done! Try reloading the page now.\n";
