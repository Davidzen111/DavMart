<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; // <-- DITAMBAHKAN: Diperlukan untuk Auth::check() dan Auth::user()

class HomeController extends Controller
{
    // 1. Halaman Depan (Homepage)
    public function index(Request $request)
    {
        // =================================================================
        // [BARU] LOGIKA REKOMENDASI PRODUK (POPULER / RATING TERTINGGI)
        // =================================================================
        // Kriteria:
        // 1. Toko harus 'approved' (sama seperti query utama).
        // 2. Diurutkan berdasarkan rata-rata rating review tertinggi.
        // 3. Hanya mengambil 4 item teratas.
        
        $recommendedProducts = Product::with(['store', 'category', 'reviews'])
            ->whereHas('store.user', function($q){
                $q->where('status', 'approved');
            })
            ->withAvg('reviews', 'rating') // Menghitung rata-rata kolom 'rating' di relasi 'reviews'
            ->orderByDesc('reviews_avg_rating') // Urutkan dari rating tertinggi
            ->take(4) // Batasi hanya 4 produk
            ->get();


        // =================================================================
        // QUERY UTAMA (UNTUK LIST "SEMUA PRODUK")
        // =================================================================
        
        // Query utama: Ambil semua produk
        // 🚨 PERBAIKAN KRITIS: Mengubah whereHas('store', ...) menjadi whereHas('store.user', ...)
        // Status 'approved' ada di tabel 'users', bukan di 'stores'.
        $query = Product::with('store', 'category', 'reviews')->whereHas('store.user', function($q){
            
            // Kolom 'status' berada di tabel 'users' (yang direpresentasikan oleh $q di sini)
            $q->where('status', 'approved'); 
            
        });
        
        // --- LOGIKA FILTER LAINNYA ---

        // 1. Filter Pencarian (Search)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 3. Filter Harga Minimum
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // 4. Filter Harga Maksimum
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
            // Tambahan jika filter rating dipilih di "Filter Lanjut"
            elseif ($request->filled('rating')) {
                 $query->withAvg('reviews', 'rating')
                        ->having('reviews_avg_rating', '>=', $request->rating);
            }
        } else {
            // Default sorting: Terbaru
            $query->latest();
        }
        
        // AMBIL SEMUA DATA
        $products = $query->get(); 

        // Ambil Kategori (Untuk menu filter di view)
        $categories = Category::all();

        // Kirim $recommendedProducts ke view
        return view('welcome', compact('products', 'categories', 'recommendedProducts'));
    }

    // 2. Halaman Detail Produk
    public function show($id)
    {
        // Ambil produk beserta relasi Toko, Kategori, dan Review+User-nya
        $product = Product::with(['store', 'category', 'reviews.user'])
                            ->findOrFail($id);

        // Hitung rata-rata rating & total review
        $ratingAvg = $product->reviews->avg('rating');
        $ratingCount = $product->reviews->count();

        // ----------------------------------------------------
        // LOGIKA WISHILIST (UNTUK STATUS TOMBOL MERAH)
        // ----------------------------------------------------
        $isWishlisted = false;
        
        if (Auth::check()) {
            // Memeriksa apakah user yang sedang login sudah memfavoritkan produk ini
            // Asumsi Model User memiliki relasi wishlists()
            $isWishlisted = Auth::user()->wishlists()->where('product_id', $product->id)->exists();
        }
        
        // Mengirimkan semua data yang diperlukan ke view
        return view('product_detail', compact('product', 'ratingAvg', 'ratingCount', 'isWishlisted')); // <-- $isWishlisted DITAMBAHKAN
    }
}