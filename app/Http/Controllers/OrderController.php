<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. RIWAYAT PESANAN
    public function history()
    {
        $userID = Auth::id();
        // Ambil order beserta detail produknya
        $orders = Order::with('detail.produk')
                    ->where('userID', $userID)
                    ->orderBy('orderID', 'desc')
                    ->get();

        return view('order.history', compact('orders'));
    }

    // 2. HALAMAN PEMBAYARAN (QRIS)
    public function showPayment($orderID)
    {
        $order = Order::with('detail.produk')
                    ->where('userID', Auth::id())
                    ->where('orderID', $orderID)
                    ->firstOrFail();

        if($order->status == 'paid') {
            return view('selesaipembayaran');
        }

        return view('tunggupembayaran', compact('order'));
    }

    // 3. KONFIRMASI PEMBAYARAN
    public function confirmPayment($orderID)
    {
        $order = Order::where('userID', Auth::id())->where('orderID', $orderID)->firstOrFail();
        $order->update(['status' => 'paid']);
        return view('selesaipembayaran');
    }
}