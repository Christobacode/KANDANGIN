<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Simpan Order Baru (Checkout)
    public function store(Request $request)
    {
        // Validasi input (misal input berupa array produk_id dan qty)
        $request->validate([
            'items' => 'required|array',
            'items.*.produkID' => 'required|exists:produk,produkID',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            // Gunakan DB Transaction agar data konsisten (Rollback jika error di tengah jalan)
            DB::beginTransaction();

            // 1. Hitung Total Harga
            $totalHarga = 0;
            $itemsToInsert = [];

            foreach ($request->items as $item) {
                $produk = Produk::find($item['produkID']);
                
                // Cek stok (opsional)
                if ($produk->stokproduk < $item['qty']) {
                    throw new \Exception("Stok produk {$produk->namaproduk} tidak cukup.");
                }

                $subtotal = $produk->hargaproduk * $item['qty'];
                $totalHarga += $subtotal;

                // Siapkan data untuk detail_order
                $itemsToInsert[] = [
                    'produk_obj' => $produk, // simpan object untuk kurangi stok nanti
                    'qty' => $item['qty']
                ];
            }

            // 2. Buat Record di tabel 'order'
            $order = Order::create([
                'userID' => Auth::id(), // Ambil ID user yang sedang login
                'totalharga' => $totalHarga,
            ]);

            // 3. Masukkan ke tabel 'detail_order' dan kurangi stok
            foreach ($itemsToInsert as $data) {
                // Attach ke pivot table
                $order->produk()->attach($data['produk_obj']->produkID, [
                    'qty' => $data['qty']
                ]);

                // Kurangi stok produk
                $data['produk_obj']->decrement('stokproduk', $data['qty']);
            }

            DB::commit(); // Simpan permanen jika semua sukses

            return redirect()->route('order.history')->with('success', 'Order berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua perubahan jika ada error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Lihat Riwayat Order
    public function history()
    {
        $orders = Order::where('userID', Auth::id())
                    ->with('produk') // Load relasi produk di detail order
                    ->orderBy('orderID', 'desc')
                    ->get();

        return view('order.history', compact('orders'));
    }
}