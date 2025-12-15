<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Halaman Profil Utama
    public function index() {
        return view('profil.index');
    }

    // Halaman Ganti Password (Placeholder, jika file blade-nya sudah ada)
    public function editPassword() {
        return view('profil.ganti-sandi'); // Pastikan buat file view ini nanti
    }

    // Halaman Ubah Username (Sesuai kode sebelumnya)
    public function editUsername() {
        return view('profil.ubah-username');
    }
    
    // Proses Ubah Username
    public function updateUsername(Request $request) {
        $request->validate([
            'new_username' => 'required|string|max:50|unique:users,username,' . Auth::id(),
        ]);

        $user = User::find(Auth::id());
        $user->username = $request->new_username;
        $user->save();

        return redirect()->route('profil')->with('success', 'Username berhasil diperbarui!');
    }

    // Proses Hapus Akun (Defensive: Wajib Auth & Method Delete)
    public function destroy() {
        $user = User::find(Auth::id());
        
        // Hapus user
        $user->delete();
        
        // Logout otomatis
        Auth::logout();
        
        return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus.');
    }
}