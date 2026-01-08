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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pembeli
            $table->foreignId('canteen_id')->constrained()->onDelete('cascade'); // Penjual/Kantin
            $table->integer('total_price'); // Harga Total
            $table->string('status')->default('menunggu'); // Status: menunggu, diproses, selesai, batal
            $table->text('notes')->nullable(); // Catatan pesanan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
