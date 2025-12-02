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
    // 0. Menampilkan Halaman Checkout
    public function showCheckoutPage()
    {
        $user = Auth::user();
        
        // Ambil data cart user
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        // Jika tidak ada cart atau kosong
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong, silahkan pilih produk dulu.');
        }

        return view('buyer.orders.checkout', compact('cart'));
    }

    // 1. Proses Checkout (POST)
    public function checkout(Request $request)
    {
        // [DIHAPUS] Validasi alamat tidak lagi diperlukan

        $user = Auth::user();
        
        // Ambil keranjang user
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        // Cek jika keranjang kosong
        if (!$cart || $cart->items->count() == 0) {
            return back()->with('error', 'Keranjang belanja Anda kosong!');
        }

        // Ambil item yang dicentang user
        $selectedIds = explode(',', $request->selected_items_ids);

        if (empty($selectedIds) || $selectedIds[0] === "") {
            return back()->with('error', 'Silakan pilih produk yang ingin di-checkout.');
        }

        // Filter item terpilih saja
        $selectedItems = $cart->items()->whereIn('id', $selectedIds)->get();

        if ($selectedItems->count() === 0) {
            return back()->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        // Gunakan Transaksi Database untuk keamanan data
        DB::transaction(function () use ($user, $cart, $selectedItems) {

            // Hitung total berdasarkan item terpilih
            $totalPrice = $selectedItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // A. Buat Header Order
            $order = Order::create([
                'user_id'      => $user->id,
                'total_price'  => $totalPrice,
                'status'       => 'pending',
                'invoice_code' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                // 'address' / 'address_id' sudah dihapus dari sini
            ]);

            // B. Pindahkan item yang DIPILIH ke order item
            foreach ($selectedItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'store_id'   => $item->product->store_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'subtotal'   => $item->product->price * $item->quantity,
                    'status'     => 'pending',
                ]);

                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }

            // C. Hapus hanya item yang dicentang dari keranjang
            $cart->items()->whereIn('id', $selectedItems->pluck('id'))->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat! Mohon tunggu konfirmasi penjual.');
    }

    // 2. Lihat Riwayat Pesanan
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('buyer.orders.index', compact('orders'));
    }

    // 3. Lihat Detail Pesanan
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
        $order = Order::with('items')->where('user_id', Auth::id())
                      ->where('id', $id)
                      ->firstOrFail();

        // Cek Status (Hanya boleh batal jika status 'pending')
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::beginTransaction();
        try {
            // Ubah Status jadi 'cancelled'
            $order->update(['status' => 'cancelled']);

            // Kembalikan Stok Produk
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