<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\ReviewController;
use App\Http\Controllers\Buyer\WishlistController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ROUTE PUBLIK (Dapat diakses tanpa login)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');

// ROUTE PRIVATE (Membutuhkan otentikasi)
Route::middleware(['auth', 'verified'])->group(function () {

    // ROUTE BUYER (Pembeli)
    Route::middleware('role:buyer')->group(function () {
        Route::get('buyer/dashboard', [BuyerController::class, 'index'])->name('dashboard'); 
        
        // Keranjang (Cart)
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::patch('/cart/update/{item_id}', [CartController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Checkout dan Pemesanan
        Route::get('/checkout', [OrderController::class, 'showCheckoutPage'])->name('checkout');
        Route::post('/checkout/process', [OrderController::class, 'checkout'])->name('checkout.process');
        
        // Manajemen Pesanan
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

        // Review dan Penilaian
        Route::get('/reviews/create/{productId}/{orderId}', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

        // Daftar Keinginan (Wishlist)
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    });

    // ROUTE SELLER (PENJUAL)
    
    // Route Khusus untuk Seller yang statusnya Pending/Rejected (Aman)
    Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/pending', [SellerController::class, 'pending'])->name('pending');
        Route::get('/rejected', [SellerController::class, 'rejected'])->name('rejected');
        Route::delete('/account-destroy', [SellerController::class, 'destroy'])->name('account.destroy');
        
        // Edit Profil Seller (untuk semua status seller)
        Route::get('/profile/edit', [ProfileController::class, 'editSeller'])->name('profile.edit'); 
    });

    // Route untuk Seller yang sudah APPROVED
    Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
        
        // Manajemen Produk (CRUD)
        Route::resource('products', \App\Http\Controllers\Seller\ProductController::class);
        
        // Manajemen Pesanan
        Route::get('/orders', [\App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{id}', [\App\Http\Controllers\Seller\OrderController::class, 'updateStatus'])->name('orders.update');
        
        // Pengaturan Toko
        Route::get('/store/settings', [SellerController::class, 'editStore'])->name('store.edit');
        Route::patch('/store/settings', [SellerController::class, 'updateStore'])->name('store.update');

    });

    // ROUTE ADMIN (Administrator) 
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Manajemen Pengguna
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Verifikasi Seller
        Route::get('/seller-verification', [AdminController::class, 'sellerVerification'])->name('seller.verification');
        Route::patch('/seller-verification/{id}', [AdminController::class, 'approveSeller'])->name('seller.approve');

        // Manajemen Kategori
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // Monitoring Produk
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
        
        // Edit Profil Admin
        Route::get('/profile/edit', [ProfileController::class, 'editAdmin'])->name('profile.edit'); 
    });

    // --- ROUTE PROFIL UMUM (Digunakan oleh Buyer/Fallback) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';