@extends('layouts.main')

@section('title', 'Riwayat Pesanan')

@section('content')
{{-- riwayat pesanan --}}
<div class="container py-5">
    <h2 class="mb-4">Riwayat Pesanan Saya</h2>
    
    @foreach($orders as $order)
    <div class="card mb-4 border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold">Order #{{ $order->orderID }}</span>
                <span class="text-muted small ms-2">| {{ $order->tanggal_order }}</span>
            </div>
            <span class="badge rounded-pill {{ $order->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ $order->status == 'paid' ? 'Lunas' : 'Menunggu Bayar' }}
            </span>
        </div>
        <div class="card-body">
            {{-- card body --}}
            <div class="row">
                <div class="col-md-8">
                    <ul class="list-unstyled mb-0">
                        @foreach($order->detail as $item)
                            {{-- Hanya menampilkan jika produknya masih ada --}}
                            @if($item->produk)
                            <li class="mb-2">
                                <i class="bi bi-box-seam me-2 text-primary"></i>
                                <strong>{{ $item->qty }}x</strong> {{ $item->produk->namaproduk }}
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                {{-- total belanja --}}
                <div class="col-md-4 text-end border-start">
                    <p class="text-muted mb-1">Total Belanja</p>
                    <h5 class="fw-bold text-primary">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</h5>
                    {{-- status order --}}
                    @if($order->status == 'pending')
                        <a href="{{ route('pembayaran.tunggu', $order->orderID) }}" class="btn btn-sm btn-warning mt-2">
                            Bayar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection