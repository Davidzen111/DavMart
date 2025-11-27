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
        $storeId = Auth::user()->store->id;
        
        $orderItems = OrderItem::with(['product', 'order.user'])
                               ->where('store_id', $storeId)
                               ->latest()
                               ->get();

        return view('seller.orders.index', compact('orderItems'));
    }

    // 2. Update Status Pesanan (DENGAN SINKRONISASI KE BUYER)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        // Cari item pesanan dan load relasi order induknya
        $item = OrderItem::with('order')->where('store_id', Auth::user()->store->id)->findOrFail($id);
        
        // A. Update Status Barang (Tabel order_items)
        $item->update([
            'status' => $request->status
        ]);

        // B. Update Status Induk Transaksi (Tabel orders) - PENTING!
        // Ini supaya di Dashboard Buyer statusnya ikut berubah
        $parentOrder = $item->order;

        if ($parentOrder) {
            if ($request->status == 'processing') {
                $parentOrder->update(['status' => 'processing']);
            }
            elseif ($request->status == 'shipped') {
                $parentOrder->update(['status' => 'shipped']);
            }
            elseif ($request->status == 'delivered') {
                // Di tabel Order induk statusnya 'completed', di item 'delivered'
                $parentOrder->update(['status' => 'completed']);
            }
            elseif ($request->status == 'cancelled') {
                $parentOrder->update(['status' => 'cancelled']);
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}