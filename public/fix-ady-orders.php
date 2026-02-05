<?php
/**
 * Fix ADY Orders table - Add missing columns
 * DELETE THIS FILE AFTER USE!
 */

$token = 'fix_ady_2026';
if (($_GET['token'] ?? '') !== $token) {
    die('Access denied. Use ?token=' . $token);
}

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<pre>";
echo "Fixing ady_orders table...\n\n";

try {
    $columns = [
        'user_id' => "ALTER TABLE ady_orders ADD COLUMN user_id BIGINT UNSIGNED NULL AFTER id",
        'tracking_code' => "ALTER TABLE ady_orders ADD COLUMN tracking_code VARCHAR(255) NULL AFTER id",
        'product_uuid' => "ALTER TABLE ady_orders ADD COLUMN product_uuid VARCHAR(255) NULL AFTER tracking_code",
        'product_name' => "ALTER TABLE ady_orders ADD COLUMN product_name VARCHAR(255) NULL AFTER product_uuid",
        'price_usd' => "ALTER TABLE ady_orders ADD COLUMN price_usd DECIMAL(10,4) NULL AFTER product_name",
        'price_vnd' => "ALTER TABLE ady_orders ADD COLUMN price_vnd BIGINT NULL DEFAULT 0 AFTER price_usd",
        'fields' => "ALTER TABLE ady_orders ADD COLUMN fields TEXT NULL AFTER price_vnd",
        'customer_email' => "ALTER TABLE ady_orders ADD COLUMN customer_email VARCHAR(255) NULL AFTER fields",
        'ady_order_uuid' => "ALTER TABLE ady_orders ADD COLUMN ady_order_uuid VARCHAR(255) NULL AFTER status",
        'error' => "ALTER TABLE ady_orders ADD COLUMN error TEXT NULL AFTER result",
        'ip_address' => "ALTER TABLE ady_orders ADD COLUMN ip_address VARCHAR(45) NULL AFTER error",
        'paid_at' => "ALTER TABLE ady_orders ADD COLUMN paid_at TIMESTAMP NULL AFTER ip_address",
        'completed_at' => "ALTER TABLE ady_orders ADD COLUMN completed_at TIMESTAMP NULL AFTER paid_at",
    ];
    
    foreach ($columns as $col => $sql) {
        try {
            // Check if column exists
            $exists = DB::select("SHOW COLUMNS FROM ady_orders LIKE '$col'");
            if (empty($exists)) {
                DB::statement($sql);
                echo "✅ Added column: $col\n";
            } else {
                echo "⏭️ Column already exists: $col\n";
            }
        } catch (Exception $e) {
            echo "⚠️ $col: " . $e->getMessage() . "\n";
        }
    }
    
    // Add unique index on tracking_code
    try {
        DB::statement("ALTER TABLE ady_orders ADD UNIQUE INDEX idx_tracking_code (tracking_code)");
        echo "✅ Added unique index on tracking_code\n";
    } catch (Exception $e) {
        echo "⏭️ Index already exists or error: " . $e->getMessage() . "\n";
    }
    
    echo "\n\n✅ Done! Delete this file now.";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
echo "</pre>";
