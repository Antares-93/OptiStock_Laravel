<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

// 1. Publik / Tamu
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('catalog');
})->name('home');

Route::get('/katalog', [ProductController::class, 'index'])->name('catalog');

// 2. Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. Area Khusus Petugas (Admin & Staff)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Mutasi Stok
    Route::get('/stock/in', [StockController::class, 'createIn'])->name('stock.in');
    Route::post('/stock/in', [StockController::class, 'storeIn']);
    Route::get('/stock/out', [StockController::class, 'createOut'])->name('stock.out');
    Route::post('/stock/out', [StockController::class, 'storeOut']);
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');

   // Khusus Admin
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
    Route::resource('suppliers', SupplierController::class)->only(['index', 'store', 'destroy']);
    Route::resource('users', UserController::class)->only(['index', 'store', 'destroy']);

});