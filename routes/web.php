<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Client;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;


// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/layanan/{slug}', [ServiceController::class, 'show'])->name('services.show');

// ─── Guest Routes ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/masuk', [LoginController::class, 'login']);
    Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register']);

    // Google Socialite Login
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/keluar', [LogoutController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // Cart / Bucket
    Route::get('/bucket', [CartController::class, 'index'])->name('cart.index');
    Route::post('/bucket', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/bucket/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/bucket', [CartController::class, 'clear'])->name('cart.clear');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{service}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/sukses/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Client Dashboard
    Route::prefix('dashboard')->name('client.')->group(function () {
        Route::get('/', [Client\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pesanan', [Client\OrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{id}', [Client\OrderController::class, 'show'])->name('orders.show');
        Route::get('/invoice/{invoice}', [Client\InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/invoice/{invoice}/cetak', [Client\InvoiceController::class, 'print'])->name('invoices.print');
    });
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Services CRUD
    Route::resource('layanan', Admin\ServiceController::class)->names([
        'index' => 'services.index',
        'create' => 'services.create',
        'store' => 'services.store',
        'edit' => 'services.edit',
        'update' => 'services.update',
        'destroy' => 'services.destroy',
    ])->parameters(['layanan' => 'service']);

    // Categories
    Route::get('/kategori', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategori', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/kategori/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders
    Route::get('/pesanan', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');
});
