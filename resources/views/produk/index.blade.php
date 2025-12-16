@extends('layouts.main')

@section('title', 'Produk - Kandangin')
@section('body-class', 'page-produk')

@section('content')
<section id="produk" class="product-section py-5">
    <div class="container">
        
        <div class="row align-items-center mb-5 position-relative">
            <div class="col-2"></div>
            <div class="col-8 text-center">
                <h2 class="product-section-title">Produk KANDANGIN</h2>
                <p class="product-section-subtitle mt-2 text-muted">
                    Dapatkan berbagai peralatan peternakan dengan kualitas terbaik<br>dan harga terjangkau.
                </p>
            </div>
            <div class="col-2 text-end">
                <a href="#" class="text-decoration-none position-relative d-inline-block">
                    <img src="{{ asset('assets/keranjang.png') }}" alt="Keranjang" style="width: 45px; height: auto;">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
                        0
                    </span>
                </a>
            </div>
        </div>

        <ul class="nav nav-tabs justify-content-center border-0 mb-5" id="productTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#all">Semua Produk</button>
            </li>
            @foreach($kategori as $kat)
                <li class="nav-item">
                    <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#kat-{{ $kat->kategoriID }}">
                        {{ $kat->namakategori }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            
            <div class="tab-pane fade show active" id="all">
                <div class="row">
                    @forelse($produk as $item)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="product-card h-100 border-0 shadow-sm rounded-4 bg-white p-3">
                                <div class="d-flex flex-column h-100">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="product-name fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $item->namaproduk }}</h5>
                                        <span class="badge rounded-pill {{ $item->stokproduk > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->stokproduk > 0 ? 'Stok: '.$item->stokproduk : 'Habis' }}
                                        </span>
                                    </div>

                                    <div class="text-center mb-3">
                                        {{-- Jika ada gambar upload pakai itu, jika tidak pakai logo sebagai placeholder --}}
                                        <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('assets/Logo_kandangin.jpg') }}" 
                                             class="img-fluid rounded-3" 
                                             style="height: 160px; object-fit: contain;">
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($item->hargaproduk, 0, ',', '.') }}</h5>
                                        
                                        <form action="{{ route('order.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="items[0][produkID]" value="{{ $item->produkID }}">
                                            <input type="hidden" name="items[0][qty]" value="1">
                                            
                                            <button type="submit" class="btn btn-sm px-4 fw-bold text-white" 
                                                style="background-color: #2ecc71; border-radius: 8px;"
                                                {{ $item->stokproduk <= 0 ? 'disabled' : '' }}>
                                                {{ $item->stokproduk > 0 ? 'Beli' : 'Habis' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('assets/keranjang.png') }}" style="width: 80px; opacity: 0.5;">
                            <p class="text-muted mt-3">Belum ada produk yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @foreach($kategori as $kat)
                <div class="tab-pane fade" id="kat-{{ $kat->kategoriID }}">
                    <div class="row">
                        @php
                            $produkKategori = $produk->where('kategoriID', $kat->kategoriID);
                        @endphp

                        @forelse($produkKategori as $item)
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card h-100 border-0 shadow-sm rounded-4 bg-white p-3">
                                    <div class="d-flex flex-column h-100">
                                        
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="product-name fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $item->namaproduk }}</h5>
                                            <span class="badge rounded-pill {{ $item->stokproduk > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $item->stokproduk > 0 ? 'Stok: '.$item->stokproduk : 'Habis' }}
                                            </span>
                                        </div>

                                        <div class="text-center mb-3">
                                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('assets/Logo_kandangin.jpg') }}" 
                                                 class="img-fluid rounded-3" 
                                                 style="height: 160px; object-fit: contain;">
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <h5 class="fw-bold text-primary mb-0">Rp {{ number_format($item->hargaproduk, 0, ',', '.') }}</h5>
                                            
                                            <form action="{{ route('order.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="items[0][produkID]" value="{{ $item->produkID }}">
                                                <input type="hidden" name="items[0][qty]" value="1">
                                                
                                                <button type="submit" class="btn btn-sm px-4 fw-bold text-white" 
                                                    style="background-color: #2ecc71; border-radius: 8px;"
                                                    {{ $item->stokproduk <= 0 ? 'disabled' : '' }}>
                                                    {{ $item->stokproduk > 0 ? 'Beli' : 'Habis' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Tidak ada produk di kategori ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
@endsection