<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                            ->where('product_id', $productId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Dihapus dari favorit.');
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
            return back()->with('success', 'Ditambahkan ke favorit!');
        }
    }

    public function index()
    {
        $wishlists = \App\Models\Wishlist::with('product.store')
                        ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                        ->latest()
                        ->get();

        return view('buyer.wishlist.index', compact('wishlists'));
    }
}