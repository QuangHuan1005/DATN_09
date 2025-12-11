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
        Schema::create('user_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bank_name', 100);
            $table->string('account_number', 50);
            $table->string('account_holder', 100);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            // Index cho performance
            $table->index(['user_id', 'is_default']);
            // Unique constraint cho user + bank + account (account_holder luôn là tên user)
            $table->unique(['user_id', 'bank_name', 'account_number'], 'unique_bank_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bank_accounts');
    }
};
