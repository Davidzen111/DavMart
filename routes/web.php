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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- BAGIAN PUBLIC (Bisa diakses siapa saja tanpa login) ---

// 1. Halaman Depan (Homepage)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Detail Produk
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');


// --- BAGIAN PRIVATE (Harus Login) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // ==========================================
    // 1. BUYER ROUTES (Pembeli)
    // ==========================================
    Route::middleware('role:buyer')->group(function () {
        Route::get('buyer/dashboard', [BuyerController::class, 'index'])->name('dashboard'); // Default Buyer Dashboard
        
        // Fitur Keranjang (Cart)
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        
        // Update Kuantitas & Hapus
        Route::patch('/cart/update/{item_id}', [CartController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

        // --- FITUR CHECKOUT & ORDER ---
        // 1. Menampilkan Halaman Checkout (GET)
        Route::get('/checkout', [OrderController::class, 'showCheckoutPage'])->name('checkout');

        // 2. Memproses Pesanan (POST)
        Route::post('/checkout/process', [OrderController::class, 'checkout'])->name('checkout.process');
        
        // 3. Manajemen Order Buyer
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        
        // Route untuk membatalkan pesanan
        Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

        // Fitur Rating & Review
        Route::get('/reviews/create/{productId}/{orderId}', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

        // Fitur Wishlist (Love) - SUDAH TERSEDIA
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    });

    // ==========================================
    // 2. SELLER ROUTES (Penjual)
    // ==========================================
    
    // GROUP 1: Route AMAN (Halaman Pending & Rejected)
    Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/pending', [SellerController::class, 'pending'])->name('pending');
        Route::get('/rejected', [SellerController::class, 'rejected'])->name('rejected');
        Route::delete('/account-destroy', [SellerController::class, 'destroy'])->name('account.destroy');
        
        // TAMBAHAN: Route Edit Profil untuk Seller
        Route::get('/profile/edit', [ProfileController::class, 'editSeller'])->name('profile.edit'); 
    });

    // GROUP 2: HANYA UNTUK SELLER YANG SUDAH 'APPROVED' & 'ACTIVE'
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

    // ==========================================
    // 3. ADMIN ROUTES (Administrator)
    // ==========================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Verifikasi Seller
        Route::get('/seller-verification', [AdminController::class, 'sellerVerification'])->name('seller.verification');
        Route::patch('/seller-verification/{id}', [AdminController::class, 'approveSeller'])->name('seller.approve');

        // Manajemen Kategori
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // Admin Product Management
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
        
        // TAMBAHAN: Route Edit Profil untuk Admin
        Route::get('/profile/edit', [ProfileController::class, 'editAdmin'])->name('profile.edit'); 
    });

    // ==========================================
    // PROFILE ROUTES (Bawaan Breeze/Umum)
    // ==========================================
    // *Route ini tetap ada untuk Buyer dan sebagai fallback/handler form
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';