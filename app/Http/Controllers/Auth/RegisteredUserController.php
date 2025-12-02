<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store; // Pastikan Model Store di-import
use App\Models\Cart; // Pastikan Model Cart di-import
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
// use App\Providers\RouteServiceProvider; // <-- DIHAPUS karena Laravel 12 tidak punya file ini

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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:buyer,seller'], // Validasi input Role dari form
        ]);

        // 1. Tentukan Status Awal
        $status = ($request->role === 'seller') ? 'pending' : 'approved';

        // 2. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Simpan role (buyer/seller)
            'status' => $status, // Simpan status
        ]);

        // 3. Logika Tambahan Berdasarkan Role
        if ($request->role === 'seller') {
            // Jika Seller: Buatkan Toko Otomatis
            Store::create([
                'user_id' => $user->id,
                'name' => 'Toko ' . $request->name,
                'slug' => \Illuminate\Support\Str::slug('Toko ' . $request->name . '-' . $user->id),
                'description' => 'Deskripsi toko belum diatur.',
            ]);
        } elseif ($request->role === 'buyer') {
            // Jika Buyer: Buatkan Keranjang Kosong
            Cart::create([
                'user_id' => $user->id
            ]);
        }

        event(new Registered($user));

        Auth::login($user);


        if ($user->role === 'seller') {
            return redirect()->route('seller.pending');
        }

        // Buyer -> Dashboard utama
        return redirect()->route('dashboard'); // <-- PERBAIKAN DI SINI
    }
}
