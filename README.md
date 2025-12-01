Manajemen Marketplace – Laravel E-Commerce

Aplikasi Marketplace ini dikembangkan menggunakan Laravel untuk mengelola produk, pengguna, dan transaksi jual-beli dengan sistem role-based access (Admin, Seller, Buyer, dan Public User). Fitur mencakup manajemen produk, verifikasi seller, keranjang belanja, pemrosesan pesanan, rating dan review, serta pengelolaan toko dan kategori.

User Levels
1. Admin

Memiliki akses penuh ke seluruh platform.

Memverifikasi dan mengelola akun Seller (Approve / Reject).

Mengelola data pengguna (Buyer & Seller).

Menghapus produk yang melanggar ketentuan.

Mengelola kategori produk.

2. Seller

Mendaftar sebagai Seller dan menunggu approval dari Admin.

Mengelola informasi toko (nama, deskripsi, gambar).

CRUD produk sendiri: tambah, edit, hapus, kelola stok, pilih kategori.

Melihat daftar pesanan yang masuk dan memperbarui status pesanan.

3. Buyer

Menambahkan produk ke keranjang belanja.

Mengelola isi keranjang (update jumlah, delete item).

Checkout untuk membuat order (tanpa payment gateway).

Melihat riwayat pesanan & tracking status.

Memberikan rating dan review untuk produk.

Mengelola profil akun.

4. Public User (Guest)

Melihat list produk dan detail produk.

Harus login sebagai Buyer untuk add to cart atau berbelanja.

CMS Modules (Content Management System)
1. Product Management (Seller)

List Products: Menampilkan seluruh produk yang ditambahkan Seller.

Create Product:

Field: nama, deskripsi, harga, stok, gambar, kategori.

Validasi ketat untuk semua field.

Edit Product: Mengubah nama, deskripsi, harga, stok, gambar, kategori.

Delete Product: Hanya dapat menghapus produk miliknya.

2. User Management (Admin)

View User: Melihat daftar Admin dan Seller.

Seller Verification:

Melihat Seller berstatus “Pending”.

Approve atau Reject Seller.

Edit User: Mengubah data akun.

Delete User: Tidak dapat menghapus dirinya sendiri.

3. Cart Management (Buyer)

Add to Cart.

View Cart (detail, jumlah, total harga).

Update quantity atau remove item.

Checkout → membuat Order baru.

Cart otomatis dikosongkan setelah checkout.

4. Store Management (Seller)

Update informasi toko.

CRUD produk.

5. Order Management (Core Module)
Buyer:

Order History: Melihat seluruh pesanan & statusnya (Menunggu Pembayaran, Diproses, Selesai).

Rating & Review: Hanya setelah pesanan selesai.

Seller:

Incoming Orders: Pesanan yang masuk ke toko Seller.

Update Order Status: Contoh: Menunggu Pembayaran → Diproses atau Dikirim → Selesai.

6. Category Management (Admin)

CRUD kategori produk.

Kategori digunakan Seller saat menambah produk.

Layout Requirements (Front-End Flow)
1. Login/Register Page

Login untuk Admin, Seller, Buyer.

Register untuk Buyer & Seller (Seller baru = status Pending).

2. Homepage – Public User

Menampilkan daftar produk.

Search bar.

Tombol Add to Cart → redirect ke login jika belum login.

3. Homepage – Buyer

Menampilkan produk rekomendasi acak.

Add to Cart aktif.

Search bar.

4. Product List Page

Menampilkan katalog lengkap: gambar, nama, harga.

5. Product Detail Page

Menampilkan detail lengkap: nama, harga, deskripsi, kategori, dan toko.

Add to Cart (Buyer).

Rating & review.

Guest hanya bisa lihat, tidak bisa add to cart.

6. Buyer Dashboard

Profile Management

Shopping Cart

Order History & Tracking

7. Seller Dashboard

Store Management

Product CRUD

Incoming Orders + Update Status

8. Pending Seller Page

Teks: “Akun Anda sedang ditinjau”.

Jika status “Rejected” → muncul tombol Delete Account.

9. Admin Dashboard

User Management

Seller Verification

Category Management

Advanced Requirements (Optional / Upgrade)

Filter dan Sorting Produk (kategori, harga, terbaru).

Alamat Pengiriman Buyer

Wishlist System
Buyer dapat menyimpan produk ke daftar favorit.

Teknologi yang Digunakan

XAMPP – Apache, PHP, MySQL

Composer – Dependency Laravel

Laravel – Backend utama

VS Code – Code editor

GitHub – Version control & repo management

Node.js & NPM – Mengelola frontend via Vite

Installation Guide
1. Clone Repository
git clone https://github.com/Mirnafebriasari/Manajemen-Perpustakaan.git

2. Masuk Direktori Project
cd Manajemen-Perpustakaan

3. Install Dependensi Laravel
composer install

4. Konfigurasi File .env

Jika belum ada, ubah .env.example menjadi .env.

Lalu isi:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_db
DB_USERNAME=root
DB_PASSWORD=

5. Start MySQL di XAMPP
6. Migrasi dan Seeder Database
php artisan migrate --seed

7. Jalankan Server Laravel
php artisan serve

8. Install Dependencies Frontend
npm install

9. Jalankan Vite
npm run dev

10. Generate App Key
php artisan key:generate

11. Buat Storage Link
php artisan storage:link

Akses Aplikasi:

http://127.0.0.1:8000/

Akses Akun
1. Admin

Tersedia melalui file:

database/seeders/AdminSeeder.php

2. Buyer

Dapat registrasi langsung melalui halaman Register.

3. Seller

Register → status Pending → menunggu approval Admin.
