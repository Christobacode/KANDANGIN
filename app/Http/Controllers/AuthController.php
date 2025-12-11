<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Karena kita menggunakan custom table & primary key, 
        // pastikan model User sudah benar setup-nya.
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role (contoh sederhana)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('dashboard');
            }
            return redirect()->intended('home');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Menampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
    // 1. Validasi Input (Hanya nama, email, password)
    $validated = $request->validate([
        'nama' => 'required|max:100',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        // JANGAN validasi 'role' di sini, agar user tidak bisa memanipulasi
    ]);

    // 2. Simpan User Baru
    \App\Models\User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Enkripsi password
        'role' => 'user', // <--- INI KUNCINYA! Paksa jadi 'user' biasa
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}