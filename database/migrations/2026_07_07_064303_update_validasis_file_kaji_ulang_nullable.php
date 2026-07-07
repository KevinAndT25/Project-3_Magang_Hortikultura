<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('validasis', function (Blueprint $table) {
            $table->string('file_kaji_ulang')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('validasis', function (Blueprint $table) {
            $table->string('file_kaji_ulang')->nullable(false)->change();
        });
    }
};