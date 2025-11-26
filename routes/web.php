<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Buyer\BuyerController;
use Illuminate\Support\Facades\Route;

// Halaman Depan (Public)
use App\Http\Controllers\HomeController; // <--- Jangan lupa import ini di paling atas file!

// Halaman Depan (Public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Grouping Route berdasarkan Role
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. BUYER ROUTES
    Route::middleware('role:buyer')->group(function () {
        Route::get('/dashboard', [BuyerController::class, 'index'])->name('dashboard');
        // Nanti tambah route cart, checkout disini
        // Keranjang (Cart)
        Route::get('/cart', [\App\Http\Controllers\Buyer\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [\App\Http\Controllers\Buyer\CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/{id}', [\App\Http\Controllers\Buyer\CartController::class, 'destroy'])->name('cart.destroy');

        // Checkout & Order
        Route::post('/checkout', [\App\Http\Controllers\Buyer\OrderController::class, 'checkout'])->name('checkout');
        Route::get('/orders', [\App\Http\Controllers\Buyer\OrderController::class, 'index'])->name('orders.index');
    });

    // 2. SELLER ROUTES
    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
        Route::resource('products', \App\Http\Controllers\Seller\ProductController::class);
        // Halaman Pending & Rejected (Di luar dashboard tapi masih role seller)
        Route::get('/pending', [SellerController::class, 'pending'])->name('pending')->withoutMiddleware('role:seller');
        Route::get('/rejected', [SellerController::class, 'rejected'])->name('rejected')->withoutMiddleware('role:seller');
        
        // Nanti tambah route produk management disini (ProductController)
    });

    // 3. ADMIN ROUTES
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        
        // Fitur Verifikasi Seller
        Route::get('/seller-verification', [AdminController::class, 'sellerVerification'])->name('seller.verification');
        Route::patch('/seller-verification/{id}', [AdminController::class, 'approveSeller'])->name('seller.approve');

        // Fitur Category Management (SUDAH BENAR DISINI) ✅
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';