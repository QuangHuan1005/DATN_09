<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thay đổi ENUM của cột status trong bảng order_returns
        DB::statement("ALTER TABLE `order_returns` MODIFY COLUMN `status` ENUM('pending', 'approved', 'waiting_for_return', 'returned', 'refunded', 'rejected') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback về ENUM cũ (không bao gồm 'waiting_for_return')
        DB::statement("ALTER TABLE `order_returns` MODIFY COLUMN `status` ENUM('pending', 'approved', 'returned', 'refunded', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};




