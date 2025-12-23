<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller ini buat ngurusin semua yang berhubungan sama pesanan
class OrderController extends Controller
{
    // Function  buat menampilkan riwayat pesanan
    public function history()
    {
        $user = Auth::user();

        // Ambil data order + user yang beli + detail itemnya.
        // menambahkan filter 'has produk' agar detail yang produknya sudah dihapus tidak muncul
        $query = Order::with(['user', 'detail' => function($q) {
            $q->has('produk'); 
        }, 'detail.produk']);

        if ($user->role === 'admin') {
            // admin: Melihat pesanan dari semua user yang telah dilakukan
            $orders = $query->where('userID', '!=', $user->userID)
                            ->orderBy('orderID', 'desc')
                            ->get();

            return view('order.admin_history', compact('orders'));
        }

        // user Biasa: Hanya melihat pesanan miliknya sendiri
        $orders = $query->where('userID', $user->userID)
                        ->orderBy('orderID', 'desc')
                        ->get();

        return view('order.history', compact('orders'));
    }

    // halaman pembayaran dengan qris
    public function showPayment($orderID)
    {
        // pastikan order yang dibuka adalah milik user yang login atau admin
        $order = Order::with(['detail.produk'])
                    ->where('orderID', $orderID)
                    ->where('userID', Auth::id())
                    ->firstOrFail(); // Memberikan error 404 jika tidak ditemukan

        // jika sudah lunas, langsung arahkan ke halaman selesai
        if ($order->status === 'paid') {
            return view('selesaipembayaran');
        }

        return view('tunggupembayaran', compact('order'));
    }

    // Function buat proses konfirmasi pembayaran
    public function confirmPayment($orderID)
    {
        // Cari order berdasarkan ID dan kepemilikan user
        $order = Order::where('orderID', $orderID)
                    ->where('userID', Auth::id())
                    ->firstOrFail();
        
        // Ganti status dari 'pending' ke 'paid'
        $order->status = 'paid';
        $order->save(); 

        // kembali ke halaman selesai pembayaran
        return view('selesaipembayaran');
    }
}