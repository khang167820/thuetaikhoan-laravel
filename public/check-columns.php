<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::select("SHOW COLUMNS FROM accounts");
echo "Columns in 'accounts' table:\n";
foreach ($columns as $col) {
    echo "  - {$col->Field} ({$col->Type})" . ($col->Null === 'YES' ? ' NULL' : ' NOT NULL') . "\n";
}

// Check specifically for expires_at
$hasExpires = collect($columns)->contains(fn($c) => $c->Field === 'expires_at');
echo "\nexpires_at column: " . ($hasExpires ? "✅ EXISTS" : "❌ MISSING - need to add!");
