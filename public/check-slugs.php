<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$missing = [
    'testpoint-edl9008-samsung-galaxy-s205',
    'testpoint-edl9008-samsung-galaxy-m22-sm-m225f',
    'testpoint-edl9008-xiaomi-mi-8',
    'testpoint-edl9008-samsung-galaxy-a01-core-sm-a015',
    'testpoint-edl9008-samsung-galaxy-a31-sm-a315f',
    'testpoint-edl9008-samsung-galaxy-a34-sm-a345e',
    'testpoint-edl9008-samsung-galaxy-a04e-sn-a047',
    'android-multitool-anti-thuong-cam-2026',
    'testpoint-edl9008-xiaomi-redmi-note-8t',
    'testpoint-edl9008-xiaomi-redmi-7a',
    'huong-dan-kg-killer-2026',
];

// Search for similar slugs in DB
foreach ($missing as $slug) {
    // Extract key part for searching
    $parts = explode('-', $slug);
    $keyword = implode('-', array_slice($parts, 0, min(4, count($parts))));
    
    $similar = DB::table('blog_posts')
        ->where('slug', 'LIKE', "%{$keyword}%")
        ->pluck('slug')
        ->toArray();
    
    echo "MISSING: {$slug}\n";
    if (!empty($similar)) {
        echo "  SIMILAR: " . implode(', ', $similar) . "\n";
    } else {
        echo "  NO SIMILAR FOUND\n";
    }
    echo "\n";
}
