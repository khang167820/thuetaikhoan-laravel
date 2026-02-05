<?php
/**
 * Fix Deposit Status - Update all old pending deposits to success
 * Access: https://staging.thuetaikhoan.net/fix-deposits.php
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "<h1>🔧 Fix Deposit Status</h1>";
echo "<pre>";

// Show current status counts
echo "=== Current Status ===\n";
$counts = DB::table('deposits')
    ->select('status', DB::raw('count(*) as count'))
    ->groupBy('status')
    ->pluck('count', 'status');

foreach ($counts as $status => $count) {
    echo "$status: $count\n";
}
echo "\n";

// Fix deposits that are still "pending" but older than 1 hour (assume they are completed)
if (isset($_GET['fix'])) {
    $updated = DB::table('deposits')
        ->where('status', 'pending')
        ->where('created_at', '<', now()->subHour())
        ->update(['status' => 'success', 'updated_at' => now()]);
    
    echo "✅ Updated $updated deposits from 'pending' to 'success'\n\n";
    
    // Show new counts
    echo "=== New Status ===\n";
    $newCounts = DB::table('deposits')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');
    
    foreach ($newCounts as $status => $count) {
        echo "$status: $count\n";
    }
} else {
    // Preview what will be updated
    $toUpdate = DB::table('deposits')
        ->where('status', 'pending')
        ->where('created_at', '<', now()->subHour())
        ->count();
    
    echo "📋 Found $toUpdate old pending deposits (>1 hour old)\n";
    echo "These will be marked as 'success'\n\n";
    
    // Show list
    $pending = DB::table('deposits')
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->limit(20)
        ->get(['id', 'user_id', 'amount', 'status', 'created_at', 'note']);
    
    echo "Recent pending deposits:\n";
    foreach ($pending as $dep) {
        echo "ID: {$dep->id} | User: {$dep->user_id} | Amount: " . number_format($dep->amount) . "đ | {$dep->created_at}\n";
    }
}

echo "</pre>";

if (!isset($_GET['fix'])) {
    echo "<br><a href='?fix=1' style='background:#10b981;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:bold;'>✅ Fix All Old Pending → Success</a>";
}

echo "<br><br><a href='/deposit' style='background:#6366f1;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;'>← Back to Deposit</a>";
