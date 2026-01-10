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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('price'); // Harga dalam Rupiah (integer)
            $table->string('category'); // Makanan, Minuman, Snack, atau kategori custom
            $table->string('image'); // Wajib ada gambar
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            // Index untuk query yang sering digunakan
            $table->index(['canteen_id', 'is_available']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
