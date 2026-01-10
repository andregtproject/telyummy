<?php

namespace Database\Seeders;

use App\Models\Canteen;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canteens = Canteen::all();

        // Menu items data per kategori dengan Unsplash image URLs
        $menuData = [
            'Makanan' => [
                ['name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar', 'price' => 15000, 'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=400&fit=crop'],
                ['name' => 'Nasi Ayam Geprek', 'description' => 'Ayam geprek sambal level 1-5 dengan nasi hangat', 'price' => 18000, 'image' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=400&h=400&fit=crop'],
                ['name' => 'Mie Goreng Jawa', 'description' => 'Mie goreng bumbu khas Jawa dengan telur', 'price' => 13000, 'image' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=400&fit=crop'],
                ['name' => 'Nasi Rendang', 'description' => 'Rendang daging sapi empuk dengan nasi putih', 'price' => 22000, 'image' => 'https://images.unsplash.com/photo-1562565652-a0d8f0c59eb4?w=400&h=400&fit=crop'],
                ['name' => 'Nasi Padang Komplit', 'description' => 'Paket nasi dengan lauk pilihan khas Padang', 'price' => 25000, 'image' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=400&h=400&fit=crop'],
                ['name' => 'Bakso Malang', 'description' => 'Bakso urat jumbo dengan mie, tahu, dan siomay', 'price' => 17000, 'image' => 'https://images.unsplash.com/photo-1529563021893-cc83c992d75d?w=400&h=400&fit=crop'],
                ['name' => 'Soto Ayam', 'description' => 'Soto ayam kuah kuning dengan nasi', 'price' => 15000, 'image' => 'https://images.unsplash.com/photo-1547928576-b822bc410bdf?w=400&h=400&fit=crop'],
                ['name' => 'Indomie Goreng Telur', 'description' => 'Indomie goreng dengan telur ceplok', 'price' => 10000, 'image' => 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=400&h=400&fit=crop'],
            ],
            'Minuman' => [
                ['name' => 'Es Teh Manis', 'description' => 'Teh manis dingin segar', 'price' => 5000, 'image' => 'https://images.unsplash.com/photo-1499638673689-79a0b5115d87?w=400&h=400&fit=crop'],
                ['name' => 'Es Jeruk', 'description' => 'Jeruk peras segar dengan es', 'price' => 7000, 'image' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400&h=400&fit=crop'],
                ['name' => 'Kopi Susu', 'description' => 'Kopi arabika dengan susu creamy', 'price' => 12000, 'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=400&fit=crop'],
                ['name' => 'Es Cokelat', 'description' => 'Cokelat dingin dengan whipped cream', 'price' => 10000, 'image' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=400&h=400&fit=crop'],
                ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat segar dengan susu cokelat', 'price' => 15000, 'image' => 'https://images.unsplash.com/photo-1638176066666-ffb2f013c7dd?w=400&h=400&fit=crop'],
                ['name' => 'Lemon Tea', 'description' => 'Teh lemon segar dingin', 'price' => 8000, 'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=400&fit=crop'],
                ['name' => 'Cappuccino', 'description' => 'Kopi cappuccino dengan foam susu', 'price' => 15000, 'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&h=400&fit=crop'],
                ['name' => 'Air Mineral', 'description' => 'Air mineral 600ml', 'price' => 4000, 'image' => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=400&h=400&fit=crop'],
            ],
            'Snack' => [
                ['name' => 'Kentang Goreng', 'description' => 'French fries crispy dengan saus sambal/mayo', 'price' => 12000, 'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=400&h=400&fit=crop'],
                ['name' => 'Risoles Mayo', 'description' => 'Risoles isi ragout ayam dengan mayo', 'price' => 5000, 'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=400&h=400&fit=crop'],
                ['name' => 'Cireng Rujak', 'description' => 'Cireng goreng dengan bumbu rujak pedas', 'price' => 8000, 'image' => 'https://images.unsplash.com/photo-1606755962773-d324e0a13086?w=400&h=400&fit=crop'],
                ['name' => 'Pisang Goreng Keju', 'description' => 'Pisang goreng crispy dengan topping keju', 'price' => 10000, 'image' => 'https://images.unsplash.com/photo-1528751014936-863e6e7a319c?w=400&h=400&fit=crop'],
                ['name' => 'Tahu Crispy', 'description' => 'Tahu goreng tepung dengan cabai rawit', 'price' => 7000, 'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=400&fit=crop'],
                ['name' => 'Dimsum Ayam', 'description' => 'Dimsum kukus isi ayam (4 pcs)', 'price' => 15000, 'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=400&h=400&fit=crop'],
                ['name' => 'Roti Bakar Cokelat', 'description' => 'Roti bakar dengan selai cokelat dan keju', 'price' => 12000, 'image' => 'https://images.unsplash.com/photo-1484723091739-30a097e8f929?w=400&h=400&fit=crop'],
                ['name' => 'Gorengan Mix', 'description' => 'Paket bakwan, tahu, tempe (5 pcs)', 'price' => 8000, 'image' => 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=400&fit=crop'],
            ],
        ];

        foreach ($canteens as $canteen) {
            // Setiap kantin dapat 5-10 menu random dari berbagai kategori
            $menuCount = rand(5, 10);
            $addedMenus = [];

            for ($i = 0; $i < $menuCount; $i++) {
                // Pilih kategori random
                $category = array_rand($menuData);
                $items = $menuData[$category];
                
                // Pilih menu random dari kategori
                $menuIndex = array_rand($items);
                $menu = $items[$menuIndex];
                
                // Skip jika menu sudah ditambahkan ke kantin ini
                $menuKey = $menu['name'];
                if (in_array($menuKey, $addedMenus)) {
                    continue;
                }
                $addedMenus[] = $menuKey;

                // Variasi harga sedikit per kantin
                $priceVariation = rand(-2000, 3000);
                $finalPrice = max(3000, $menu['price'] + $priceVariation);

                MenuItem::create([
                    'canteen_id' => $canteen->id,
                    'name' => $menu['name'],
                    'description' => $menu['description'],
                    'price' => $finalPrice,
                    'category' => $category,
                    'image' => $menu['image'], // Unsplash image URL
                    'is_available' => rand(0, 10) > 1, // 90% kemungkinan tersedia
                ]);
            }
        }
    }
}
