@extends('layouts.main')

@section('title', 'Produk - Kandangin')
@section('body-class', 'page-produk')

@section('content')
<section id="produk" class="product-section py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-2 text-start"></div>
            <div class="col-8 text-center">
                <h2 class="product-section-title">Produk KANDANGIN</h2>
                <p class="product-section-subtitle mt-2">
                    Dapatkan berbagai peralatan peternakan dengan kualitas <br>
                    terbaik dan harga terjangkau hanya di KANDANGIN
                </p>
            </div>
            <div class="col-2 text-end position-relative">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary mb-2">+ Add</a>
                    @endif
                @endauth
                
                <a href="#" class="cart-icon-link d-inline-block position-relative">
                    <img src="{{ asset('assets/keranjang.png') }}" alt="Keranjang" class="icon-keranjang-png">
                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
                </a>
            </div>
        </div>

        <ul class="nav nav-tabs justify-content-center border-0 mb-5" id="productTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">Semua Produk</button></li>
        </ul>

        <div class="tab-content" id="productTabsContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="row">
                    @forelse($produk as $item)
                    <div class="col-lg-3 col-md-6 mb-4 product-item">
                        <div class="product-card h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="product-name">{{ $item->namaproduk }}</h5>
                                    <span class="stock-status {{ $item->stokproduk > 0 ? 'text-success' : 'text-danger' }}">
                                        Stok: {{ $item->stokproduk }}
                                    </span>
                                </div>
                                
                                @php
                                    $gambar = 'sensor-panas.jpeg'; 
                                    $nama = strtolower($item->namaproduk);
                                    // Logika pencocokan nama file
                                    if (strpos($nama, 'panas') !== false) $gambar = 'sensor-panas.jpeg';
                                    elseif (strpos($nama, 'dingin') !== false) $gambar = 'sensor-dingin.jpeg';
                                    elseif (strpos($nama, 'angin') !== false) $gambar = 'sensor-angin.jpeg';
                                    elseif (strpos($nama, 'darurat') !== false) $gambar = 'alarm-darurat.jpeg';
                                    elseif (strpos($nama, 'lampu') !== false) $gambar = 'lampu-kandang.jpeg';
                                    elseif (strpos($nama, 'gerak') !== false) $gambar = 'sensor-gerak.jpeg';
                                    elseif (strpos($nama, 'kabel') !== false) $gambar = 'kabel-n2c.jpeg';
                                    elseif (strpos($nama, 'siram') !== false || strpos($nama, 'penyiram') !== false) $gambar = 'penyiram-otomatis.jpeg';
                                    elseif (strpos($nama, 'pupuk kandang') !== false) $gambar = 'pupuk-kandang.png';
                                    elseif (strpos($nama, 'media') !== false) $gambar = 'media-tanam.png';
                                    elseif (strpos($nama, 'kompos') !== false) $gambar = 'pupuk-kompos-premium.png';
                                    elseif (strpos($nama, 'insektisida') !== false) $gambar = 'insektisida.png';
                                @endphp

                                <img src="{{ asset('assets/' . $gambar) }}" alt="{{ $item->namaproduk }}" class="product-card-img mb-3" style="object-fit: contain; height: 150px;">
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="product-price">Rp {{ number_format($item->hargaproduk, 0, ',', '.') }}</span>
                                    <form action="{{ route('order.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="items[0][produkID]" value="{{ $item->produkID }}">
                                        <input type="hidden" name="items[0][qty]" value="1">
                                        <button type="submit" class="btn btn-beli">Beli</button>
                                    </form>
                                    @auth
                                        @if(Auth::user()->role === 'admin')
                                            <div class="mt-2">
                                                <a href="{{ route('produk.edit', $item->produkID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Belum ada data produk.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection