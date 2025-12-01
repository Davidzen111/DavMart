Marketplace Management – Laravel E-Commerce

Aplikasi Marketplace ini dibangun menggunakan Laravel dengan sistem role-based access: Admin, Seller, Buyer, dan Public User. Fitur mencakup manajemen produk, verifikasi seller, cart & checkout, pengelolaan pesanan, rating & review, serta pengaturan kategori dan toko.

🔐 User Levels
1. Admin

Akses penuh terhadap seluruh sistem.

Verifikasi Seller (Approve / Reject).

Kelola pengguna (Buyer & Seller).

CRUD kategori produk.

Menghapus produk yang melanggar ketentuan.

2. Seller

Register → menunggu approval Admin.

Mengelola informasi toko (nama, deskripsi, gambar).

CRUD produk sendiri (nama, harga, stok, kategori, gambar).

Melihat pesanan yang masuk.

Mengubah status order.

3. Buyer

Add to Cart dan mengelola isi cart.

Checkout (membuat order baru).

Melihat order history & tracking status.

Memberikan rating & review produk.

Mengelola profil akun.

4. Public User (Guest)

Melihat daftar produk & detail produk.

Harus login sebagai Buyer untuk Add to Cart.

📦 CMS Modules
1. Product Management (Seller)

List semua produk Seller.

Create Product (validasi lengkap).

Edit Product (nama, deskripsi, harga, stok, kategori, gambar).

Delete hanya produk miliknya sendiri.

2. User Management (Admin)

Melihat data semua pengguna.

Verifikasi Seller berstatus Pending.

Edit informasi pengguna.

Delete user (kecuali dirinya sendiri).

3. Cart Management (Buyer)

Add to Cart.

View Cart (jumlah, total harga).

Update quantity atau remove item.

Checkout → Order dibuat & Cart dikosongkan.

4. Store Management (Seller)

Update informasi toko.

CRUD produk miliknya.

5. Order Management
Buyer

Melihat riwayat pesanan (Menunggu Pembayaran, Diproses, Selesai).

Memberikan rating & review setelah pesanan selesai.

Seller

Melihat pesanan masuk ke toko.

Update status pesanan.

6. Category Management (Admin)

CRUD kategori produk.

🖥️ Layout Requirements
🔸 Login/Register

Login: Admin, Seller, Buyer.

Register: Buyer & Seller (Seller → Pending).

🔸 Homepage – Public User

List produk + search bar.

Add to Cart → redirect ke login.

🔸 Homepage – Buyer

Produk rekomendasi acak.

Add to Cart aktif.

🔸 Product List Page

Katalog produk (gambar, nama, harga).

🔸 Product Detail Page

Detail produk lengkap (nama, harga, deskripsi, kategori, toko).

Rating & review.

Add to Cart (Buyer).

🔸 Buyer Dashboard

Profile Management.

Shopping Cart.

Order History & Tracking.

🔸 Seller Dashboard

Store Management.

Product CRUD.

Order Management.

🔸 Pending Seller Page

Pesan: “Akun Anda sedang ditinjau.”

Jika Rejected → tombol Delete Account muncul.

🔸 Admin Dashboard

User Management.

Seller Verification.

Category Management.

🚀 Advanced Features (Optional Upgrades)

Filter & sorting produk (kategori, harga).

Manajemen alamat pengiriman Buyer.

Wishlist / Favorite System.

⚙️ Instalasi & Setup
1. Clone Repository
git clone https://github.com/Mirnafebriasari/Manajemen-Perpustakaan.git

2. Masuk Folder Project
cd Manajemen-Perpustakaan

3. Install Dependensi Laravel
composer install

4. Setup File .env

Jika hanya ada .env.example, rename jadi .env.

Isi konfigurasi database:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_db
DB_USERNAME=root
DB_PASSWORD=

5. Aktifkan MySQL di XAMPP
6. Migrasi & Seeder
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

Akses Aplikasi

http://127.0.0.1:8000/

🔑 Akses Akun
Admin

Cek file:

database/seeders/AdminSeeder.php

Buyer

Daftar langsung melalui halaman register.

Seller

Register → status Pending → menunggu approval Admin.
