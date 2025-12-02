<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. DATA PENGGUNA (USER LEVELS)
        // ==========================================

        // A. Admin (Super User)
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active', // Admin selalu aktif
        ]);

        // B. Buyer (Pembeli Normal)
        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'buyer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'active',
        ]);

        // C. Seller 1 (Sudah Disetujui/Approved)
        $sellerApproved = User::create([
            'name' => 'Siti Penjual Sukses',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'approved', // Bisa langsung login & kelola toko
        ]);

        // D. Seller 2 (Masih Menunggu/Pending)
        // Gunakan akun ini untuk mengetes fitur "Seller Verification" di halaman Admin
        User::create([
            'name' => 'Asep Penjual Baru',
            'email' => 'pending@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'pending', // Belum bisa akses dashboard seller sepenuhnya
        ]);

        // ==========================================
        // 2. DATA TOKO (STORE MANAGEMENT)
        // ==========================================

        // Toko untuk Seller yang sudah Approved
        $store = Store::create([
            'user_id' => $sellerApproved->id,
            'name' => 'DavMart Official Store',
            'slug' => 'davmart-official-store',
            'description' => 'Toko resmi penyedia gadget dan fashion termurah dan terpercaya.',
            'image' => null, // Nanti bisa diupdate via fitur Edit Store
        ]);

        // ==========================================
        // 3. DATA KATEGORI (CATEGORY MANAGEMENT)
        // ==========================================
        
        $catElektronik = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);
        $catFashion = Category::create(['name' => 'Fashion', 'slug' => 'fashion']);
        $catBuku = Category::create(['name' => 'Buku', 'slug' => 'buku']);
        $catHobi = Category::create(['name' => 'Hobi & Mainan', 'slug' => 'hobi-mainan']);

        // ==========================================
        // 4. DATA PRODUK (PRODUCT MANAGEMENT)
        // ==========================================

        // Produk 1: Laptop (Elektronik)
        Product::create([
            'store_id' => $store->id,
            'category_id' => $catElektronik->id,
            'name' => 'Laptop Gaming ROG Strix',
            'slug' => 'laptop-gaming-rog-strix',
            'description' => 'Laptop gaming spesifikasi tinggi. RAM 32GB, SSD 1TB, RTX 4060. Cocok untuk render dan gaming berat.',
            'price' => 25000000,
            'stock' => 5,
            'image' => null, 
        ]);

        // Produk 2: Mouse (Elektronik)
        Product::create([
            'store_id' => $store->id,
            'category_id' => $catElektronik->id,
            'name' => 'Mouse Wireless Silent Click',
            'slug' => 'mouse-wireless-silent-click',
            'description' => 'Mouse tanpa kabel dengan fitur silent click, tidak berisik saat digunakan malam hari.',
            'price' => 150000,
            'stock' => 50,
            'image' => null,
        ]);
        
        // Produk 3: Kaos (Fashion)
        Product::create([
            'store_id' => $store->id,
            'category_id' => $catFashion->id,
            'name' => 'Kaos Polos Cotton Combed 30s',
            'slug' => 'kaos-polos-cotton-combed-30s',
            'description' => 'Bahan adem, menyerap keringat, jahitan rantai standar distro.',
            'price' => 45000,
            'stock' => 100,
            'image' => null,
        ]);

        // Produk 4: Novel (Buku)
        Product::create([
            'store_id' => $store->id,
            'category_id' => $catBuku->id,
            'name' => 'Novel Pulang - Tere Liye',
            'slug' => 'novel-pulang-tere-liye',
            'description' => 'Buku original, kondisi segel baru.',
            'price' => 85000,
            'stock' => 20,
            'image' => null,
        ]);
    }
}