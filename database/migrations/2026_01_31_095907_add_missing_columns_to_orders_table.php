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
            // Thêm các cột còn thiếu để match với production database
            
            // service_type - loại dịch vụ (UnlockTool, Vietmap, etc.)
            if (!Schema::hasColumn('orders', 'service_type')) {
                $table->string('service_type', 100)->nullable()->after('price_id');
            }
            
            // customer_email - email khách hàng nhận kết quả
            if (!Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email', 255)->nullable()->after('ip_address');
            }
            
            // notes - ghi chú đơn hàng
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('customer_email');
            }
            
            // expires_at - thời gian hết hạn (cho thuê tài khoản)
            if (!Schema::hasColumn('orders', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('paid_at');
            }
            
            // ADY Unlocker columns (cho IMEI services)
            if (!Schema::hasColumn('orders', 'ady_order_id')) {
                $table->string('ady_order_id', 100)->nullable()->after('account_id');
            }
            if (!Schema::hasColumn('orders', 'ady_product_id')) {
                $table->string('ady_product_id', 100)->nullable()->after('ady_order_id');
            }
            if (!Schema::hasColumn('orders', 'ady_product_uuid')) {
                $table->string('ady_product_uuid', 100)->nullable();
            }
            if (!Schema::hasColumn('orders', 'ady_order_uuid')) {
                $table->string('ady_order_uuid', 100)->nullable();
            }
            if (!Schema::hasColumn('orders', 'ady_fields')) {
                $table->text('ady_fields')->nullable()->comment('JSON chứa các trường input');
            }
            if (!Schema::hasColumn('orders', 'ady_status')) {
                $table->string('ady_status', 50)->nullable()->comment('pending, processing, success, rejected');
            }
            if (!Schema::hasColumn('orders', 'ady_result')) {
                $table->text('ady_result')->nullable()->comment('Kết quả trả về từ ADY');
            }
            if (!Schema::hasColumn('orders', 'ady_error')) {
                $table->text('ady_error')->nullable()->comment('Thông báo lỗi từ ADY');
            }
            if (!Schema::hasColumn('orders', 'ady_amount_usd')) {
                $table->decimal('ady_amount_usd', 10, 4)->nullable()->comment('Số USD trừ trên ADY');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'service_type', 'customer_email', 'notes', 'expires_at',
                'ady_order_id', 'ady_product_id', 'ady_product_uuid', 'ady_order_uuid',
                'ady_fields', 'ady_status', 'ady_result', 'ady_error', 'ady_amount_usd'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
