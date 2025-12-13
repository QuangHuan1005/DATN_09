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
        // Kiểm tra xem bảng đã tồn tại chưa
        if (!Schema::hasTable('order_return_status_logs')) {
            Schema::create('order_return_status_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_return_id')->constrained('order_returns')->onDelete('cascade');
                $table->string('status', 50); // pending, approved, waiting_for_return, returned, refunded, rejected
                $table->string('actor_type', 20)->default('system'); // admin, user, system
                $table->unsignedBigInteger('actor_id')->nullable(); // ID của admin hoặc user
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_return_status_logs');
    }
};




