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
        if (!Schema::hasTable('admin_logs')) {
            Schema::create('admin_logs', function (Blueprint $table) {
                $table->id();
                $table->string('admin_name')->nullable();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->string('action');
                $table->text('details')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
                
                $table->index(['action', 'created_at']);
            });
        }
        
        // Update settings table to have updated_at column if not exists
        if (Schema::hasTable('settings')) {
            if (!Schema::hasColumn('settings', 'updated_at')) {
                Schema::table('settings', function (Blueprint $table) {
                    $table->timestamp('updated_at')->nullable();
                });
            }
            if (!Schema::hasColumn('settings', 'created_at')) {
                Schema::table('settings', function (Blueprint $table) {
                    $table->timestamp('created_at')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
