@extends('layouts.main')

@section('title', 'Menunggu Pembayaran')

@section('content')
<main class="payment-page py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Menunggu Pembayaran</h1>
            <p class="text-muted">Order ID: #{{ $order->orderID }} | Tanggal: {{ $order->tanggal_order }}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 rounded-4 text-center p-4 h-100">
                    <h5 class="fw-bold mb-3">Scan QRIS untuk Membayar</h5>
                    <div class="bg-light p-3 rounded-3 d-inline-block">
                        <img src="{{ asset('assets/qris.png') }}" alt="QRIS" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <div class="mt-4">
                        <img src="{{ asset('assets/qr-pembayaran.png') }}" class="img-fluid mb-2" style="width: 150px;">
                        <p class="mb-0 fw-bold text-danger">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 h-100">
                    <h5 class="fw-bold mb-3">Rincian Pesanan</h5>
                    <div class="list-group list-group-flush">
                        @foreach($order->detail as $item)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-3 rounded-pill">{{ $item->qty }}x</span>
                                <div>
                                    <h6 class="mb-0">{{ $item->produk->namaproduk }}</h6>
                                </div>
                            </div>
                            <span class="text-muted small">
                                Rp {{ number_format($item->produk->hargaproduk * $item->qty, 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-4 d-grid gap-2">
                        <form action="{{ route('pembayaran.confirm', $order->orderID) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                Saya Sudah Bayar <i class="bi bi-check-circle-fill ms-2"></i>
                            </button>
                        </form>
                        <a href="{{ route('keranjang.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection