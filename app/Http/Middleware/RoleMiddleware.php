<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (! $request->user()) {
            return redirect('/login');
        }

        // 1. Cek Role (Admin/Seller/Buyer)
        if ($request->user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 2. KHUSUS SELLER: Cek Status Approval
        if ($role === 'seller') {
            if ($request->user()->status === 'pending') {
                return redirect()->route('seller.pending');
            }
            if ($request->user()->status === 'rejected') {
                return redirect()->route('seller.rejected');
            }
        }

        return $next($request);
    }
}