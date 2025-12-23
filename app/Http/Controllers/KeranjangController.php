<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Order;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Berisi function buat mengelola logika keranjang seperti perubahan kuantitas dan proses checkout
class KeranjangController extends Controller
{
    
    //Menampilkan daftar item di keranjang belanja user yang sedang login.
    public function index()
    {   
        $userID = Auth::id();
        
        // mengambil data keranjang user beserta info produknya
        $carts = Keranjang::with('produk')->where('userID', $userID)->get();

        // Menghitung total biaya pake sum
        $totalBayar = $carts->sum(function($item) {
            return ($item->produk?->hargaproduk ?? 0) * $item->qty;
        });

        return view('keranjang', compact('carts', 'totalBayar'));
    }


    // Menambahkan barang ke karanjang 
    public function addToCart($produkID)
    {
        $userID = Auth::id();

        // mengambil data produk berdasarkan $produkID agar variabel $produk terdefinisi
        // menggunakan findOrFail agar otomatis error 404 jika ID produk tidak ditemukan
        $produk = Produk::findOrFail($produkID); 

        // Buat menampilkan semisal produk sudah habis maka akan ada output maaf stok produk sudah habis
        if ($produk->stokproduk < 1) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sudah habis!');
        }

        // Mengecek apakah barang sudah ada di keranjang
        $cekItem = \App\Models\Keranjang::where('userID', $userID)
                            ->where('produkID', $produkID)
                            ->first();

        if ($cekItem) {
            // jika sudah ada  di keranjang yang ditambah jumlahnya (+1)
            $cekItem->increment('qty');
        } else {
            // jika belum ada, buat data baru
            \App\Models\Keranjang::create([
                'userID'   => $userID,
                'produkID' => $produkID,
                'qty'      => 1
            ]);
        }

        // kurangi stok produk
        $produk->decrement('stokproduk');
    
        return redirect()->route('keranjang.index')->with('success', 'Berhasil masuk keranjang!');
    }

    // Memperbarui jumlah produk yang mau dibeli di keranjang(nambah/kurangi)
    public function updateQty(Request $request, $keranjangID)
    {
        // Cari data keranjang beserta info produknya
        $cart = \App\Models\Keranjang::with('produk')->where('keranjangID', $keranjangID)->firstOrFail();
        $produk = $cart->produk; 

        if($request->type == 'plus') {
            // cek apakah stok masih ada atau habis
            // validasi Stok: Cek apakah masih bisa ditambah
            if (!$produk || $produk->stokproduk < 1) {
                return redirect()->back()->with('error', 'Gagal menambah jumlah! Stok sudah habis.');
            }
            
            $cart->increment('qty');
            $produk->decrement('stokproduk'); // kurangi stok karena barang di keranjang bertambah
        } 
        elseif($request->type == 'minus') {
            if($cart->qty > 1) {
                $cart->decrement('qty');
            } else {
                // Kalau qty menjadi 0 maka akan di hapus dari keranjang
                $cart->delete();
            }
            
            // Kalau barang yang di keranjang dikurangi maka stok produknya nambah
            $produk->increment('stokproduk');
        }
        
        return redirect()->back();
    }

    // Function buat lanjut ke checkout
    public function checkout()
    {
        // Memulai transaksi database
        DB::beginTransaction();
        
        try {
            $userID = Auth::id();
            
            // mengambil semua isi keranjang user
            $carts = Keranjang::with('produk')->where('userID', $userID)->get();

           
            if($carts->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjangmu kosong!');
            }

            // hitung total harga final 
            $totalHarga = $carts->sum(fn($c) => $c->produk->hargaproduk * $c->qty);

           
            $order = Order::create([
                'userID'     => $userID,
                'totalharga' => $totalHarga,
                'status'     => 'pending' 
            ]);

            // Pindahkan produk yang dibeli ke detailorder
            foreach($carts as $c) {
                DetailOrder::create([
                    'orderID'  => $order->orderID,
                    'produkID' => $c->produkID,
                    'qty'      => $c->qty
                ]);
            }

            // Kosongkan keranjang user setelah checkout berhasil
            Keranjang::where('userID', $userID)->delete();

            // simpan perubahan ke Database
            DB::commit();

            // arahkan ke halaman Pembayaran (QRIS)
            return redirect()->route('pembayaran.tunggu', $order->orderID);

        } catch (\Exception $e) {
            // kalau ada error, batalkan semua
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}