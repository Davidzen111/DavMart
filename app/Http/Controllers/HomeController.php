<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    // 1. Halaman Depan (Homepage)
    public function index(Request $request)
    {
        // Ambil Keyword Pencarian (Jika ada)
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil Data Produk (Terbaru)
        $products = $query->latest()->get();

        // Ambil Kategori (Untuk menu filter)
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }

    // 2. Halaman Detail Produk (INI YANG TADI KURANG)
    public function show($id)
    {
        // Ambil produk beserta relasi Toko, Kategori, dan Review+User-nya
        $product = Product::with(['store', 'category', 'reviews.user'])
                          ->findOrFail($id);

        // Hitung rata-rata rating & total review
        // (Menggunakan collection Laravel biar praktis)
        $ratingAvg = $product->reviews->avg('rating');
        $ratingCount = $product->reviews->count();

        return view('product_detail', compact('product', 'ratingAvg', 'ratingCount'));
    }
}