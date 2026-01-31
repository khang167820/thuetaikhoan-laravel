<?php
/**
 * Check Orders Table Structure
 */

chdir(dirname(__DIR__));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "<h1>Database Structure Check</h1>";
echo "<pre style='background:#222;color:#0f0;padding:20px;font-size:12px;'>";

// List all tables
echo "=== ALL TABLES ===\n";
$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "- $tableName\n";
}

echo "\n=== ORDERS TABLE STRUCTURE ===\n";
if (Schema::hasTable('orders')) {
    $columns = DB::select('DESCRIBE orders');
    foreach ($columns as $col) {
        echo "{$col->Field} | {$col->Type} | {$col->Null} | {$col->Key}\n";
    }
} else {
    echo "Table 'orders' does not exist!\n";
}

echo "\n=== SAMPLE ORDERS DATA ===\n";
if (Schema::hasTable('orders')) {
    $orders = DB::table('orders')->limit(3)->get();
    print_r($orders->toArray());
}

echo "</pre>";
