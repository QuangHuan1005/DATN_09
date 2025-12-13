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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code', 100)->unique();
            $table->string('discount_type', 20)->default('fixed'); // fixed, percent
            $table->integer('quantity')->default(0);
            $table->integer('total_used')->default(0);
            $table->integer('user_limit')->default(1);
            $table->decimal('discount_value', 12, 2)->default(0.00);
            $table->decimal('sale_price', 12, 2)->default(0.00);
            $table->decimal('min_order_value', 12, 2)->default(0.00);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->tinyInteger('status')->default(1); // 1 = active, 0 = inactive
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('voucher_code');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};


