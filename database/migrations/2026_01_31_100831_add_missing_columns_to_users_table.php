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
        Schema::table('users', function (Blueprint $table) {
            // Thêm các cột còn thiếu để match với legacy database
            
            // phone - Số điện thoại
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            
            // fullname - Họ tên đầy đủ
            if (!Schema::hasColumn('users', 'fullname')) {
                $table->string('fullname', 255)->nullable()->after('name');
            }
            
            // balance - Số dư tài khoản
            if (!Schema::hasColumn('users', 'balance')) {
                $table->decimal('balance', 15, 0)->default(0)->after('phone');
            }
            
            // role - Vai trò (user, admin)
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->default('user')->after('balance');
            }
            
            // is_active - Trạng thái tài khoản
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
            
            // last_login - Lần đăng nhập cuối
            if (!Schema::hasColumn('users', 'last_login')) {
                $table->timestamp('last_login')->nullable()->after('is_active');
            }
            
            // password_hash - Dùng cho legacy compatibility
            if (!Schema::hasColumn('users', 'password_hash')) {
                $table->string('password_hash', 255)->nullable()->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['phone', 'fullname', 'balance', 'role', 'is_active', 'last_login', 'password_hash'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
