<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Keyword Pencarian (Jika ada)
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Ambil Data Produk (Terbaru)
        $products = $query->latest()->get();

        // 3. Ambil Kategori (Untuk menu filter nanti)
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }
}