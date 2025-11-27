<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Buyer\ReviewController;
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

// 2. Detail Produk (PENTING: Ini yang tadi error "Route not defined")
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.detail');


// --- BAGIAN PRIVATE (Harus Login) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // ==========================================
    // 1. BUYER ROUTES (Pembeli)
    // ==========================================
    Route::middleware('role:buyer')->group(function () {
        Route::get('/dashboard', [BuyerController::class, 'index'])->name('dashboard');
        
        // Fitur Keranjang (Cart)
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Fitur Checkout & Order
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

        // Fitur Rating & Review
        Route::get('/reviews/create/{productId}/{orderId}', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

        Route::post('/wishlist/{productId}', [\App\Http\Controllers\Buyer\WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // Halaman Wishlist
            Route::get('/wishlist', [\App\Http\Controllers\Buyer\WishlistController::class, 'index'])->name('wishlist.index');
            // Toggle (Love) - Yang sudah ada
            Route::post('/wishlist/{productId}', [\App\Http\Controllers\Buyer\WishlistController::class, 'toggle'])->name('wishlist.toggle');
            });

    // ==========================================
    // 2. SELLER ROUTES (Penjual)
    // ==========================================
    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
        
        // Halaman Pending & Rejected (Tanpa Middleware Role biar gak loop)
        Route::get('/pending', [SellerController::class, 'pending'])->name('pending')->withoutMiddleware('role:seller');
        Route::get('/rejected', [SellerController::class, 'rejected'])->name('rejected')->withoutMiddleware('role:seller');
        Route::delete('/account-destroy', [SellerController::class, 'destroy'])->name('account.destroy')->withoutMiddleware('role:seller');

        // Manajemen Produk (CRUD)
        Route::resource('products', \App\Http\Controllers\Seller\ProductController::class);
        
        // Manajemen Pesanan Masuk
        Route::get('/orders', [\App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{id}', [\App\Http\Controllers\Seller\OrderController::class, 'updateStatus'])->name('orders.update');
        Route::get('/store/settings', [\App\Http\Controllers\Seller\SellerController::class, 'editStore'])->name('store.edit');
        Route::patch('/store/settings', [\App\Http\Controllers\Seller\SellerController::class, 'updateStore'])->name('store.update');
    });

    // ==========================================
    // 3. ADMIN ROUTES (Administrator)
    // ==========================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');


        // Verifikasi Seller
        Route::get('/seller-verification', [AdminController::class, 'sellerVerification'])->name('seller.verification');
        Route::patch('/seller-verification/{id}', [AdminController::class, 'approveSeller'])->name('seller.approve');

        // Manajemen Kategori
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // Admin Product Management (Untuk Hapus Produk Nakal)
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
        });

    // ==========================================
    // PROFILE ROUTES (Bawaan Breeze)
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';