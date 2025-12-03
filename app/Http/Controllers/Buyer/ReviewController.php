<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($productId, $orderId)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        $product = Product::findOrFail($productId);

        $existingReview = ProductReview::where('user_id', Auth::id())
                                       ->where('product_id', $productId)
                                       ->where('order_id', $orderId)
                                       ->first();

        if ($existingReview) {
            return back()->with('error', 'Kamu sudah mengulas produk ini.');
        }

        return view('buyer.reviews.create', compact('product', 'order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'product_id' => 'required',
            'order_id' => 'required'
        ]);

        ProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->route('orders.show', $request->order_id)
                         ->with('success', 'Terima kasih atas ulasanmu!');
    }
}