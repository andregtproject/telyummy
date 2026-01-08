<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Canteen;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CanteenController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        $canteen = Canteen::where('user_id', $user->id)->first();

        $dailyRevenue = 0;
        $yesterdayRevenue = 0;
        $weeklyRevenue = 0;
        $monthlyRevenue = 0;
        $incomingOrders = collect();
        $todaysOrderCount = 0;
        $rating = 0;

        if ($canteen) {
            $canteen_id = $canteen->id;

            // Pendapatan HARI INI
            $dailyRevenue = Order::where('canteen_id', $canteen_id)
                                 ->where('status', 'selesai') 
                                 ->whereDate('created_at', Carbon::today())
                                 ->sum('total_price');

            // Pendapatan KEMARIN (Untuk menghitung naik/turun)
            $yesterdayRevenue = Order::where('canteen_id', $canteen_id)
                                     ->where('status', 'selesai')
                                     ->whereDate('created_at', Carbon::yesterday())
                                     ->sum('total_price');

            // Pendapatan MINGGU INI
            $weeklyRevenue = Order::where('canteen_id', $canteen_id)
                                  ->where('status', 'selesai')
                                  ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                  ->sum('total_price');

            // Pendapatan BULAN INI
            $monthlyRevenue = Order::where('canteen_id', $canteen_id)
                                   ->where('status', 'selesai')
                                   ->whereMonth('created_at', Carbon::now()->month)
                                   ->whereYear('created_at', Carbon::now()->year)
                                   ->sum('total_price');

            // Pesanan Masuk (Status 'menunggu')
            $incomingOrders = Order::where('canteen_id', $canteen_id)
                                   ->where('status', 'menunggu')
                                   ->with('user')
                                   ->latest()
                                   ->get();

            // Total Transaksi Hari Ini (Semua status kecuali batal)
            $todaysOrderCount = Order::where('canteen_id', $canteen_id)
                                     ->whereDate('created_at', Carbon::today())
                                     ->count();

            // Rating
            $rating = $canteen->rating ?? 0;
            $totalReviews = Order::where('canteen_id', $canteen_id)
                     ->whereNotNull('rating')
                     ->count();
        }

        return view('dashboards.penjual', compact(
            'canteen',
            'dailyRevenue',
            'yesterdayRevenue',
            'weeklyRevenue',
            'monthlyRevenue',
            'incomingOrders',
            'todaysOrderCount',
            'rating',
            'totalReviews'
        ));
    }

    public function toggleOpen()
    {
        $user = Auth::user();
        $canteen = Canteen::where('user_id', $user->id)->firstOrFail();
        $canteen->update(['is_open' => !$canteen->is_open]);
        return back();
    }

    public function showFormEdit()
    {
        $canteen = Canteen::where('user_id', Auth::id())->firstOrFail();
        return view('profile.canteens.edit', compact('canteen'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $canteen = Canteen::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_photo' => 'nullable|image|max:2048',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'canteen_name' => 'required|string|max:255',
            'categories' => 'required|array|min:1',
            'description' => 'nullable|string',
            'canteen_photo' => 'nullable|image|max:2048',
            'location_description' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Update data pemilik
        $user->name = $request->owner_name;
        if ($request->hasFile('owner_photo')) {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            $user->avatar = $request->file('owner_photo')->store('user-avatars', 'public');
        }
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            ]);
            
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update data kantin
        $canteen->name = $request->canteen_name;
        $canteen->description = $request->description;
        $canteen->category = implode(', ', $request->categories);
        $canteen->location_description = $request->location_description;
        
        // Update koordinat lokasi
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $canteen->latitude = $request->latitude;
            $canteen->longitude = $request->longitude;
        }

        // Update foto kantin
        if ($request->hasFile('canteen_photo')) {
            if ($canteen->image && Storage::exists('public/' . $canteen->image)) {
                Storage::delete('public/' . $canteen->image);
            }
            $canteen->image = $request->file('canteen_photo')->store('canteen-images', 'public');
        }
        
        $canteen->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password_confirmation' => 'required|current_password']);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}