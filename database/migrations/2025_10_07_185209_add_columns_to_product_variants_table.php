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
            if (!Schema::hasColumn('product_variants', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('product_variants', 'type')) {
                $table->string('type')->after('name');
            }
            if (!Schema::hasColumn('product_variants', 'value')) {
                $table->string('value')->after('type');
            }
            if (!Schema::hasColumn('product_variants', 'description')) {
                $table->text('description')->nullable()->after('value');
            }
            if (!Schema::hasColumn('product_variants', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['name', 'type', 'value', 'description', 'status']);
        });
    }
};
