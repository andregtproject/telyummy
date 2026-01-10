<?php

namespace Database\Seeders;

use App\Models\Canteen;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua pembeli
        $pembelis = User::where('role', 'pembeli')->get();
        
        // Ambil semua kantin yang punya menu
        $canteens = Canteen::has('menuItems')->get();

        if ($pembelis->isEmpty() || $canteens->isEmpty()) {
            $this->command->warn('Tidak ada pembeli atau kantin dengan menu. Jalankan UserSeeder, CanteenSeeder, dan MenuItemSeeder terlebih dahulu.');
            return;
        }

        $statuses = [
            Order::STATUS_MENUNGGU,
            Order::STATUS_DIPROSES,
            Order::STATUS_SELESAI,
            Order::STATUS_BATAL,
        ];

        $notes = [
            null,
            'Tolong cepat ya, saya buru-buru',
            'Nasi jangan terlalu banyak',
            'Sambalnya pisah',
            'Kalau bisa di pack rapi',
            'Minta sendok plastik ya',
        ];

        // Buat 15-25 sample orders
        $orderCount = rand(15, 25);

        for ($i = 0; $i < $orderCount; $i++) {
            // Random pembeli dan kantin
            $pembeli = $pembelis->random();
            $canteen = $canteens->random();
            
            // Ambil menu dari kantin tersebut
            $menuItems = $canteen->menuItems()->where('is_available', true)->get();
            
            if ($menuItems->isEmpty()) {
                continue;
            }

            // Random 1-4 items per order
            $itemCount = rand(1, min(4, $menuItems->count()));
            // random() dengan parameter angka selalu mengembalikan Collection
            $selectedItems = $menuItems->random($itemCount);

            // Hitung total
            $totalPrice = 0;
            $orderItemsData = [];

            foreach ($selectedItems as $menuItem) {
                $quantity = rand(1, 3);
                $price = $menuItem->price;
                $totalPrice += $price * $quantity;

                $orderItemsData[] = [
                    'menu_item_id' => $menuItem->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'notes' => rand(0, 3) === 0 ? 'Tidak pedas' : null,
                ];
            }

            // Buat order
            $status = $statuses[array_rand($statuses)];
            
            // Untuk order selesai/batal, set waktu lebih lama
            $createdAt = now();
            if (in_array($status, [Order::STATUS_SELESAI, Order::STATUS_BATAL])) {
                $createdAt = now()->subDays(rand(1, 7))->subHours(rand(0, 23));
            } elseif ($status === Order::STATUS_DIPROSES) {
                $createdAt = now()->subHours(rand(1, 5));
            } elseif ($status === Order::STATUS_MENUNGGU) {
                $createdAt = now()->subMinutes(rand(5, 60));
            }

            $order = Order::create([
                'user_id' => $pembeli->id,
                'canteen_id' => $canteen->id,
                'total_price' => $totalPrice,
                'status' => $status,
                'notes' => $notes[array_rand($notes)],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Buat order items
            foreach ($orderItemsData as $itemData) {
                $order->orderItems()->create($itemData);
            }
        }

        $this->command->info("Created {$orderCount} sample orders.");
    }
}
