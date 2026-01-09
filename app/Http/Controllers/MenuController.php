<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        // Ambil data kantin milik user yang sedang login
        $canteen = Canteen::where('user_id', Auth::id())->first();

        // Jika user belum punya kantin, lempar error 404 atau redirect
        if (!$canteen) {
            return redirect()->route('dashboard')->with('error', 'Anda belum mendaftarkan kantin.');
        }

        // Ambil semua menu milik kantin tersebut, urutkan dari yang terbaru
        $menus = $canteen->menus()->latest()->get();

        return view('menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string|max:255', 
            'image'       => 'required|image|max:2048',
        ]);

        $canteen = Canteen::where('user_id', Auth::id())->firstOrFail();

        $data = $request->all();
        $data['canteen_id'] = $canteen->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function update(Request $request, Menu $menu)
    {
        // Pastikan yang edit adalah pemilik kantin
        if ($menu->canteen->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric',
        'description' => 'required|string|max:255',
        // Image nullable saat update (karena user mungkin tidak ganti foto)
        'image'       => 'nullable|image|max:2048',
    ]);

        $data = $request->all();

        if (!$request->has('is_available')) {
            $data['is_available'] = 0;
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image) Storage::disk('public')->delete($menu->image);
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return back()->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->canteen->user_id !== Auth::id()) {
            abort(403);
        }

        if ($menu->image) Storage::disk('public')->delete($menu->image);
        $menu->delete();

        return back()->with('success', 'Menu dihapus.');
    }

    // Ketersediaan Menu
    public function toggleAvailability(Menu $menu)
    {
        // Pastikan menu milik kantin user yang login
        if ($menu->canteen->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $menu->is_available = !$menu->is_available;
        $menu->save();

        return response()->json(['success' => true, 'is_available' => $menu->is_available]);
    }
}