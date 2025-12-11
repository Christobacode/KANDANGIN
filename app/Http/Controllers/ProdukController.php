<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController 
{
    // Tampilkan semua produk
    public function index()
    {
        // Eager loading kategori untuk performa (N+1 problem)
        $produk = Produk::with('kategori')->get();
        return view('produk.index', compact('produk'));
    }

    // Form tambah produk
    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori')); // ngambil data kategori dari kategori model
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaproduk' => 'required|max:100',
            'hargaproduk' => 'required|integer',
            'stokproduk' => 'required|integer',
            'kategoriID' => 'required|exists:kategori,kategoriID',
        ]);

        Produk::create($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'namaproduk' => 'required|max:100',
            'hargaproduk' => 'required|integer',
            'stokproduk' => 'required|integer',
            'kategoriID' => 'required|exists:kategori,kategoriID',
        ]);

        $produk->update($validated);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}