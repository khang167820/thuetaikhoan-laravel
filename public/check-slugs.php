<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

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

$dbSlugs = DB::table('blog_posts')->pluck('slug')->toArray();

$missing = [];
$found = [];
foreach ($indexedSlugs as $slug) {
    if (in_array($slug, $dbSlugs)) {
        $found[] = $slug;
    } else {
        $missing[] = $slug;
    }
}

echo "FOUND: " . count($found) . "\n";
echo "MISSING: " . count($missing) . "\n\n";

if (!empty($missing)) {
    echo "MISSING SLUGS (404):\n";
    foreach ($missing as $s) {
        echo "  /blog/{$s}\n";
    }
}
