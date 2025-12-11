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
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'username' => 'required|unique:user|max:100',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,customer', // Berdasarkan role yang ada
        ]);

        // Hash password sebelum simpan
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
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