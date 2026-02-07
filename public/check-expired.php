<?php
/**
 * Auto-lock expired accounts
 * Run via cron: curl https://thuetaikhoan.net/check-expired.php every hour
 */
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$now = now();

// Find accounts that are available and have passed their expires_at date
$expiredAccounts = DB::table('accounts')
    ->where('is_available', 1)
    ->whereNotNull('expires_at')
    ->where('expires_at', '<=', $now)
    ->get();

$locked = 0;
$names = [];

foreach ($expiredAccounts as $account) {
    DB::table('accounts')->where('id', $account->id)->update([
        'is_available' => 0,
        'note' => 'TK hết hạn - cần gia hạn',
    ]);
    $locked++;
    $names[] = $account->username . ' (' . $account->type . ')';
}

echo "Checked at: " . $now->format('Y-m-d H:i:s') . "\n";
echo "Locked: {$locked} expired accounts\n";

if ($locked > 0) {
    echo "Accounts locked:\n";
    foreach ($names as $name) {
        echo "  - {$name}\n";
    }
}

// Also list accounts expiring in next 3 days (warning)
$soonExpiring = DB::table('accounts')
    ->where('is_available', 1)
    ->whereNotNull('expires_at')
    ->where('expires_at', '>', $now)
    ->where('expires_at', '<=', $now->copy()->addDays(3))
    ->get();

if ($soonExpiring->count() > 0) {
    echo "\n⚠️ Sắp hết hạn (trong 3 ngày):\n";
    foreach ($soonExpiring as $acc) {
        $daysLeft = $now->diffInDays(\Carbon\Carbon::parse($acc->expires_at));
        echo "  - {$acc->username} ({$acc->type}) - còn {$daysLeft} ngày\n";
    }
}
