<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // <--- JANGAN LUPA INI!

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    // --- TAMBAHKAN KODE DI BAWAH INI ---

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