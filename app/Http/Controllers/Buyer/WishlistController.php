<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist; // Perlu model Wishlist
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use App\Models\Product; // Perlu model Product untuk konteks

class WishlistController extends Controller
{
    // Method ini dipanggil oleh route POST: wishlist.toggle
    public function toggle($productId)
    {
        // Redirect jika belum login (walaupun route sudah punya middleware auth, ini untuk keamanan ekstra)
        if (!Auth::check()) {
            // Karena ini dipanggil dari form/AJAX, kita redirect ke login
            return redirect()->route('login'); 
        }

        $user = Auth::user();

        // Cari item wishlist yang cocok
        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->first();

        if ($wishlistItem) {
            // JIKA ADA: HAPUS (Toggle OFF)
            $wishlistItem->delete();
            $message = 'Produk berhasil dihapus dari favorit.';
        } else {
            // JIKA BELUM ADA: TAMBAHKAN (Toggle ON)
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $message = 'Produk berhasil ditambahkan ke favorit!';
        }

        // Kembali ke halaman sebelumnya. Jika menggunakan AJAX, ini akan memicu refresh atau notifikasi.
        return back()->with('success', $message);
    }
    
    // Asumsi Anda memiliki method index untuk menampilkan daftar wishlist user
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->latest()->get();

        // Pastikan Anda memiliki view di 'buyer.wishlist.index'
        return view('buyer.wishlist.index', compact('wishlists'));
    }
}