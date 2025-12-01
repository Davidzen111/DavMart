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

        // --- LOGIKA STATUS (FINAL) ---
        if ($user->status === 'pending') {
            return redirect()->route('seller.pending');
        }

        if ($user->status === 'rejected') {
            return redirect()->route('seller.rejected');
        }

        if ($user->status !== 'approved') {
            return redirect('/');
        }

        $store = $user->store;

        if (!$store) {
            return redirect()->route('profile.edit')
                ->with('error', 'Silakan lengkapi profil toko Anda.');
        }

        $productsCount = $store->products()->count();

        $newOrders = OrderItem::where('store_id', $store->id)
                              ->where('status', 'pending')
                              ->count();
        
        $income = OrderItem::where('store_id', $store->id)
                            ->where('status', 'delivered')
                            ->sum('subtotal');

        return view('seller.dashboard', compact('productsCount', 'newOrders', 'income'));
    }

    // 2. Halaman Pending
    public function pending()
    {
        $user = Auth::user();

        if ($user->status === 'approved') {
            return redirect()->route('seller.dashboard');
        }

        if ($user->status === 'rejected') {
            return redirect()->route('seller.rejected');
        }

        return view('seller.pending');
    }

    // 3. Halaman Rejected
    public function rejected()
    {
        $user = Auth::user();

        if ($user->status === 'approved') {
            return redirect()->route('seller.dashboard');
        }

        if ($user->status === 'pending') {
            return redirect()->route('seller.pending');
        }

        return view('seller.rejected');
    }

    // 4. Hapus Akun Seller
    public function destroy(Request $request)
    {
        $user = Auth::user(); 

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Akun Anda telah dihapus. Silakan daftar kembali.');
    }

    // --- FITUR PENGATURAN TOKO ---

    // 5. Form Edit Toko
    public function editStore()
    {
        $store = Auth::user()->store;
        return view('seller.store.edit', compact('store'));
    }

    // 6. Update Informasi Toko
    public function updateStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $store = Auth::user()->store;

        // Update nama & deskripsi
        $store->name = $request->name;
        $store->description = $request->description;

        // Upload gambar jika ada
        if ($request->hasFile('image')) {

            // Hapus gambar lama jika ada
            if ($store->image && file_exists(storage_path('app/public/' . $store->image))) {
                unlink(storage_path('app/public/' . $store->image));
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('store_images', 'public');
            $store->image = $path;
        }

        $store->save();

        return back()->with('success', 'Informasi toko berhasil diperbarui!');
    }
}
