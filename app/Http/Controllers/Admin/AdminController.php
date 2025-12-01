<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Order; // Tambahkan model Order untuk menghitung total transaksi
use Illuminate\Support\Facades\DB; // Optional, tapi berguna untuk SUM

class AdminController extends Controller
{
    // Method index sekarang mengirim data statistik ke view
    public function index() {
        
        // ===============================================
        // LOGIKA PENGAMBILAN DATA REAL-TIME UNTUK DASHBOARD
        // ===============================================

        // 1. Total User (Semua user kecuali Admin yang sedang login)
        // Asumsi: Semua user yang bukan admin adalah target pengguna yang dihitung
        $totalUsers = User::where('role', '!=', 'admin')->count();

        // 2. Pending Sellers (Role seller dan status pending)
        $pendingSellers = User::where('role', 'seller')
                              ->where('status', 'pending')
                              ->count();

        // 3. Total Transaksi (Total harga dari semua pesanan yang sudah Completed/Selesai)
        $totalIncomeValue = Order::where('status', 'completed')->sum('total_price');

        // Format untuk tampilan (misal: Rp 45.2jt, di sini saya akan menyederhanakannya)
        // Menggunakan number_format untuk format ribuan
        $formattedIncome = 'Rp ' . number_format($totalIncomeValue, 0, ',', '.');
        
        // Perhatian: Jika Anda ingin format 'jt' (juta), logicnya ada di Blade,
        // namun saya kirim nilai yang sudah diformat ribuan saja, atau kirim raw value
        
        // Mengirim data ke view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'pendingSellers' => $pendingSellers,
            'totalIncome' => $formattedIncome, // Mengirim total pendapatan yang sudah diformat
        ]);
    }

    // --- KODE LAIN YANG ADA DI FILE (sellerVerification dan approveSeller) ---

    // 1. Tampilkan Daftar Seller Pending
    public function sellerVerification() {
        // Ambil user yang role-nya 'seller' DAN status-nya 'pending'
        $pendingSellers = User::where('role', 'seller')
                             ->where('status', 'pending')
                             ->get();
        
        return view('admin.seller_verification', compact('pendingSellers'));
    }

    // 2. Proses Approve atau Reject
    public function approveSeller(Request $request, $id) {
        $user = User::findOrFail($id);
        
        // Validasi input status harus 'approved' atau 'rejected'
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        // Update status
        $user->status = $request->status;
        $user->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('admin.seller.verification')
                         ->with('success', 'Status Seller berhasil diperbarui!');
    }
}