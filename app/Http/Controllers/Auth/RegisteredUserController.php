<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Canteen;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi inputan agar tidak kosong/salah format
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'role' => ['required', 'in:pembeli,penjual'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            // Validasi khusus pembeli
            'identity_card' => ['required_if:role,pembeli', 'nullable', 'image', 'max:2048'],
            // Validasi khusus penjual
            'canteen_name' => ['required_if:role,penjual', 'nullable', 'string', 'max:255'],
            'canteen_image' => ['required_if:role,penjual', 'nullable', 'image', 'max:2048'],
            'latitude' => ['required_if:role,penjual', 'nullable'],
            'longitude' => ['required_if:role,penjual', 'nullable'],
        ], [
            // Pesan error kustom bahasa Indonesia
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'canteen_name.required_if' => 'Nama kantin wajib diisi untuk penjual.',
            'identity_card.required_if' => 'Foto KTM wajib diunggah untuk pembeli.',
        ]);

        // Simpan User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null,
            'identity_card' => $request->file('identity_card') ? $request->file('identity_card')->store('identities', 'public') : null,
        ]);

        // Simpan Kantin jika role penjual
        if ($request->role === 'penjual') {
            Canteen::create([
                'user_id' => $user->id,
                'name' => $request->canteen_name,
                'slug' => Str::slug($request->canteen_name) . '-' . Str::random(5),
                'description' => $request->description,
                'location_description' => $request->location_description,
                'image' => $request->file('canteen_image')->store('canteens', 'public'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }

        Auth::login($user);
        return redirect(route('dashboard'));
    }
}
