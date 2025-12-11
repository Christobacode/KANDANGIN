<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN PUBLIK (Bisa diakses tanpa login) 

// Halaman Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Home (Alternatif jika ada link ke /home)
Route::get('/home', function () {
    return redirect()->route('home');
});

// Halaman Layanan (Statis)
Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

// Halaman Tentang (Statis)
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Halaman Produk (Index) - Menampilkan daftar produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');


// 2. AUTHENTICATION (Login, Register, Logout) 

// Halaman Login & Proses Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Halaman Register & Proses Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// 3. ROUTES YANG BUTUH LOGIN (Customer & Admin) 
Route::middleware(['auth'])->group(function () {
    
    // Proses Beli Produk (Checkout)
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    
    // Halaman Riwayat Order
    Route::get('/riwayat-order', [OrderController::class, 'history'])->name('order.history');

    // (Opsional) Halaman Keranjang / Cart
    // Karena logic cart belum dibuat di controller, kita arahkan ke view sementara atau history
    Route::get('/keranjang', function() {
        return view('order.cart'); // Pastikan buat file view: resources/views/order/cart.blade.php
    })->name('cart');
});


// 4. ROUTES KHUSUS ADMIN (Kelola Produk)
// Kita tambahkan pengecekan role sederhana di dalam controller atau middleware
Route::middleware(['auth'])->group(function () {
    
    // Form Tambah Produk
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    
    // Simpan Produk Baru
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    
    // Form Edit Produk
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    
    // Update Produk
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    
    // Hapus Produk
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});