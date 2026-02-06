<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Fix: Make local_order_id nullable to prevent insert errors
     */
    public function up(): void
    {
        // Make local_order_id nullable if it exists
        if (Schema::hasColumn('ady_orders', 'local_order_id')) {
            DB::statement('ALTER TABLE ady_orders MODIFY local_order_id VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        // No reverse needed
    }
};
