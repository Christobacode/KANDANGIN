<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('profil.index');
    }

    // ubah username 
    
    // Tampilkan Form (Sesuai nama file Anda: ubahusername.blade.php)
    public function editUsername()
    {
       
        return view('profil.ubahusername'); 
    }

    // Proses Update Username
    public function updateUsername(Request $request)
    {
        $request->validate([
            // Username harus unik, kecuali milik user itu sendiri
            'username' => 'required|string|max:255|unique:user,username,' . Auth::id() . ',userID',
        ]);

        $user = User::find(Auth::id());
        $user->username = $request->username;
        $user->save();

        return redirect()->route('profil')->with('success', 'Username berhasil diperbarui!');
    }

    // ubah password

    // Tampilkan Form 
    public function editPassword()
    {
       
        return view('profil.ubahpassword');
    }

    // Proses Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:5|confirmed', // confirmed cek input 'new_password_confirmation'
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Kata sandi lama salah!');
        }

        // Simpan password baru
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profil')->with('success', 'Kata sandi berhasil diubah!');
    }

    public function destroy()
    {
        $user = User::find(Auth::id());
        Auth::logout();
        $user->delete();
        return redirect()->route('home')->with('success', 'Akun berhasil dihapus.');
    }
}