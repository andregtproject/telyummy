<?php

namespace Database\Seeders;

use App\Models\Canteen;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua pembeli
        $pembeliUsers = User::where('role', 'pembeli')->get();
        
        // Ambil semua kantin
        $canteens = Canteen::all();
        
        if ($pembeliUsers->isEmpty() || $canteens->isEmpty()) {
            $this->command->warn('Tidak ada pembeli atau kantin. Jalankan CanteenSeeder terlebih dahulu.');
            return;
        }

        // Daftar feedback positif
        $positiveFeedbacks = [
            'Makanannya enak banget! Porsinya juga pas dan harganya terjangkau. Pasti bakal pesan lagi.',
            'Pelayanannya cepat dan ramah. Makanan masih hangat saat sampai. Recommended!',
            'Rasa makanannya konsisten enak setiap kali pesan. Jadi langganan nih!',
            'Porsinya besar banget untuk harga segitu. Worth it!',
            'Bumbu dan rasanya pas banget di lidah. Suka banget sama menu andalannya.',
            'Packagingnya rapi dan aman. Makanan tidak tumpah saat dibawa. Good job!',
            'Variasi menunya banyak, jadi tidak bosan. Semua yang sudah dicoba enak-enak.',
            'Tempatnya bersih dan higienis. Jadi yakin sama kualitas makanannya.',
        ];

        // Daftar feedback netral
        $neutralFeedbacks = [
            'Makanannya lumayan enak, tapi waktu tunggu agak lama. Semoga bisa lebih cepat lagi.',
            'Rasa oke, harga standar. Tidak ada yang special tapi cukup untuk makan siang.',
            'Porsinya agak kurang untuk saya yang banyak makan, tapi rasanya cukup enak.',
            'Makanannya enak tapi kemasan kurang rapi. Saran: perbaiki packagingnya ya.',
            'Menu favorit kadang habis. Semoga stocknya bisa lebih banyak.',
        ];

        // Daftar feedback negatif
        $negativeFeedbacks = [
            'Waktu tunggu terlalu lama. Harap ditingkatkan lagi pelayanannya.',
            'Porsinya mengecil dari sebelumnya. Agak kecewa sih.',
            'Makanan sampai sudah dingin. Mohon perhatikan waktu pengantaran.',
        ];

        // Daftar tanggapan penjual
        $sellerResponses = [
            'Terima kasih banyak atas feedback positifnya! Kami sangat senang Anda menyukai makanan kami. Ditunggu pesanan berikutnya ya!',
            'Wah, terima kasih sudah menjadi pelanggan setia kami! Kami akan terus menjaga kualitas makanan.',
            'Terima kasih atas masukannya. Kami akan terus berusaha meningkatkan pelayanan dan kualitas makanan.',
            'Mohon maaf atas ketidaknyamanannya. Kami akan evaluasi dan perbaiki untuk ke depannya. Terima kasih sudah memberikan feedback.',
            'Terima kasih sudah mampir! Kami senang Anda puas dengan makanan kami. See you next order!',
        ];

        $feedbackCount = 0;

        // Buat feedback untuk setiap kantin
        foreach ($canteens as $canteen) {
            // Ambil orders yang sudah selesai untuk kantin ini
            $completedOrders = Order::where('canteen_id', $canteen->id)
                ->where('status', 'selesai')
                ->get();

            // Buat 3-5 feedback per kantin
            $numFeedbacks = rand(3, 5);
            
            for ($i = 0; $i < $numFeedbacks; $i++) {
                // Pilih pembeli random
                $pembeli = $pembeliUsers->random();
                
                // Pilih order random jika ada (50% chance)
                $order = null;
                if ($completedOrders->isNotEmpty() && rand(0, 1)) {
                    $order = $completedOrders->random();
                    $pembeli = User::find($order->user_id);
                }

                // Tentukan rating dan feedback
                $ratingChance = rand(1, 100);
                if ($ratingChance <= 60) {
                    // 60% positive feedback (rating 4-5)
                    $rating = rand(4, 5);
                    $content = $positiveFeedbacks[array_rand($positiveFeedbacks)];
                } elseif ($ratingChance <= 90) {
                    // 30% neutral feedback (rating 3)
                    $rating = 3;
                    $content = $neutralFeedbacks[array_rand($neutralFeedbacks)];
                } else {
                    // 10% negative feedback (rating 1-2)
                    $rating = rand(1, 2);
                    $content = $negativeFeedbacks[array_rand($negativeFeedbacks)];
                }

                // Tentukan status dan tanggapan
                $statusChance = rand(1, 100);
                if ($statusChance <= 40) {
                    // 40% sudah ditanggapi
                    $status = Feedback::STATUS_DITANGGAPI;
                    $response = $sellerResponses[array_rand($sellerResponses)];
                    $respondedAt = now()->subDays(rand(0, 7));
                } elseif ($statusChance <= 70) {
                    // 30% sudah dibaca
                    $status = Feedback::STATUS_DIBACA;
                    $response = null;
                    $respondedAt = null;
                } else {
                    // 30% masih menunggu
                    $status = Feedback::STATUS_MENUNGGU;
                    $response = null;
                    $respondedAt = null;
                }

                // Buat feedback
                Feedback::create([
                    'user_id' => $pembeli->id,
                    'canteen_id' => $canteen->id,
                    'order_id' => $order?->id,
                    'content' => $content,
                    'rating' => $rating,
                    'status' => $status,
                    'response' => $response,
                    'responded_at' => $respondedAt,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                $feedbackCount++;
            }
        }

        $this->command->info("Berhasil membuat {$feedbackCount} feedback untuk " . $canteens->count() . " kantin.");
    }
}
