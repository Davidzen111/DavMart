<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Daftar Pesanan Masuk
    public function index()
    {
        // Ambil item pesanan yang KHUSUS untuk toko si login ini
        $storeId = Auth::user()->store->id;
        
        $orderItems = OrderItem::with(['product', 'order.user'])
                               ->where('store_id', $storeId)
                               ->latest()
                               ->get();

        return view('seller.orders.index', compact('orderItems'));
    }

    // 2. Update Status Pesanan (Per Item)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $item = OrderItem::where('store_id', Auth::user()->store->id)->findOrFail($id);
        
        $item->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}