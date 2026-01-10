<?php

use App\Http\Controllers\CanteenController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Models\Canteen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    // ==========================================
    // NURIL: Canteen Resource Routes
    // ==========================================
    Route::resource('canteens', CanteenController::class);

    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'penjual') {
            // JIKA PENJUAL: Panggil logika di CanteenController
            return app(CanteenController::class)->dashboard();
        } else {
            // JIKA PEMBELI: Logika tetap disini (atau bisa dipindah ke Controller lain, serterah)
            $canteens = Canteen::where('is_open', true)->latest()->take(6)->get();
            $categories = Canteen::select('category')->distinct()->pluck('category');

            return view('dashboards.pembeli', [
                'canteens' => $canteens,
                'categories' => $categories
            ]);
        }
    })->name('dashboard');

    // ==========================================
    // CANTEEN ROUTES (Penjual)
    // ==========================================
    Route::post('/canteen/toggle-open', [CanteenController::class, 'toggleOpen'])->name('canteen.toggle');
    Route::get('/canteen/edit', [CanteenController::class, 'showFormEdit'])->name('canteen.edit');
    Route::put('/canteen/update', [CanteenController::class, 'update'])->name('canteen.update');
    Route::delete('/canteen/destroy', [CanteenController::class, 'destroy'])->name('canteen.destroy');

    // ==========================================
    // MENU ITEMS ROUTES (Penjual only)
    // ==========================================
    Route::prefix('menu-items')->name('menu-items.')->group(function () {
        Route::get('/', [MenuItemController::class, 'index'])->name('index');
        Route::get('/create', [MenuItemController::class, 'create'])->name('create');
        Route::post('/', [MenuItemController::class, 'store'])->name('store');
        Route::get('/{menuItem}', [MenuItemController::class, 'show'])->name('show');
        Route::get('/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('edit');
        Route::put('/{menuItem}', [MenuItemController::class, 'update'])->name('update');
        Route::delete('/{menuItem}', [MenuItemController::class, 'destroy'])->name('destroy');
        Route::post('/{menuItem}/toggle', [MenuItemController::class, 'toggleAvailability'])->name('toggle');
    });

    // ==========================================
    // ORDER ROUTES (Pembeli)
    // ==========================================
    Route::prefix('orders')->name('orders.')->group(function () {
        // Pembeli: Order history
        Route::get('/', [OrderController::class, 'index'])->name('index');

        // Pembeli: Create order
        Route::post('/', [OrderController::class, 'store'])->name('store');

        // Pembeli: View single order
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');

        // Pembeli: Cancel order
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // ==========================================
    // CANTEEN MENU & CHECKOUT ROUTES (Pembeli)
    // ==========================================
    Route::prefix('canteen')->name('canteen.')->group(function () {
        // View canteen menu for ordering
        Route::get('/{canteen:slug}/menu', [OrderController::class, 'showMenu'])->name('menu');

        // Checkout page
        Route::get('/{canteen:slug}/checkout', [OrderController::class, 'checkout'])->name('checkout');

        // API: Get menu items for cart (JSON)
        Route::get('/{canteen}/menu-items', [OrderController::class, 'getMenuItems'])->name('menu-items');
    });

    // ==========================================
    // SELLER ORDER MANAGEMENT ROUTES (Penjual)
    // ==========================================
    Route::prefix('seller/orders')->name('seller.orders.')->group(function () {
        // Incoming orders (menunggu + diproses)
        Route::get('/', [OrderController::class, 'incoming'])->name('incoming');

        // Order history (selesai + batal)
        Route::get('/history', [OrderController::class, 'history'])->name('history');

        // View single order
        Route::get('/{order}', [OrderController::class, 'showForSeller'])->name('show');

        // Update order status
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
    });

    // ==========================================
    // IKRAM: FEEDBACK ROUTES (Pembeli)
    // ==========================================
    Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
        // Pembeli: Daftar feedback yang sudah dikirim
        Route::get('/', [FeedbackController::class, 'index'])->name('index');

        // Pembeli: Form buat feedback baru
        Route::get('/create', [FeedbackController::class, 'create'])->name('create');

        // Pembeli: Simpan feedback baru
        Route::post('/', [FeedbackController::class, 'store'])->name('store');

        // Pembeli: Lihat detail feedback
        Route::get('/{feedback}', [FeedbackController::class, 'show'])->name('show');
    });

    // ==========================================
    // IKRAM: SELLER FEEDBACK MANAGEMENT ROUTES (Penjual)
    // ==========================================
    Route::prefix('seller/feedbacks')->name('seller.feedbacks.')->group(function () {
        // Penjual: Daftar feedback masuk
        Route::get('/', [FeedbackController::class, 'sellerIndex'])->name('index');

        // Penjual: Lihat detail feedback
        Route::get('/{feedback}', [FeedbackController::class, 'sellerShow'])->name('show');

        // Penjual: Kirim tanggapan
        Route::post('/{feedback}/respond', [FeedbackController::class, 'respond'])->name('respond');

        // Penjual: Update status feedback (tandai dibaca)
        Route::patch('/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('status');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
