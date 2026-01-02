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
    Canteen::create([
        'name' => 'Kantin Teknik',
        'slug' => 'kantin-teknik',
        'image' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?q=80&w=800&auto=format&fit=crop', // Gambar placeholder
        'description' => 'Pusat jajanan mahasiswa teknik dengan harga terjangkau.',
        'category' => 'Rice Bowl & Snacks',
        'rating' => 4.8,
        'is_open' => true,
    ]);

    Canteen::create([
        'name' => 'Kantin Asrama Putri',
        'slug' => 'kantin-asrama-putri',
        'image' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=800&auto=format&fit=crop',
        'description' => 'Masakan rumahan sehat dan higienis.',
        'category' => 'Masakan Rumahan',
        'rating' => 4.5,
        'is_open' => true,
    ]);

    Canteen::create([
        'name' => 'Kantin Gedung TULT',
        'slug' => 'kantin-gedung-tult',
        'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=800&auto=format&fit=crop',
        'description' => 'Spesialis ayam geprek dan kopi.',
        'category' => 'Masakan Rumahan',
        'rating' => 4.7,
        'is_open' => false, // Sedang tutup
    ]);
}
}
