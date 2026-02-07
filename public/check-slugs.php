<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// All indexed blog slugs from Google Search Console (without .php)
$indexedSlugs = [
    'testpoint-edl9008-samsung-galaxy-s205',
    'testpoint-edl9008-samsung-galaxy-m22-sm-m225f',
    'testpoint-edl9008-xiaomi-mi-8',
    'testpoint-edl9008-samsung-galaxy-a01-core-sm-a015',
    'testpoint-edl9008-samsung-galaxy-a31-sm-a315f',
    'testpoint-edl9008-samsung-galaxy-a34-sm-a345e',
    'testpoint-edl9008-samsung-galaxy-a04e-sn-a047',
    'cach-mo-khoa-bootloader-android-2026',
    'cach-thue-tai-khoan-unlocktool-tai-thuetaikhoan-net',
    'android-multitool-anti-thuong-cam-2026',
    'testpoint-edl9008-xiaomi-redmi-note-8t',
    'testpoint-edl9008-xiaomi-redmi-7a',
    'mua-license-xinzhizao-gia-re',
    'mua-license-tsm-tool-pro-gia-re',
    'mua-license-phoenix-service-tool-gia-re',
    'mua-license-xyno-tool-gia-re',
    'mua-license-cdma-yemen-tool-gia-re',
    'mua-license-power-tool-auth-transfer-gia-re',
    'mua-license-auth-flash-pro-tool-aft-gia-re',
    'mua-license-cp-tool-cpt-pro-xiaomi-gia-re',
    'xoa-frp-realme-c55-c53-c51-2026',
    'mua-license-kgfixtool-gia-re',
    'mua-license-micpid-tool-gold-gia-re',
    'mua-license-bft-brutal-forensic-gia-re',
    'mua-license-guerratool-motorola-gia-re',
    'mua-license-imobiletool-gia-re',
    'mua-license-gapro-login-tool-gia-re',
    'mua-license-cheetah-lg-tool-gia-re',
    'loi-oem-unlock-missing-samsung-2026',
    'huong-dan-flash-rom-xiaomi-miflash-2026',
    'mua-license-eme-mobile-tool-gia-re',
    'mua-license-global-auth-tool-gia-re',
    'mua-license-megaunlocker-gia-re',
    'mua-license-s-tool-pro-gia-re',
    'huong-dan-kg-killer-2026',
    'mua-license-hxru-multi-auth-tool-gia-re',
    'kg-killer-tool-xoa-kg-lock-android-14',
    'top-5-tool-frp-bypass-2026',
    'top-5-tool-xoa-frp-samsung-tot-nhat-2026',
];

// Get all DB slugs
$dbSlugs = DB::table('blog_posts')->pluck('slug')->toArray();

echo "=== DB Blog Posts: " . count($dbSlugs) . " ===\n\n";

$found = 0;
$missing = 0;

echo "❌ MISSING (404) Slugs:\n";
foreach ($indexedSlugs as $slug) {
    if (!in_array($slug, $dbSlugs)) {
        $missing++;
        echo "  - {$slug}\n";
    } else {
        $found++;
    }
}

echo "\n✅ Found: {$found}\n";
echo "❌ Missing: {$missing}\n";

echo "\n=== All DB Slugs ===\n";
foreach ($dbSlugs as $s) {
    echo "  {$s}\n";
}
