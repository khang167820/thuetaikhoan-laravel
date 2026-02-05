<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ady_orders', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('ady_orders', 'tracking_code')) {
                $table->string('tracking_code')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('ady_orders', 'product_uuid')) {
                $table->string('product_uuid')->nullable()->after('tracking_code');
            }
            if (!Schema::hasColumn('ady_orders', 'price_usd')) {
                $table->decimal('price_usd', 10, 4)->nullable()->after('product_name');
            }
            if (!Schema::hasColumn('ady_orders', 'price_vnd')) {
                $table->bigInteger('price_vnd')->nullable()->after('price_usd');
            }
            if (!Schema::hasColumn('ady_orders', 'fields')) {
                $table->text('fields')->nullable()->after('price_vnd');
            }
            if (!Schema::hasColumn('ady_orders', 'ady_order_uuid')) {
                $table->string('ady_order_uuid')->nullable()->after('status');
            }
            if (!Schema::hasColumn('ady_orders', 'error')) {
                $table->text('error')->nullable()->after('result');
            }
            if (!Schema::hasColumn('ady_orders', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('error');
            }
        });
        
        // Add unique index on tracking_code
        try {
            Schema::table('ady_orders', function (Blueprint $table) {
                $table->unique('tracking_code');
            });
        } catch (\Exception $e) {
            // Index might already exist
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ady_orders', function (Blueprint $table) {
            $table->dropColumn([
                'tracking_code', 'product_uuid', 'price_usd', 'price_vnd',
                'fields', 'ady_order_uuid', 'error', 'completed_at'
            ]);
        });
    }
};
