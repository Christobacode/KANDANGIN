<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KeranjangController; 

// AUTH
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// HALAMAN UMUM
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/layanan', function () { return view('layanan'); })->name('layanan');
Route::get('/tentang', function () { return view('tentang'); })->name('tentang');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// ADMIN (PRODUK)
Route::middleware(['auth', 'is_admin'])->group(function () {
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

// MEMBER AREA (Harus Login)
Route::middleware(['auth'])->group(function () {
    
    // KERANJANG
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'addToCart'])->name('keranjang.add');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'updateQty'])->name('keranjang.update');
    Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

    // ORDER & BAYAR
    Route::get('/riwayat-order', [OrderController::class, 'history'])->name('order.history');
    Route::get('/pembayaran/{id}', [OrderController::class, 'showPayment'])->name('pembayaran.tunggu');
    Route::post('/pembayaran/konfirmasi/{id}', [OrderController::class, 'confirmPayment'])->name('pembayaran.confirm');

    // PROFIL
    Route::get('/profil', [UserController::class, 'index'])->name('profil');
    Route::delete('/profil/hapus', [UserController::class, 'destroy'])->name('profil.destroy');
    Route::get('/profil/ubah-username', [UserController::class, 'editUsername'])->name('profil.username');
    Route::put('/profil/ubah-username', [UserController::class, 'updateUsername'])->name('profil.username.update');
    Route::get('/profil/ganti-sandi', [UserController::class, 'editPassword'])->name('profil.password');
    Route::put('/profil/ubah-password', [UserController::class, 'updatePassword'])->name('profil.password.update');
});