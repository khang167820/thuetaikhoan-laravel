<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$prices = DB::table('prices')->orderBy('type')->orderBy('hours')->get();

$grouped = [];
foreach ($prices as $p) {
    $grouped[$p->type][] = [
        'hours' => $p->hours,
        'price' => $p->price,
        'original_price' => $p->original_price,
        'discount_percent' => $p->discount_percent,
        'promo_label' => $p->promo_label,
        'promo_badge' => $p->promo_badge,
    ];
}

header('Content-Type: application/json');
echo json_encode($grouped, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
