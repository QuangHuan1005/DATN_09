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
            // Xóa foreign key constraint trước
            $table->dropForeign('fk_pv_product');
        });
        
        Schema::table('product_variants', function (Blueprint $table) {
            // Sau đó xóa cột product_id
            if (Schema::hasColumn('product_variants', 'product_id')) {
                $table->dropColumn('product_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Không cần rollback vì chúng ta không muốn cột product_id
        });
    }
};
