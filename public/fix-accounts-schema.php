<?php
// fix-accounts-schema.php
// Script to add missing columns to accounts table

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "<h1>Fixing Accounts Table Schema...</h1>";

try {
    $table = 'accounts';
    
    if (Schema::hasTable($table)) {
        Schema::table($table, function (Blueprint $table) {
            // Check and add 'note'
            if (!Schema::hasColumn('accounts', 'note')) {
                $table->text('note')->nullable()->after('password');
                echo "✅ Added 'note' column.<br>";
            } else {
                echo "ℹ️ 'note' column already exists.<br>";
            }
            
            // Check and add 'note_date'
            if (!Schema::hasColumn('accounts', 'note_date')) {
                $table->date('note_date')->nullable()->after('note');
                echo "✅ Added 'note_date' column.<br>";
            } else {
                echo "ℹ️ 'note_date' column already exists.<br>";
            }
            
            // Check and add 'type'
            if (!Schema::hasColumn('accounts', 'type')) {
                $table->string('type', 50)->nullable()->after('id');
                echo "✅ Added 'type' column.<br>";
            } else {
                echo "ℹ️ 'type' column already exists.<br>";
            }
        });
        
        echo "<h3 style='color:green'>Done! Table schema updated.</h3>";
    } else {
        echo "<h3 style='color:red'>Error: Table 'accounts' not found!</h3>";
    }
} catch (\Exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
