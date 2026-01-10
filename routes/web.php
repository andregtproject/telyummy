<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanteenController;
use App\Models\Canteen;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {

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

    // Route khusus Kantin
    Route::post('/canteen/toggle-open', [CanteenController::class, 'toggleOpen'])->name('canteen.toggle');
    Route::get('/canteen/edit', [CanteenController::class, 'showFormEdit'])->name('canteen.edit');
    Route::put('/canteen/update', [CanteenController::class, 'update'])->name('canteen.update');
    Route::delete('/canteen/destroy', [CanteenController::class, 'destroy'])->name('canteen.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
