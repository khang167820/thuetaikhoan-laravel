<?php
// fix-accounts-available-since.php
// Script to add available_since column to accounts table

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "<h1>Adding available_since column...</h1>";

try {
    $table = 'accounts';
    
    if (Schema::hasTable($table)) {
        Schema::table($table, function (Blueprint $table) {
            if (!Schema::hasColumn('accounts', 'available_since')) {
                $table->timestamp('available_since')->nullable()->after('is_available');
                echo "✅ Added 'available_since' column.<br>";
            } else {
                echo "ℹ️ 'available_since' column already exists.<br>";
            }
        });
        
        // Set available_since for currently available accounts that don't have it set
        $updated = DB::table('accounts')
            ->where('is_available', 1)
            ->whereNull('available_since')
            ->update(['available_since' => now()]);
        
        echo "✅ Updated {$updated} accounts with available_since = now().<br>";
        echo "<h3 style='color:green'>Done!</h3>";
    } else {
        echo "<h3 style='color:red'>Error: Table 'accounts' not found!</h3>";
    }
} catch (\Exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
