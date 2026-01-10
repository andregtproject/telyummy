<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    /**
     * Get the canteen owned by the authenticated user.
     */
    private function getCanteen(): ?Canteen
    {
        return Auth::user()->canteen;
    }

    /**
     * Ensure the menu item belongs to the user's canteen.
     */
    private function authorizeMenuItem(MenuItem $menuItem): void
    {
        $canteen = $this->getCanteen();

        if (!$canteen || $menuItem->canteen_id !== $canteen->id) {
            abort(403, 'Anda tidak memiliki akses ke menu item ini.');
        }
    }

    /**
     * Display a listing of menu items for the canteen.
     */
    public function index(): View
    {
        $canteen = $this->getCanteen();

        if (!$canteen) {
            abort(404, 'Anda belum memiliki kantin.');
        }

        $menuItems = $canteen->menuItems()
            ->orderBy('category')
            ->orderBy('name')
            ->paginate(12);

        return view('menu-items.index', compact('canteen', 'menuItems'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create(): View
    {
        $canteen = $this->getCanteen();

        if (!$canteen) {
            abort(404, 'Anda belum memiliki kantin.');
        }

        $categories = MenuItem::getCategories();

        return view('menu-items.create', compact('canteen', 'categories'));
    }

    /**
     * Store a newly created menu item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $canteen = $this->getCanteen();

        if (!$canteen) {
            abort(404, 'Anda belum memiliki kantin.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'image' => ['required', 'image', 'max:2048'], // Max 2MB
            'is_available' => ['boolean'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        // Set default availability
        $validated['is_available'] = $request->boolean('is_available', true);
        $validated['canteen_id'] = $canteen->id;

        MenuItem::create($validated);

        return redirect()
            ->route('menu-items.index')
            ->with('success', 'Menu item berhasil ditambahkan!');
    }

    /**
     * Display the specified menu item.
     */
    public function show(MenuItem $menuItem): View
    {
        $this->authorizeMenuItem($menuItem);

        return view('menu-items.show', compact('menuItem'));
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menuItem): View
    {
        $this->authorizeMenuItem($menuItem);

        $categories = MenuItem::getCategories();

        return view('menu-items.edit', compact('menuItem', 'categories'));
    }

    /**
     * Update the specified menu item in storage.
     */
    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $this->authorizeMenuItem($menuItem);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:2048'], // Optional on update
            'is_available' => ['boolean'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        // Set availability
        $validated['is_available'] = $request->boolean('is_available', true);

        $menuItem->update($validated);

        return redirect()
            ->route('menu-items.index')
            ->with('success', 'Menu item berhasil diperbarui!');
    }

    /**
     * Remove the specified menu item from storage.
     */
    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $this->authorizeMenuItem($menuItem);

        // Delete image
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return redirect()
            ->route('menu-items.index')
            ->with('success', 'Menu item berhasil dihapus!');
    }

    /**
     * Toggle the availability of the specified menu item.
     */
    public function toggleAvailability(MenuItem $menuItem): RedirectResponse
    {
        $this->authorizeMenuItem($menuItem);

        $menuItem->update([
            'is_available' => !$menuItem->is_available,
        ]);

        $status = $menuItem->is_available ? 'tersedia' : 'tidak tersedia';

        return redirect()
            ->back()
            ->with('success', "Menu \"{$menuItem->name}\" sekarang {$status}.");
    }
}
