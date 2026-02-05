<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to ensure ady_orders table has all required columns
 * for both QR payment flow and logged-in user balance payment
 */
return new class extends Migration
{
    public function up(): void
    {
        // Check if table exists, if not create with all columns
        if (!Schema::hasTable('ady_orders')) {
            Schema::create('ady_orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable(); // Nullable for guest orders
                $table->string('tracking_code')->unique(); // Payment reference code
                $table->string('product_uuid');
                $table->string('product_name');
                $table->decimal('price_usd', 10, 4)->nullable();
                $table->bigInteger('price_vnd')->default(0);
                $table->text('fields')->nullable(); // JSON of order fields (IMEI, Serial, etc.)
                $table->string('customer_email')->nullable();
                $table->string('status')->default('pending'); // pending, paid, processing, completed, failed
                $table->string('ady_order_uuid')->nullable(); // UUID from ADY API
                $table->text('result')->nullable(); // Result from ADY
                $table->text('error')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                
                $table->index('user_id');
                $table->index('status');
            });
        } else {
            // Table exists, add missing columns
            Schema::table('ady_orders', function (Blueprint $table) {
                $columns = [
                    'user_id' => fn($t) => $t->unsignedBigInteger('user_id')->nullable()->after('id'),
                    'tracking_code' => fn($t) => $t->string('tracking_code')->nullable()->after('id'),
                    'product_uuid' => fn($t) => $t->string('product_uuid')->nullable()->after('tracking_code'),
                    'product_name' => fn($t) => $t->string('product_name')->nullable()->after('product_uuid'),
                    'price_usd' => fn($t) => $t->decimal('price_usd', 10, 4)->nullable()->after('product_name'),
                    'price_vnd' => fn($t) => $t->bigInteger('price_vnd')->nullable()->after('price_usd'),
                    'fields' => fn($t) => $t->text('fields')->nullable()->after('price_vnd'),
                    'customer_email' => fn($t) => $t->string('customer_email')->nullable()->after('fields'),
                    'ady_order_uuid' => fn($t) => $t->string('ady_order_uuid')->nullable()->after('status'),
                    'error' => fn($t) => $t->text('error')->nullable()->after('result'),
                    'ip_address' => fn($t) => $t->string('ip_address')->nullable()->after('error'),
                    'paid_at' => fn($t) => $t->timestamp('paid_at')->nullable()->after('ip_address'),
                    'completed_at' => fn($t) => $t->timestamp('completed_at')->nullable()->after('paid_at'),
                ];
                
                foreach ($columns as $col => $fn) {
                    if (!Schema::hasColumn('ady_orders', $col)) {
                        Schema::table('ady_orders', function (Blueprint $t) use ($fn) {
                            $fn($t);
                        });
                    }
                }
            });
            
            // Add unique index on tracking_code if not exists
            try {
                Schema::table('ady_orders', function (Blueprint $table) {
                    $table->unique('tracking_code');
                });
            } catch (\Exception $e) {
                // Index already exists
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ady_orders');
    }
};
