<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Tampilkan Login
    public function showLoginForm() {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request) {
        // Defensive: Validasi Input
        $credentials = $request->validate([
            'username' => 'required', // Bisa login pakai username
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // LOGIKA PEMISAH ADMIN & USER
            if (Auth::user()->role === 'admin') {
                $request->session()->put('admin_id', Auth::user()->userID);
                return redirect()->route('produk.index')->with('success', 'Selamat Datang Admin!');
            }

            return redirect()->route('home')->with('success', 'Login Berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Tampilkan Register
    public function showRegisterForm() {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_depan'    => 'required|string|max:50',
            'nama_belakang' => 'required|string|max:50',
            'username'      => 'required|string|max:50|unique:user', // Pastikan tabelnya 'user'
            'password'      => 'required|min:8',
        ]);

        // 2. LOGIKA PENYIMPANAN YANG HILANG (Tambahkan Ini!)
        // Gabungkan nama depan & belakang
        $fullName = $request->nama_depan . ' ' . $request->nama_belakang;

        User::create([
            'nama'     => $fullName,
            'username' => $request->username,
            // Buat email dummy karena di tabel butuh email tapi form gak ada
            'email'    => $request->username . '@example.com', 
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => 'user', // Set otomatis jadi user biasa
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}