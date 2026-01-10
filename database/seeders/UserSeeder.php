<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa user pembeli untuk testing
        $pembelis = [
            [
                'name' => 'Pembeli Rafie',
                'email' => 'rafie@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Putri Amelia',
                'email' => 'putri@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dimas Aditya',
                'email' => 'dimas@pembeli.com',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($pembelis as $pembeli) {
            User::updateOrCreate(
                ['email' => $pembeli['email']],
                $pembeli
            );
        }

        $this->command->info('Created ' . count($pembelis) . ' pembeli users.');
    }
}
