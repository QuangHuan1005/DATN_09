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
        Schema::table('product_variants', function (Blueprint $table) {
            // Xóa cột status cũ nếu tồn tại
            $table->dropColumn('status');
        });
        
        Schema::table('product_variants', function (Blueprint $table) {
            // Thêm lại cột status với kiểu enum đúng
            $table->enum('status', ['active', 'inactive'])->default('active')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
