<?php
/**
 * Fix Missing Columns in Production Database
 * Run this ONCE on production: https://thuetaikhoan.net/fix-columns.php
 * Then DELETE this file!
 */

header('Content-Type: text/html; charset=utf-8');
echo '<h2>🔧 Fix Missing Database Columns</h2><pre>';

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$fixes = [];

// ============================================
// 1. orders table - Missing columns
// ============================================
Schema::table('orders', function ($table) use (&$fixes) {
    if (!Schema::hasColumn('orders', 'user_id')) {
        $table->unsignedBigInteger('user_id')->nullable()->after('id');
        $table->index('user_id');
        $fixes[] = '✅ Added orders.user_id';
    }
    
    if (!Schema::hasColumn('orders', 'account_id')) {
        $table->unsignedBigInteger('account_id')->nullable()->after('user_id');
        $fixes[] = '✅ Added orders.account_id';
    }
    
    if (!Schema::hasColumn('orders', 'assigned_password')) {
        $table->string('assigned_password', 255)->nullable()->after('account_id');
        $fixes[] = '✅ Added orders.assigned_password';
    }
    
    if (!Schema::hasColumn('orders', 'coupon_id')) {
        $table->unsignedInteger('coupon_id')->nullable()->after('user_id');
        $table->index('coupon_id');
        $fixes[] = '✅ Added orders.coupon_id';
    }
    
    if (!Schema::hasColumn('orders', 'discount_amount')) {
        $table->integer('discount_amount')->default(0)->after('amount');
        $fixes[] = '✅ Added orders.discount_amount';
    }
    
    if (!Schema::hasColumn('orders', 'points_used')) {
        $table->integer('points_used')->default(0)->after('discount_amount');
        $fixes[] = '✅ Added orders.points_used';
    }
    
    if (!Schema::hasColumn('orders', 'notes')) {
        $table->text('notes')->nullable()->after('customer_email');
        $fixes[] = '✅ Added orders.notes';
    }
    
    if (!Schema::hasColumn('orders', 'expires_at')) {
        $table->timestamp('expires_at')->nullable()->after('paid_at');
        $fixes[] = '✅ Added orders.expires_at';
    }
    
    if (!Schema::hasColumn('orders', 'completed_at')) {
        $table->timestamp('completed_at')->nullable()->after('expires_at');
        $fixes[] = '✅ Added orders.completed_at';
    }
});

// ============================================
// 2. deposits table - Check if exists
// ============================================
if (!Schema::hasTable('deposits')) {
    Schema::create('deposits', function ($table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->bigInteger('amount');
        $table->string('method', 50)->default('bank');
        $table->string('status', 20)->default('pending');
        $table->string('transaction_id', 100)->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
        $table->index('user_id');
        $table->index('transaction_id');
    });
    $fixes[] = '✅ Created deposits table';
}

// ============================================
// Output results
// ============================================
if (empty($fixes)) {
    echo "✅ All columns already exist! No changes needed.\n";
} else {
    foreach ($fixes as $fix) {
        echo "$fix\n";
    }
    echo "\n✅ Done! " . count($fixes) . " fix(es) applied.\n";
}

echo "\n⚠️ DELETE THIS FILE after running!\n";
echo '</pre>';
