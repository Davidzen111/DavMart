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
    public function index()
    {
        $cart = Cart::with('items.product.store')->where('user_id', Auth::id())->first();
        
        return view('buyer.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk habis!');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang!');
    }

    public function destroy($id)
    {
        CartItem::destroy($id);
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1', // Pastikan kuantitas minimal 1
        ]);

        $item = CartItem::findOrFail($itemId);

        if ($item->cart->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }
        
        $item->quantity = $request->quantity;
        $item->save();

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }
}