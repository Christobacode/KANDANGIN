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

        // Hitung total bayar (Harga x Jumlah)
        $totalBayar = $carts->sum(function($item) {
            return $item->produk->hargaproduk * $item->qty;
        });

        return view('keranjang', compact('carts', 'totalBayar'));
    }

    // ==========================================================
    // 2. TAMBAH BARANG KE KERANJANG (Tombol Beli)
    // ==========================================================
    public function addToCart($produkID)
    {
        $userID = Auth::id();

        // Cek dulu: Barang ini udah ada di keranjang belum?
        $cekItem = Keranjang::where('userID', $userID)
                            ->where('produkID', $produkID)
                            ->first();

        if ($cekItem) {
            // Kalau sudah ada, kita tambahkan jumlahnya aja (+1)
            $cekItem->increment('qty');
        } else {
            // Kalau belum ada, kita bikin baris baru
            Keranjang::create([
                'userID'   => $userID,
                'produkID' => $produkID,
                'qty'      => 1
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Berhasil masuk keranjang!');
    }

    // ==========================================================
    // 3. UPDATE JUMLAH (Tombol + dan - di Keranjang)
    // ==========================================================
    public function updateQty(Request $request, $keranjangID)
    {
        $cart = Keranjang::where('keranjangID', $keranjangID)->first();
        
        // Kalau user tekan tombol TAMBAH (+)
        if($request->type == 'plus') {
            $cart->increment('qty');
        } 
        // Kalau user tekan tombol KURANG (-)
        elseif($request->type == 'minus') {
            // Cek sisa jumlah, kalau > 1 kurangi biasa
            if($cart->qty > 1) {
                $cart->decrement('qty');
            } else {
                // Kalau sisa 1 dikurangi, berarti dihapus dari keranjang
                $cart->delete();
            }
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