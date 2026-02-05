<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Thêm cột assigned_password để lưu password tại thời điểm cấp tài khoản
     * Dùng để so sánh với password hiện tại - nếu khác = admin đã đổi
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'assigned_password')) {
                $table->string('assigned_password', 255)->nullable()->after('account_id')
                    ->comment('Password tại thời điểm cấp tài khoản');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'assigned_password')) {
                $table->dropColumn('assigned_password');
            }
        });
    }
};
