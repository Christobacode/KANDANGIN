@extends('layouts.main')

@section('title', 'Keranjang Belanja')

@section('content')
<main class="product-section py-5">
    <div class="container">
        <div class="mb-5">
            <h2 class="product-section-title m-0">Keranjang Belanja</h2>
            <hr class="mt-4">
        </div>

        @if($carts->isEmpty())
            <div class="text-center py-5">
                <img src="{{ asset('assets/keranjang.png') }}" style="width: 100px; opacity: 0.5;">
                <h4 class="mt-3 text-muted">Keranjang masih kosong</h4>
                <a href="{{ route('produk.index') }}" class="btn btn-primary mt-3">Mulai Belanja</a>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    @foreach($carts as $item)
                    <div class="card mb-3 border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->produk->gambar ? asset('storage/'.$item->produk->gambar) : asset('assets/Logo_kandangin.jpg') }}" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" 
                                     class="me-3">
                                
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-bold">{{ $item->produk->namaproduk }}</h5>
                                    <p class="text-primary mb-0 fw-bold">Rp {{ number_format($item->produk->hargaproduk, 0, ',', '.') }}</p>
                                </div>

                                <div class="d-flex align-items-center bg-light rounded px-2 py-1">
                                    <form action="{{ route('keranjang.update', $item->keranjangID) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="minus">
                                        <button type="submit" class="btn btn-sm text-danger fw-bold border-0" style="background: none;">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    </form>

                                    <span class="mx-3 fw-bold">{{ $item->qty }}</span>

                                    <form action="{{ route('keranjang.update', $item->keranjangID) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="plus">
                                        <button type="submit" class="btn btn-sm text-success fw-bold border-0" style="background: none;">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 rounded-4">
                        <h4 class="mb-4 fw-bold">Ringkasan</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Item</span>
                            <span class="fw-bold">{{ $carts->sum('qty') }} Barang</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Total Harga</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                        </div>
                        
                        <form action="{{ route('keranjang.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn w-100 py-2 fw-bold text-white" style="background-color: #2ecc71; border-radius: 10px;">
                                Beli Sekarang <i class="bi bi-arrow-right-circle ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection