<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; 

class HomeController extends Controller
{
    // 1. Halaman Depan (Homepage)
    public function index(Request $request)
    {
        $recommendedProducts = Product::with(['store', 'category', 'reviews'])
            ->whereHas('store.user', function($q){
                $q->where('status', 'approved');
            })
            ->withAvg('reviews', 'rating') // Menghitung rata-rata kolom 'rating' di relasi 'reviews'
            ->orderByDesc('reviews_avg_rating') // Urutkan dari rating tertinggi
            ->take(4) // Batasi hanya 4 produk
            ->get();


        $query = Product::with('store', 'category', 'reviews')->whereHas('store.user', function($q){
            
            $q->where('status', 'approved'); 
            
        });
        
        // --- LOGIKA FILTER LAINNYA ---

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // --- LOGIKA SORTING ---
        
        if ($request->filled('sort')) {
            if ($request->sort == 'price_asc') { // Saya sesuaikan value dengan view blade sebelumnya (price_asc)
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') { // (price_desc)
                $query->orderBy('price', 'desc');
            }
            elseif ($request->filled('rating')) {
                 $query->withAvg('reviews', 'rating')
                        ->having('reviews_avg_rating', '>=', $request->rating);
            }
        } else {
            $query->latest();
        }
        
        $products = $query->get(); 

        $categories = Category::all();

        return view('welcome', compact('products', 'categories', 'recommendedProducts'));
    }

    // 2. Halaman Detail Produk
    public function show($id)
    {
        $product = Product::with(['store', 'category', 'reviews.user'])
                            ->findOrFail($id);

        $ratingAvg = $product->reviews->avg('rating');
        $ratingCount = $product->reviews->count();

        $isWishlisted = false;
        
        if (Auth::check()) {
            $isWishlisted = Auth::user()->wishlists()->where('product_id', $product->id)->exists();
        }
        return view('product_detail', compact('product', 'ratingAvg', 'ratingCount', 'isWishlisted')); // <-- $isWishlisted DITAMBAHKAN
    }
}