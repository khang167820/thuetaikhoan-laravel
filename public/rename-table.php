<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    DB::statement('RENAME TABLE admins TO admin');
    echo "✅ Table 'admins' renamed to 'admin' successfully!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
