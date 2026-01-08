<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom rating (skala 1-5, boleh kosong)
            $table->integer('rating')->nullable()->after('total_price');
            // Opsional bisa tambah kolom review teks
            $table->text('review')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['rating', 'review']);
        });
    }
};
