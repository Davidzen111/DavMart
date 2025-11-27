<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // 1. Tampilkan Produk (Hanya milik toko si login)
    public function index()
    {
        $storeId = Auth::user()->store->id;
        $products = Product::where('store_id', $storeId)->latest()->get();
        
        return view('seller.products.index', compact('products'));
    }

    // 2. Form Tambah Produk
    public function create()
    {
        $categories = Category::all(); // Butuh kategori buat dropdown
        return view('seller.products.create', compact('categories'));
    }

    // 3. Simpan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'store_id' => Auth::user()->store->id, // Otomatis masuk ke toko si login
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // ✅ LOGIKA REDIRECT BARU (INI YANG DIUBAH) ✅
        // Cek titipan sinyal 'source' dari form
        if ($request->has('source') && $request->source == 'dashboard') {
            return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan!');
        }

        // Default: Kembali ke List Produk
        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. Form Edit
    public function edit($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);
        $categories = Category::all();
        
        return view('seller.products.edit', compact('product', 'categories'));
    }

    // 5. Update Database
    public function update(Request $request, $id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. Hapus Produk
    public function destroy($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Produk dihapus!');
    }
}