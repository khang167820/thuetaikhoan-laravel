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
        Schema::table('orders', function (Blueprint $table) {
            // Add user_id column for authenticated user's orders
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                
                // Add foreign key constraint
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null');
                
                // Add index for faster queries
                $table->index('user_id');
            }
            
            // Add coupon_id for tracking which coupon was used
            // Note: No FK constraint due to type mismatch with legacy coupons table
            if (!Schema::hasColumn('orders', 'coupon_id')) {
                $table->unsignedInteger('coupon_id')->nullable()->after('user_id');
                $table->index('coupon_id');
            }
            
            // Add discount_amount - amount saved by coupon
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->integer('discount_amount')->default(0)->after('amount');
            }
            
            // Add points_used - loyalty points used
            if (!Schema::hasColumn('orders', 'points_used')) {
                $table->integer('points_used')->default(0)->after('discount_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            
            if (Schema::hasColumn('orders', 'coupon_id')) {
                $table->dropIndex(['coupon_id']);
                $table->dropColumn('coupon_id');
            }
            
            if (Schema::hasColumn('orders', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
            
            if (Schema::hasColumn('orders', 'points_used')) {
                $table->dropColumn('points_used');
            }
        });
    }
};
