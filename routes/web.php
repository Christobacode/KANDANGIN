<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController; // Jangan lupa import ini

// --- AUTHENTICATION ---
// Hapus middleware 'guest', biarkan terbuka
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- HALAMAN PUBLIK ---
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/layanan', function () { return view('layanan'); })->name('layanan');
Route::get('/tentang', function () { return view('tentang'); })->name('tentang');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// --- FITUR PRODUK (CRUD) ---
// Dulunya dibungkus middleware ['auth', 'admin']. Sekarang terbuka bebas.
// Siapa saja bisa tambah/edit/hapus produk cukup dengan ketik URL.
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// --- FITUR USER & PROFIL ---
// Dulunya dibungkus middleware ['auth'].
Route::get('/profil', [UserController::class, 'index'])->name('profil');
Route::get('/profil/ubah-username', [UserController::class, 'editUsername'])->name('profil.username');
Route::post('/profil/ubah-username', [UserController::class, 'updateUsername'])->name('profil.username.update');
Route::delete('/profil/hapus', [UserController::class, 'destroy'])->name('profil.destroy');

// --- ORDER ---
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/riwayat-order', [OrderController::class, 'history'])->name('order.history');