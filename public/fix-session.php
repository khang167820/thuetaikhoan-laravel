<?php
/**
 * Fix Session Configuration for Hostinger
 * Access: https://staging.thuetaikhoan.net/fix-session.php
 */

// Correct path for Hostinger structure
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

echo "<h1>🔧 Session Configuration Check</h1>";
echo "<pre>";

// Check session config
echo "=== Session Config ===\n";
echo "SESSION_DRIVER: " . env('SESSION_DRIVER', 'not set') . "\n";
echo "SESSION_DOMAIN: " . env('SESSION_DOMAIN', 'not set') . "\n";
echo "SESSION_SECURE_COOKIE: " . (env('SESSION_SECURE_COOKIE') ? 'true' : 'false (or not set)') . "\n";
echo "SESSION_SAME_SITE: " . env('SESSION_SAME_SITE', 'lax') . "\n";
echo "\n";

// Check if sessions table exists
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $kernel->bootstrap();
    
    $sessionTableExists = \Illuminate\Support\Facades\Schema::hasTable('sessions');
    echo "Sessions table exists: " . ($sessionTableExists ? "YES ✅" : "NO ❌") . "\n";
    
    if ($sessionTableExists) {
        $sessionCount = \Illuminate\Support\Facades\DB::table('sessions')->count();
        echo "Session records: " . $sessionCount . "\n";
    }
    
    // Check users table for remember_token
    $hasRememberToken = \Illuminate\Support\Facades\Schema::hasColumn('users', 'remember_token');
    echo "Users.remember_token column: " . ($hasRememberToken ? "YES ✅" : "NO ❌") . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Recommendations ===\n";
echo "If getting 419 error, try:\n";
echo "1. Clear browser cookies for this site\n";
echo "2. Use incognito/private window\n";
echo "3. Check .env has SESSION_DRIVER=database\n";
echo "4. Make sure SESSION_SECURE_COOKIE is not set or set to false\n";

echo "</pre>";

// Option to clear sessions
if (isset($_GET['clear'])) {
    try {
        \Illuminate\Support\Facades\DB::table('sessions')->truncate();
        echo "<p style='color:green;font-weight:bold;'>✅ Sessions cleared successfully!</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error clearing sessions: " . $e->getMessage() . "</p>";
    }
}

echo "<br><a href='?clear=1' style='background:#ef4444;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;'>🗑️ Clear All Sessions</a>";
echo "<br><br><a href='/login' style='background:#6366f1;color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;'>🔐 Go to Login</a>";
