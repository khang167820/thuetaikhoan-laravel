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
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('ady_product_mapping')) {
            Schema::create('ady_product_mapping', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('ady_product_id')->nullable();
                $table->decimal('price', 12, 0)->default(0);
                $table->decimal('original_price', 12, 0)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('ady_orders')) {
            Schema::create('ady_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('imei')->nullable();
                $table->string('product_name')->nullable();
                $table->decimal('price', 12, 0)->default(0);
                $table->string('status')->default('pending');
                $table->text('result')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ady_orders');
        Schema::dropIfExists('ady_product_mapping');
        Schema::dropIfExists('settings');
    }
};
