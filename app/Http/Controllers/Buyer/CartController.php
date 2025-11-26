<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Tampilkan Isi Keranjang
    public function index()
    {
        // Ambil keranjang milik user yang login
        $cart = Cart::with('items.product.store')->where('user_id', Auth::id())->first();
        
        return view('buyer.cart', compact('cart'));
    }

    // 2. Tambah Barang ke Keranjang
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Validasi Stok
        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk habis!');
        }

        // Cek apakah user sudah punya keranjang? Kalau belum, buatkan.
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        // Cek apakah barang ini sudah ada di keranjang?
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Kalau sudah ada, tambah quantity-nya
            $cartItem->increment('quantity');
        } else {
            // Kalau belum ada, buat item baru
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang!');
    }

    // 3. Hapus Item dari Keranjang
    public function destroy($id)
    {
        CartItem::destroy($id);
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}