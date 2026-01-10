<?php

use App\Http\Controllers\MenuController;
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
            return app(CanteenController::class)->dashboard();
        } else {
            $canteens = Canteen::where('is_open', true)->latest()->take(6)->get();
            $categories = Canteen::select('category')->distinct()->pluck('category');
            
            return view('dashboards.pembeli', [
                'canteens' => $canteens,
                'categories' => $categories
            ]);
        }
    })->name('dashboard');

    Route::post('/canteen/toggle-open', [CanteenController::class, 'toggleOpen'])->name('canteen.toggle');
    Route::get('/canteen/edit', [CanteenController::class, 'showFormEdit'])->name('canteen.edit');
    Route::put('/canteen/update', [CanteenController::class, 'update'])->name('canteen.update');
    Route::delete('/canteen/destroy', [CanteenController::class, 'destroy'])->name('canteen.destroy');

    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::patch('/menus/{menu}/toggle', [MenuController::class, 'toggleAvailability'])->name('menus.toggle');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
});

require __DIR__.'/auth.php';