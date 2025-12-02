<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// use App\Providers\RouteServiceProvider; // <-- HAPUS karena Laravel 12 tidak punya file ini

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ambil User Lengkap (Bukan cuma role)
        $user = $request->user();

        // 1. Cek Admin
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } 
        
        // 2. Cek Seller
        if ($user->role === 'seller') {
            // LOGIKA TAMBAHAN: Cek Status Approval
            if ($user->status == 'pending') {
                return redirect()->route('seller.pending');
            }
            if ($user->status == 'rejected') {
                return redirect()->route('seller.rejected');
            }

            return redirect()->intended(route('seller.dashboard'));
        }

        // 3. Default (Buyer)
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            return route('admin.dashboard');
        }

        if (Auth::user()->role === 'seller') {
            return route('seller.dashboard');
        }

        return route('dashboard'); 
    }
}
