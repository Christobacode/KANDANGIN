<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController; // Controller baru untuk Profil

// --- JALUR TAMU (Belum Login) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// --- JALUR UMUM (Bisa Diakses Siapa Saja) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/', function () { return view('home'); })->name('home');
Route::get('/layanan', function () { return view('layanan'); })->name('layanan');
Route::get('/tentang', function () { return view('tentang'); })->name('tentang');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

// --- JALUR USER LOGIN (Auth) ---
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Fitur Profil & Akun
    Route::get('/profil', [UserController::class, 'index'])->name('profil');
    Route::get('/profil/ubah-username', [UserController::class, 'editUsername'])->name('profil.username');
    Route::post('/profil/ubah-username', [UserController::class, 'updateUsername'])->name('profil.username.update');
    // Route::get('/profil/ganti-sandi', ... ); // (Tambahkan nanti jika perlu)
});

// --- JALUR KHUSUS ADMIN ---
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin punya akses penuh ke CRUD Produk
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
});

Route::middleware(['auth'])->group(function () {
    // ... route sebelumnya ...

    // Menu Profil
    Route::get('/profil', [UserController::class, 'index'])->name('profil');
    
    // Ganti Username
    Route::get('/profil/ubah-username', [UserController::class, 'editUsername'])->name('profil.username');
    Route::post('/profil/ubah-username', [UserController::class, 'updateUsername'])->name('profil.username.update');

    // Ganti Password (Optional, jika file blade siap)
    Route::get('/profil/ganti-sandi', [UserController::class, 'editPassword'])->name('profil.password');
    // Route::post('/profil/ganti-sandi', ...)->name('profil.password.update');

    // Hapus Akun
    Route::delete('/profil/hapus', [UserController::class, 'destroy'])->name('profil.destroy');
});