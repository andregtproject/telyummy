<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CanteenController extends Controller
{
    public function index()
    {
        $canteens = Canteen::where('user_id', Auth::id())->get();
        return view('canteens.index', compact('canteens'));
    }

    public function create()
    {
        return view('canteens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Canteen::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'description' => $request->description,
            'is_open' => true,
        ]);

        return redirect()->route('canteens.index')
            ->with('success', 'Tenant berhasil ditambahkan');
    }

    public function edit(Canteen $canteen)
    {
        return view('canteens.edit', compact('canteen'));
    }

    public function update(Request $request, Canteen $canteen)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_open' => 'required|boolean',
        ]);

        $canteen->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'description' => $request->description,
            'is_open' => $request->is_open,
        ]);

        return redirect()->route('canteens.index')
            ->with('success', 'Tenant berhasil diperbarui');
    }

    public function destroy(Canteen $canteen)
    {
        $canteen->delete();

        return redirect()->route('canteens.index')
            ->with('success', 'Tenant berhasil dihapus');
    }
}
