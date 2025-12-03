<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use App\Models\Product; 

class WishlistController extends Controller
{
    public function toggle($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); 
        }

        $user = Auth::user();

        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'Produk berhasil dihapus dari favorit.';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $message = 'Produk berhasil ditambahkan ke favorit!';
        }

        return back()->with('success', $message);
    }
    
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->latest()->get();

        return view('buyer.wishlist.index', compact('wishlists'));
    }
}