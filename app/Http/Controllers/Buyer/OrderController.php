<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // 1. Proses Checkout
    public function checkout()
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->count() == 0) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // Gunakan Database Transaction biar aman (Kalau error, rollback semua)
        DB::transaction(function () use ($user, $cart) {
            
            // A. Hitung Total Harga
            $totalPrice = 0;
            foreach ($cart->items as $item) {
                $totalPrice += $item->product->price * $item->quantity;
            }

            // B. Buat Order Header
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'invoice_code' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
            ]);

            // C. Pindahkan Item Cart ke Order Item
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'store_id' => $item->product->store_id, // PENTING: Supaya Seller bisa lihat orderan ini
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);

                // D. Kurangi Stok Produk
                $item->product->decrement('stock', $item->quantity);
            }

            // E. Kosongkan Keranjang
            $cart->items()->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    // 2. Lihat Riwayat Pesanan
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('buyer.orders.index', compact('orders'));
    }
}