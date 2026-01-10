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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pembeli
            $table->foreignId('canteen_id')->constrained()->onDelete('cascade'); // Kantin
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // Order terkait (optional)
            $table->text('content'); // Isi feedback
            $table->unsignedTinyInteger('rating')->default(5); // Rating 1-5 bintang
            $table->enum('status', ['menunggu', 'dibaca', 'ditanggapi'])->default('menunggu');
            $table->text('response')->nullable(); // Tanggapan dari penjual
            $table->timestamp('responded_at')->nullable(); // Waktu ditanggapi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
