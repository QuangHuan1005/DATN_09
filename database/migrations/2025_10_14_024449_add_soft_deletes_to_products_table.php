<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration {
    public function up()
        {
            Schema::table('products', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

    public function down()
        {
            Schema::table('products', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
};
