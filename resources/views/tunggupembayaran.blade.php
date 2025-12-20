@extends('layouts.main')

@section('title', 'Menunggu Pembayaran')

@section('content')
<main class="payment-page py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Menunggu Pembayaran</h1>
            {{-- Menggunakan null coalescing untuk keamanan data tanggal --}}
            <p class="text-muted">Order ID: #{{ $order->orderID }} | Tanggal: {{ $order->tanggal_order ?? '-' }}</p>
        </div>

        <div class="row justify-content-center">
            {{-- Bagian QRIS --}}
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 rounded-4 text-center p-4 h-100">
                    <h5 class="fw-bold mb-3">Scan QRIS untuk Membayar</h5>
                    <div class="bg-light p-3 rounded-3 d-inline-block shadow-sm">
                        <img src="{{ asset('assets/qris.png') }}" alt="QRIS" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <div class="mt-4">
                        {{-- gambar QRIS --}}
                        <img src="{{ asset('assets/qr-pembayaran.png') }}" class="img-fluid mb-2" style="width: 150px;">
                        <p class="mb-0 fw-bold text-danger fs-4">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Bagian Rincian Pesanan --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 h-100">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Rincian Pesanan</h5>
                    <div class="list-group list-group-flush mb-3">
                        @foreach($order->detail as $item)
                            {{-- Standard Programming: Hanya tampilkan jika produk masih ada di database --}}
                            @if($item->produk)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary me-3 rounded-pill">{{ $item->qty }}x</span>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $item->produk->namaproduk }}</h6>
                                            <small class="text-muted">Rp {{ number_format($item->produk->hargaproduk, 0, ',', '.') }} / unit</small>
                                        </div>
                                    </div>
                                    <span class="text-dark fw-bold">
                                        Rp {{ number_format($item->produk->hargaproduk * $item->qty, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-between fw-bold fs-5 p-3 bg-light rounded-3">
                        <span>Total Bayar</span>
                        <span class="text-primary">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-4 d-grid gap-2">
                        {{-- Form konfirmasi pembayaran --}}
                        <form action="{{ route('pembayaran.confirm', $order->orderID) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                                Saya Sudah Bayar <i class="bi bi-check-circle-fill ms-2"></i>
                            </button>
                        </form>
                        
                        {{-- Tombol kembali menggunakan route name agar lebih standar --}}
                        <a href="{{ route('order.history') }}" class="btn btn-outline-secondary rounded-pill">
                            Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection