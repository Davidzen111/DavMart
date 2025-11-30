<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem; 

class SellerController extends Controller
{
    // 1. Dashboard Utama (Ringkasan Toko)
    public function index() 
    {
        $user = Auth::user();

        // --- LOGIKA PENGECEKAN STATUS (DIPERBAIKI) ---
        
        // Cek 1: Jika status masih PENDING, lempar ke halaman pending
        if ($user->status === 'pending') {
            return redirect()->route('seller.pending');
        }

        // Cek 2: Jika status REJECTED, lempar ke halaman rejected
        // (Sebelumnya ini tidak ada, makanya lari ke pending terus)
        if ($user->status === 'rejected') {
            return redirect()->route('seller.rejected');
        }

        // Cek 3: Pastikan status Approved sebelum lanjut
        if ($user->status !== 'approved') {
            // Safety net: jika status tidak jelas, logout atau ke home
            return redirect('/');
        }

        $store = $user->store;

        // Cek Safety: Jika toko belum dibuat
        if (!$store) {
            return redirect()->route('profile.edit')->with('error', 'Silakan lengkapi profil toko Anda.');
        }

        // Hitung Statistik untuk ditampilkan di Dashboard
        $productsCount = $store->products()->count();
        
        // Hitung pesanan baru (status pending)
        $newOrders = OrderItem::where('store_id', $store->id)
                              ->where('status', 'pending')
                              ->count();
        
        // Hitung Pendapatan (Hanya yang statusnya 'delivered' / selesai)
        $income = OrderItem::where('store_id', $store->id)
                            ->where('status', 'delivered')
                            ->sum('subtotal');

        return view('seller.dashboard', compact('productsCount', 'newOrders', 'income'));
    }

    // 2. Halaman Menunggu Persetujuan
    public function pending() {
        $user = Auth::user();

        // Jika sudah Approved, tendang ke dashboard
        if ($user->status === 'approved') {
            return redirect()->route('seller.dashboard');
        }

        // PERBAIKAN: Jika status Ditolak (Rejected), jangan kasih lihat halaman pending
        // Lempar ke halaman rejected
        if ($user->status === 'rejected') {
            return redirect()->route('seller.rejected');
        }
        
        return view('seller.pending');
    }

    // 3. Halaman Ditolak
    public function rejected() {
        $user = Auth::user();

        // Safety: Kalau user iseng buka link ini padahal statusnya Approved/Pending
        if ($user->status === 'approved') {
            return redirect()->route('seller.dashboard');
        }
        if ($user->status === 'pending') {
            return redirect()->route('seller.pending');
        }

        return view('seller.rejected');
    }

    // 4. Hapus Akun (Jika Ditolak Admin & Ingin Daftar Ulang)
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