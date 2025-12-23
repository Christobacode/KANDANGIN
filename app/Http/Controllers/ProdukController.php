<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Digunakan untuk menghapus file fisik di storage

// Controller ini fungsinya buat ngatur CRUD produk Mulai dari nampilin barang, nambah, edit, sampe hapus.
class ProdukController extends Controller
{
    // tampilkan produk
    public function index()
    {
        // mengambil data produk & kategori
        $produk = Produk::with('kategori')->get();
        $kategori = Kategori::all();

        // cek role User yang lagi login
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika Admin maka Tampilkan View Khusus Admin
            return view('produk.index_admin', compact('produk', 'kategori'));
        }

        // Jika User Biasa / Tamu maka Tampilkan View Biasa
        return view('produk.index', compact('produk', 'kategori'));
    }
    
    // Nampilin form buat nambah produk baru
    public function create()
    {
        // Pengecekan sesi manual dihapus karena sudah ditangani oleh Middleware IsAdmin di web.php
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    // Simpan produk baru ke database
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'namaproduk'  => 'required|max:100',
            'hargaproduk' => 'required|numeric', 
            'stokproduk'  => 'required|integer',
            'kategoriID'  => 'required|exists:kategori,kategoriID',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:4096', // Maksimal ukuran gambar adalah 4 mb
        ]);

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder 'public/storage/produk-images'
            $path = $request->file('gambar')->store('produk-images', 'public');
            $validated['gambar'] = $path;
        }

        // Simpan ke Database
        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form buat edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }

    // Function update data produk yang udah diedit.
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $validated = $request->validate([
            'namaproduk'  => 'required|max:100',
            'hargaproduk' => 'required|numeric',
            'stokproduk'  => 'required|integer',
            'kategoriID'  => 'required|exists:kategori,kategoriID',
        ]);
        $produk->update($validated);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Function buat hapus produk dari database 
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Menghapus file gambar di storage agar tidak memenuhi kapasitas server
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}