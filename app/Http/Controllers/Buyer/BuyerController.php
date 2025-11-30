<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // <--- Jangan lupa import Model Order
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index() {
        // Ambil riwayat pesanan milik user yang sedang login
        $orders = Order::where('user_id', Auth::id())
                        ->with('items') // Load detail item biar efisien
                        ->latest()
                        ->get();

        return view('buyer.dashboard', compact('orders'));
    }
}