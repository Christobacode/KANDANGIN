@extends('layouts.main')

@section('title', 'Riwayat Order - Kandangin')
@section('body-class', 'page-profil') {{-- Menggunakan class page-profil agar background sama --}}

@section('content')
<main class="py-5" style="min-height: 80vh;">
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('profil') }}" class="text-decoration-none text-dark me-3">
                <i class="bi bi-arrow-left fs-3"></i>
            </a>
            <h2 class="fw-bold m-0" style="color: #0B132A;">Riwayat Order</h2>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-5">
                <img src="{{ asset('assets/keranjang.png') }}" alt="Kosong" style="width: 100px; opacity: 0.5;">
                <h4 class="mt-3 text-muted">Belum ada riwayat pesanan.</h4>
                <a href="{{ route('produk.index') }}" class="btn btn-primary mt-2">Belanja Sekarang</a>
            </div>
        @else
            <div class="row">
                @foreach($orders as $order)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">Order #{{ $order->orderID }}</h5>
                                    <small class="text-muted">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</small>
                                </div>
                                <span class="badge rounded-pill px-3 py-2 
                                    {{ $order->status == 'Selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $order->status ?? 'Menunggu' }}
                                </span>
                            </div>

                            <hr class="my-3" style="border-color: #eee;">

                            {{-- List Barang Singkat --}}
                            <div class="mb-3">
                                @foreach($order->detailOrder as $detail)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            {{-- Jika ada gambar produk --}}
                                            @if($detail->produk && $detail->produk->gambar)
                                                <img src="{{ asset('storage/' . $detail->produk->gambar) }}" 
                                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <span class="d-block fw-semibold" style="font-size: 0.9rem;">
                                                    {{ $detail->produk->nama_produk ?? 'Produk dihapus' }}
                                                </span>
                                                <small class="text-muted">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div>
                                    <small class="text-muted d-block">Total Pembayaran</small>
                                    <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
                                </div>
                                {{-- Jika ingin menambahkan tombol detail/invoice nanti --}}
                                {{-- <button class="btn btn-outline-dark btn-sm rounded-pill px-4">Detail</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection