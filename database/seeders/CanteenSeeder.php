<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canteen;

class CanteenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Penjual dummy dulu sebagai pemilik kantin
        $penjual = \App\Models\User::updateOrCreate(
            ['email' => 'penjual@telyummy.com'],
            [
                'name' => 'Pak Kantin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'penjual',
                'email_verified_at' => now(), // Supaya bisa langsung login
            ]
        );

        // Gambar Food Court / Kantin profesional dari Unsplash
        // Semua gambar ini menampilkan food court, cafeteria, atau restoran yang proper

        // 2. Update atau create data Kantin dengan gambar kantin yang proper
        Canteen::updateOrCreate(
            ['slug' => 'kantin-teknik'],
            [
                'user_id' => $penjual->id,
                'name' => 'Kantin Teknik',
                // Food court/cafeteria style - interior shot
                'image' => 'https://images.unsplash.com/photo-1567521464027-f127ff144326?w=800&auto=format&fit=crop&q=80',
                'description' => 'Pusat jajanan mahasiswa teknik dengan harga terjangkau.',
                'category' => 'Rice Bowl & Snacks',
                'rating' => 4.8,
                'is_open' => true,
            ]
        );

        Canteen::updateOrCreate(
            ['slug' => 'kantin-asrama-putri'],
            [
                'user_id' => $penjual->id,
                'name' => 'Kantin Asrama Putri',
                // Cozy cafe/canteen - warm ambiance
                'image' => 'https://images.unsplash.com/photo-1559329007-40df8a9345d8?w=800&auto=format&fit=crop&q=80',
                'description' => 'Masakan rumahan sehat dan higienis.',
                'category' => 'Masakan Rumahan',
                'rating' => 4.5,
                'is_open' => true,
            ]
        );

        Canteen::updateOrCreate(
            ['slug' => 'kantin-deluxe'],
            [
                'user_id' => $penjual->id,
                'name' => 'Kantin Deluxe',
                // Modern food court - bright and clean
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80',
                'description' => 'Kantin premium dengan menu variatif.',
                'category' => 'Aneka Makanan',
                'rating' => 4.9,
                'is_open' => true,
            ]
        );

        Canteen::updateOrCreate(
            ['slug' => 'kantin-gedung-tult'],
            [
                'user_id' => $penjual->id,
                'name' => 'Kantin Gedung TULT',
                // Campus cafeteria style
                'image' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=800&auto=format&fit=crop&q=80',
                'description' => 'Spesialis ayam geprek dan kopi.',
                'category' => 'Masakan Rumahan',
                'rating' => 4.7,
                'is_open' => false, // Sedang tutup
            ]
        );
    }
}
