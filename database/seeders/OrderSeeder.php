<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Canteen;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Kantin Pertama (Milik Anda)
        $canteen = Canteen::first();
        
        // 2. Ambil User Pembeli (Bisa pakai user yang sama atau user lain jika ada)
        // Jika belum ada user lain, kita pakai user ID 1 atau buat user dummy baru
        $user = User::first(); 

        if (!$canteen || !$user) {
            $this->command->info('Data Kantin atau User tidak ditemukan. Pastikan sudah register.');
            return;
        }

        // 3. Buat beberapa pesanan dummy

        // Pesanan 1: Status MENUNGGU (Agar muncul di Antrian Pesanan)
        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 25000,
            'status' => 'menunggu',
            'created_at' => Carbon::now(), // Baru saja order
        ]);

        // Pesanan 2: Status MENUNGGU (Lagi)
        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 18000,
            'status' => 'menunggu',
            'created_at' => Carbon::now()->subMinutes(5), // 5 menit lalu
        ]);

        // Pesanan 3: Status SELESAI (Agar masuk ke Total Pendapatan & Grafik)
        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 50000,
            'status' => 'selesai',
            'created_at' => Carbon::yesterday(), // Kemarin
        ]);

        // Pesanan 4: Status SELESAI
        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 125000,
            'status' => 'selesai',
            'created_at' => Carbon::today()->subHours(2), // Hari ini, 2 jam lalu
        ]);
    }
}