<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Order;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    // ==========================================================
    // 1. TAMPILKAN HALAMAN KERANJANG
    // ==========================================================
    public function index()
    {
        $userID = Auth::id();
        
        // Ambil data keranjang user beserta info produknya
        $carts = Keranjang::with('produk')->where('userID', $userID)->get();

        // PERBAIKAN: Gunakan ?-> untuk mencegah crash jika produk null saat menghitung total
        $totalBayar = $carts->sum(function($item) {
            return ($item->produk?->hargaproduk ?? 0) * $item->qty;
        });

        return view('keranjang', compact('carts', 'totalBayar'));
    }

    // ==========================================================
    // 2. TAMBAH BARANG KE KERANJANG (Tombol Beli)
    // ==========================================================
    public function addToCart($produkID)
    {
        $userID = Auth::id();

        // 1. Ambil data produk berdasarkan $produkID agar variabel $produk terdefinisi
        // Gunakan findOrFail agar otomatis error 404 jika ID produk tidak ditemukan
        $produk = Produk::findOrFail($produkID); 

        // 2. Sekarang variabel $produk sudah bisa digunakan untuk cek stok
        if ($produk->stokproduk < 1) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sudah habis!');
        }

        // Cek apakah barang sudah ada di keranjang
        $cekItem = \App\Models\Keranjang::where('userID', $userID)
                            ->where('produkID', $produkID)
                            ->first();

        if ($cekItem) {
            // Jika sudah ada, tambah jumlahnya (+1)
            $cekItem->increment('qty');
        } else {
            // Jika belum ada, buat data baru
            \App\Models\Keranjang::create([
                'userID'   => $userID,
                'produkID' => $produkID,
                'qty'      => 1
            ]);
        }

        // 3. Kurangi stok produk
        $produk->decrement('stokproduk');

        return redirect()->route('keranjang.index')->with('success', 'Berhasil masuk keranjang!');
    }

    // ==========================================================
    // 3. UPDATE JUMLAH (Tombol + dan - di Keranjang)
    // ==========================================================
    public function updateQty(Request $request, $keranjangID)
    {
        // Cari data keranjang beserta info produknya
        $cart = \App\Models\Keranjang::with('produk')->where('keranjangID', $keranjangID)->firstOrFail();
        $produk = $cart->produk; // Ambil data produk terkait

        if($request->type == 'plus') {
            // Cek apakah stok masih ada sebelum menambah
            // Validasi Stok: Cek apakah masih bisa ditambah
            if (!$produk || $produk->stokproduk < 1) {
                return redirect()->back()->with('error', 'Gagal menambah jumlah! Stok sudah habis.');
            }
            
            $cart->increment('qty');
            $produk->decrement('stokproduk'); // Kurangi stok karena barang di keranjang bertambah
        } 
        elseif($request->type == 'minus') {
            if($cart->qty > 1) {
                $cart->decrement('qty');
            } else {
                $cart->delete();
            }
            
            // TAMBAHKAN INI: Kembalikan stok produk karena jumlah di keranjang berkurang/dihapus
            $produk->increment('stokproduk');
        }
        
        return redirect()->back();
    }

    // ==========================================================
    // 4. CHECKOUT (Proses Beli -> Pindah ke Order)
    // ==========================================================
    public function checkout()
    {
        // Pakai DB Transaction biar aman (Kalau error di tengah, batal semua)
        DB::beginTransaction();
        
        try {
            $userID = Auth::id();
            
            // Ambil semua isi keranjang user
            $carts = Keranjang::with('produk')->where('userID', $userID)->get();

            // Jaga-jaga kalau keranjang kosong tapi maksa checkout
            if($carts->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjangmu kosong!');
            }

            // Hitung total harga final
            $totalHarga = $carts->sum(fn($c) => $c->produk->hargaproduk * $c->qty);

            // A. SIMPAN KE TABEL ORDER (Status awal: Pending)
            $order = Order::create([
                'userID'     => $userID,
                'totalharga' => $totalHarga,
                'status'     => 'pending' 
            ]);

            // B. PINDAHKAN DETAIL BARANG (Dari Keranjang ke DetailOrder)
            foreach($carts as $c) {
                DetailOrder::create([
                    'orderID'  => $order->orderID,
                    'produkID' => $c->produkID,
                    'qty'      => $c->qty
                ]);
            }

            // C. HAPUS ISI KERANJANG (Kan sudah dipindah ke Order)
            Keranjang::where('userID', $userID)->delete();

            // Simpan perubahan ke Database
            DB::commit();

            // Arahkan ke halaman Pembayaran (QRIS)
            return redirect()->route('pembayaran.tunggu', $order->orderID);

        } catch (\Exception $e) {
            // Kalau ada error, batalkan semua
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}