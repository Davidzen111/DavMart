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
    // 0. Menampilkan Halaman Checkout (Ditambahkan agar route 'checkout' bekerja)
    public function showCheckoutPage()
    {
        $user = Auth::user();
        
        // Ambil data cart user untuk ditampilkan di halaman checkout
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        // Jika tidak ada cart atau kosong, lempar balik ke cart index
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong, silahkan pilih produk dulu.');
        }

        return view('buyer.orders.checkout', compact('cart'));
    }

    // 1. Proses Checkout (POST)
    public function checkout(Request $request)
    {
        // Validasi: Alamat Wajib Diisi
        $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        
        // Ambil keranjang user
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        // Cek jika keranjang kosong
        if (!$cart || $cart->items->count() == 0) {
            return back()->with('error', 'Keranjang belanja Anda kosong!');
        }

        // Gunakan Transaksi Database (Agar aman data tidak korup)
        DB::transaction(function () use ($user, $cart, $request) {
            
            // A. Hitung Total Harga
            $totalPrice = 0;
            foreach ($cart->items as $item) {
                $totalPrice += $item->product->price * $item->quantity;
            }

            // B. Buat Header Order (Simpan Alamat Disini)
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'invoice_code' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                'shipping_address' => $request->address, // ✅ Simpan Alamat dari Form
            ]);

            // C. Pindahkan Item dari Keranjang ke Order Item
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'store_id' => $item->product->store_id, // Penting untuk Seller
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity,
                    'status' => 'pending',
                ]);

                // D. Kurangi Stok Produk
                $item->product->decrement('stock', $item->quantity);
            }

            // E. Kosongkan Keranjang setelah berhasil
            $cart->items()->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat! Mohon tunggu konfirmasi penjual.');
    }

    // 2. Lihat Riwayat Pesanan
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('buyer.orders.index', compact('orders'));
    }

    // 3. Lihat Detail Pesanan (Untuk Review & Cek Status)
    public function show($id)
    {
        $order = Order::with('items.product.store')
                      ->where('user_id', Auth::id())
                      ->findOrFail($id);

        return view('buyer.orders.show', compact('order'));
    }

    // 4. Batalkan Pesanan
    public function cancel($id)
    {
        // 1. Cari Order milik user ini
        $order = Order::with('items')->where('user_id', Auth::id())
                      ->where('id', $id)
                      ->firstOrFail();

        // 2. Cek Status (Hanya boleh batal jika status 'pending')
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::beginTransaction();
        try {
            // 3. Ubah Status jadi 'cancelled'
            $order->update(['status' => 'cancelled']);

            // 4. (PENTING) Kembalikan Stok Produk
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            DB::commit();
            return back()->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan pesanan.');
        }
    }
}