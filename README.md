
# 📘 *Marketplace Management – Laravel E-Commerce*

Aplikasi Marketplace ini dibangun menggunakan Laravel dengan sistem *role-based access: *Admin, Seller, Buyer, dan Public User.
Fitur mencakup *manajemen produk, verifikasi seller, cart & checkout, pengelolaan pesanan, rating & review, serta *pengaturan kategori & toko*.

---

# 🔐 *User Levels*

## *1. Admin*

* Akses penuh sistem
* Verifikasi Seller (Approve / Reject)
* Kelola semua user
* CRUD kategori produk
* Menghapus produk bermasalah

## *2. Seller*

* Register → menunggu approval Admin
* Kelola informasi toko
* CRUD produk sendiri
* Melihat pesanan masuk
* Update status pesanan

## *3. Buyer*

* Add to Cart
* Checkout
* Riwayat pesanan & tracking
* Rating & review produk
* Kelola profil

## *4. Public User (Guest)*

* Lihat daftar produk & detail
* Add to Cart hanya saat login Buyer

---

# 📦 *CMS Modules*

## *1. Product Management (Seller)*

* List produk seller
* Create / Edit / Delete produk
* Validasi lengkap

## *2. User Management (Admin)*

* Melihat semua user
* Verifikasi seller pending
* Edit & delete user

## *3. Cart Management (Buyer)*

* Add to Cart
* View Cart & update quantity
* Remove item
* Checkout → Cart dikosongkan

## *4. Store Management (Seller)*

* Update info toko
* CRUD produk toko

## *5. Order Management*

### Buyer:

* Riwayat pesanan (Menunggu, Diproses, Selesai)
* Rating & review

### Seller:

* Melihat pesanan masuk
* Update status pesanan

## *6. Category Management (Admin)*

* CRUD kategori

---

# 🖥 *Layout Requirements*

## 🔸 *Login / Register*

* Login: Admin, Seller, Buyer
* Register: Buyer & Seller (Seller → Pending)

## 🔸 *Homepage – Public*

* List produk + search
* Add to Cart → redirect login

## 🔸 *Homepage – Buyer*

* Produk rekomendasi acak
* Add to Cart aktif

## 🔸 *Product List Page*

* Katalog lengkap (gambar, nama, harga)

## 🔸 *Product Detail Page*

* Detail lengkap
* Rating & review
* Add to Cart

## 🔸 *Buyer Dashboard*

* Profile
* Shopping Cart
* Order History

## 🔸 *Seller Dashboard*

* Store Management
* Product CRUD
* Order Management

## 🔸 *Pending Seller Page*

* Pesan “Akun Anda sedang ditinjau”
* Jika Rejected → tombol Delete Account

## 🔸 *Admin Dashboard*

* User Management
* Seller Verification
* Category Management

---

# 🚀 *Advanced Features (Optional)*

* Filter & sorting produk
* Wishlist

---

# ⚙ *Instalasi & Setup*

## *1. Clone Repository*


git clone https://github.com/Davidzen111/DavMart.git


## *2. Masuk Folder Project*


cd DavMart


## *3. Install Dependensi Laravel*


composer install


## *4. Setup .env*

Rename .env.example → .env lalu isi database:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=davmart
DB_USERNAME=root
DB_PASSWORD=


## *5. Aktifkan MySQL*

## *6. Migrasi & Seeder*


php artisan migrate --seed


## *7. Jalankan Server*


php artisan serve


## *8. Install Dependencies Frontend*


npm install


## *9. Jalankan Vite*


npm run dev


## *10. Generate Key*


php artisan key:generate


## *11. Storage Link*


php artisan storage:link


---

# 🌐 *Akses Aplikasi*

[http://127.0.0.1:8000/](http://127.0.0.1:8000/)

---

# 🔑 *Akun Default*

### *Admin*

Tersedia di:
database/seeders/AdminSeeder.php

### *Buyer*

Register langsung

### *Seller*

Register → status Pending → menunggu approval Admin

