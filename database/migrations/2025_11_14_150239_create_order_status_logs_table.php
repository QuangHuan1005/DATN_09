<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_status_id');
            // user = khách / staff thao tác trên UI, system = xử lý tự động (admin đổi trạng thái, auto update,...)
            $table->enum('actor_type', ['user', 'system']);
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');

            $table->foreign('order_status_id')
                ->references('id')->on('order_statuses')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_logs');
    }
};
