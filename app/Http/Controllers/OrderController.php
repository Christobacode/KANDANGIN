<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * 1. TAMPILKAN RIWAYAT PESANAN
     * Membedakan tampilan antara Admin (Laporan) dan User (Riwayat Pribadi)
     */
    public function history()
    {
        $user = Auth::user();

        // Standard Programming: Eager Loading untuk mencegah N+1 Query
        // Menambahkan filter 'has produk' agar detail yang produknya sudah dihapus tidak muncul
        $query = Order::with(['user', 'detail' => function($q) {
            $q->has('produk'); 
        }, 'detail.produk']);

        if ($user->role === 'admin') {
            // Admin: Melihat pesanan semua user kecuali miliknya sendiri
            $orders = $query->where('userID', '!=', $user->userID)
                            ->orderBy('orderID', 'desc')
                            ->get();

            return view('order.admin_history', compact('orders'));
        }

        // User Biasa: Hanya melihat pesanan milik sendiri
        $orders = $query->where('userID', $user->userID)
                        ->orderBy('orderID', 'desc')
                        ->get();

        return view('order.history', compact('orders'));
    }

    /**
     * 2. HALAMAN PEMBAYARAN (QRIS)
     * Mengambil detail pesanan spesifik untuk proses bayar
     */
    public function showPayment($orderID)
    {
        // Pastikan order yang dibuka adalah milik user yang login atau admin
        $order = Order::with(['detail.produk'])
                    ->where('orderID', $orderID)
                    ->where('userID', Auth::id())
                    ->firstOrFail(); // Memberikan error 404 jika tidak ditemukan

        // Jika sudah lunas, langsung arahkan ke halaman selesai
        if ($order->status === 'paid') {
            return view('selesaipembayaran');
        }

        return view('tunggupembayaran', compact('order'));
    }

    /**
     * 3. KONFIRMASI PEMBAYARAN
     * Mengubah status pesanan menjadi Lunas (Paid)
     */
    public function confirmPayment($orderID)
    {
        // Cari order berdasarkan ID dan kepemilikan user
        $order = Order::where('orderID', $orderID)
                    ->where('userID', Auth::id())
                    ->firstOrFail();
        
        // Update status menggunakan properti objek dan save() agar lebih eksplisit
        $order->status = 'paid';
        $order->save(); 

        // Sesuai alur: Kembali ke halaman sukses pembayaran
        return view('selesaipembayaran');
    }
}