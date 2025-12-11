<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

// PENTING: Class ini sekarang mewarisi fitur dari 'Controller' induk
class ProdukController extends Controller
{
    // 1. TAMPILKAN SEMUA PRODUK
    public function index()
    {
        // Mengambil data produk beserta kategorinya (biar hemat query)
        $produk = Produk::with('kategori')->get();
        
        // Kirim data ke view index
        return view('produk.index', compact('produk'));
    }

    // 2. FORM TAMBAH PRODUK
    public function create()
    {
        // Ambil data kategori untuk isi dropdown
        $kategori = Kategori::all();
        
        return view('produk.create', compact('kategori'));
    }

    // 3. SIMPAN DATA PRODUK BARU
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'namaproduk'  => 'required|max:100',
            'hargaproduk' => 'required|numeric', // numeric biar bisa angka besar
            'stokproduk'  => 'required|integer',
            'kategoriID'  => 'required|exists:kategori,kategoriID',
        ]);

        // Simpan ke database
        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. FORM EDIT PRODUK
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        
        return view('produk.edit', compact('produk', 'kategori'));
    }

    // 5. UPDATE DATA PRODUK
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

    // 6. HAPUS PRODUK
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}