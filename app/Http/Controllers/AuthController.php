<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

// Controller ini buat ngatur proses login dan register sampe logout
class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm() {
        return view('auth.login');
    }

    // Validasi input login
    public function login(Request $request) {
        // Defensive: Validasi Input
        $credentials = $request->validate([
            'username' => 'required', // Bisa login pakai username
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Authentication login admin & user biasa
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

    // Tampilkan Register form
    public function showRegisterForm() {
        return view('auth.register');
    }

    // function validasi input register 
    public function register(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_depan'    => 'required|string|max:50',
            'nama_belakang' => 'required|string|max:50',
            'username'      => 'required|string|max:50|unique:user', // Pastikan tabelnya 'user'
            'password'      => 'required|min:8',
        ]);

        // Buat menggabungkan nama depan & belakang jadi satu string
        $fullName = $request->nama_depan . ' ' . $request->nama_belakang;

        // Menyimpan user baru ke dalam database
        User::create([
            'nama'     => $fullName,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => 'user', // bakal jadi langsung user biasa kalau jadi admin ubah manual ke phpmyadminnya
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Function buat logout
    public function logout(Request $request) {
        Auth::logout();
        // Menghapus data session pengguna
        $request->session()->invalidate();
        // Mengatur ulang token CSRF untuk keamanan
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}