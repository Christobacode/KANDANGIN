<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class ProdukController extends Controller
{
    // 1. TAMPILKAN PRODUK (LOGIKA PEMISAH)
    public function index()
    {
        // Ambil data produk & kategori
        $produk = Produk::with('kategori')->get();
        $kategori = Kategori::all();

        // Cek Role User
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika Admin -> Tampilkan View Khusus Admin
            return view('produk.index_admin', compact('produk', 'kategori'));
        }

        // Jika User Biasa / Tamu -> Tampilkan View Biasa
        return view('produk.index', compact('produk', 'kategori'));
    }

    // ... (Function create, store, edit, update, destroy biarkan TETAP SAMA seperti sebelumnya) ...
    
    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'namaproduk'  => 'required|max:100',
            'hargaproduk' => 'required|numeric', 
            'stokproduk'  => 'required|integer',
            'kategoriID'  => 'required|exists:kategori,kategoriID',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Gambar
        ]);

        // 2. Cek apakah ada file gambar yang diupload
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder 'public/storage/produk-images'
            // Hasilnya path seperti: "produk-images/namafileacak.jpg"
            $path = $request->file('gambar')->store('produk-images', 'public');
            $validated['gambar'] = $path;
        }

        // 3. Simpan ke Database
        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }

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

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}

