<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk beserta info tokonya
        $products = Product::with('store')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus oleh Admin (Pelanggaran).');
    }
}