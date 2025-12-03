<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index() {
        $orders = Order::where('user_id', Auth::id())
                        ->with('items') 
                        ->latest()
                        ->get();

        return view('buyer.dashboard', compact('orders'));
    }
}