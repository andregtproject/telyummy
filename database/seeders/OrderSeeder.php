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
        $canteen = Canteen::first();
        
        $user = User::first(); 

        if (!$canteen || !$user) {
            $this->command->info('Data Kantin atau User tidak ditemukan. Pastikan sudah register.');
            return;
        }

        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 25000,
            'status' => 'menunggu',
            'created_at' => Carbon::now(), 
        ]);


        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 18000,
            'status' => 'menunggu',
            'created_at' => Carbon::now()->subMinutes(5), 
        ]);


        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 50000,
            'status' => 'selesai',
            'created_at' => Carbon::yesterday(), 
        ]);

        Order::create([
            'user_id' => $user->id,
            'canteen_id' => $canteen->id,
            'total_price' => 125000,
            'status' => 'selesai',
            'created_at' => Carbon::today()->subHours(2), 
        ]);
    }
}