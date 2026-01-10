<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed dalam urutan yang benar
        $this->call([
            UserSeeder::class,      // 1. Buat user pembeli dan penjual
            CanteenSeeder::class,   // 2. Buat kantin (penjual)
            MenuItemSeeder::class,  // 3. Buat menu items per kantin
            OrderSeeder::class,     // 4. Buat sample orders
            FeedbackSeeder::class,  // 5. Buat sample feedbacks
        ]);
    }
}