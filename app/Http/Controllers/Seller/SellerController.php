<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem; // Import Model OrderItem untuk hitung statistik

class SellerController extends Controller
{
    // 1. Dashboard Utama (Ringkasan Toko)
    public function index() 
    {
        $store = Auth::user()->store;

        // Hitung Statistik untuk ditampilkan di Dashboard
        $productsCount = $store->products()->count();
        $newOrders = OrderItem::where('store_id', $store->id)->where('status', 'pending')->count();
        
        // Hitung Pendapatan (Hanya yang statusnya 'delivered')
        $income = OrderItem::where('store_id', $store->id)
                           ->where('status', 'delivered')
                           ->sum('subtotal');

        return view('seller.dashboard', compact('productsCount', 'newOrders', 'income'));
    }

    // 2. Halaman Menunggu Persetujuan
    public function pending() {
        return view('seller.pending');
    }

    // 3. Halaman Ditolak
    public function rejected() {
        return view('seller.rejected');
    }

    // 4. Hapus Akun (Jika Ditolak)
    public function destroy(Request $request)
    {
        $user = Auth::user(); 

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Akun Anda telah dihapus. Silakan daftar kembali.');
    }

    // --- FITUR BARU: PENGATURAN TOKO ---

    // 5. Tampilkan Form Edit Toko
    public function editStore()
    {
        $store = Auth::user()->store;
        return view('seller.store.edit', compact('store'));
    }

    // 6. Proses Update Toko
    public function updateStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $store = Auth::user()->store;
        
        $store->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Informasi toko berhasil diperbarui!');
    }
}