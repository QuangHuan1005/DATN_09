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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên biến thể (VD: "S", "M", "L" hoặc "Đỏ", "Xanh")
            $table->string('type'); // Loại biến thể: 'size' hoặc 'color'
            $table->string('value'); // Giá trị biến thể (VD: "S", "M", "L" hoặc "#FF0000", "#0000FF")
            $table->text('description')->nullable(); // Mô tả
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
