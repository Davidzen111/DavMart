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
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Buat Akun BUYER
        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'buyer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'active',
        ]);

        // 3. Buat Akun SELLER 1 (Sudah Approved)
        $seller = User::create([
            'name' => 'Siti Penjual',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'approved',
        ]);

        // Buat Toko untuk Seller 1 (Wajib ada karena dia Seller)
        $store = Store::create([
            'user_id' => $seller->id,
            'name' => 'Toko Elektronik Murah',
            'slug' => 'toko-elektronik-murah',
            'description' => 'Menjual berbagai alat elektronik termurah.',
            'image' => null,
        ]);

        // 4. Buat Akun SELLER 2 (Masih Pending - Untuk Demo Admin Approval)
        User::create([
            'name' => 'Penjual Baru Daftar',
            'email' => 'pending@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'pending', 
        ]);

        // 5. Buat Kategori
        $cat1 = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);
        $cat2 = Category::create(['name' => 'Fashion', 'slug' => 'fashion']);
        $cat3 = Category::create(['name' => 'Buku', 'slug' => 'buku']);

        // 6. Buat Dummy Produk untuk Toko Seller 1
        Product::create([
            'store_id' => $store->id,
            'category_id' => $cat1->id,
            'name' => 'Laptop Gaming Asus',
            'slug' => 'laptop-gaming-asus',
            'description' => 'Laptop spek dewa harga mahasiswa. RAM 16GB, SSD 512GB.',
            'price' => 15000000,
            'stock' => 10,
            'image' => null, 
        ]);

        Product::create([
            'store_id' => $store->id,
            'category_id' => $cat1->id,
            'name' => 'Mouse Wireless Logitech',
            'slug' => 'mouse-wireless-logitech',
            'description' => 'Mouse anti delay, baterai awet 1 tahun.',
            'price' => 150000,
            'stock' => 50,
            'image' => null,
        ]);
        
        Product::create([
            'store_id' => $store->id,
            'category_id' => $cat2->id,
            'name' => 'Kaos Polos Hitam',
            'slug' => 'kaos-polos-hitam',
            'description' => 'Bahan cotton combed 30s adem.',
            'price' => 50000,
            'stock' => 100,
            'image' => null,
        ]);
    }
}