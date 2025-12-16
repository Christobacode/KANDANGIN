@extends('layouts.main')

@section('title', 'Admin Produk - Kandangin')
@section('body-class', 'page-produk-admin')

@section('content')
<section id="produk-admin" class="product-section py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-8">
                <h2 class="product-section-title">Kelola Produk (Admin)</h2>
                <p class="text-muted">Anda dalam mode Administrator. Bisa tambah, edit, dan hapus produk.</p>
            </div>
            <div class="col-4 text-end">
                <a href="{{ route('produk.create') }}" class="btn btn-primary shadow-sm px-4">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                </a>
            </div>
        </div>

        <ul class="nav nav-tabs justify-content-center border-0 mb-5" id="productTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">Semua</button>
            </li>
            @foreach($kategori as $kat)
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#kat-{{ $kat->kategoriID }}">
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
                            <div class="product-card h-100 position-relative border border-primary border-opacity-25">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="product-name">{{ $item->namaproduk }}</h5>
                                        <span class="badge bg-secondary">Stok: {{ $item->stokproduk }}</span>
                                    </div>

                                    {{-- GAMBAR PRODUK (Hanya dari Upload) --}}
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('assets/Logo_kandangin.jpg') }}" 
                                         class="product-card-img mb-3" 
                                         style="object-fit: contain; height: 150px; background-color: #f8f9fa;">

                                    <div class="mt-auto">
                                        <h5 class="product-price mb-3">Rp {{ number_format($item->hargaproduk, 0, ',', '.') }}</h5>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('produk.edit', $item->produkID) }}" class="btn btn-warning btn-sm flex-fill fw-bold">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="{{ route('produk.destroy', $item->produkID) }}" method="POST" class="flex-fill" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada produk. Silakan tambah produk baru.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @foreach($kategori as $kat)
                <div class="tab-pane fade" id="kat-{{ $kat->kategoriID }}">
                    <div class="row">
                        @forelse($produk->where('kategoriID', $kat->kategoriID) as $item)
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card h-100 position-relative border border-primary border-opacity-25">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="product-name">{{ $item->namaproduk }}</h5>
                                            <span class="badge bg-secondary">Stok: {{ $item->stokproduk }}</span>
                                        </div>

                                        {{-- GAMBAR PRODUK (Hanya dari Upload) --}}
                                        <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('assets/Logo_kandangin.jpg') }}" 
                                             class="product-card-img mb-3" 
                                             style="object-fit: contain; height: 150px; background-color: #f8f9fa;">

                                        <div class="mt-auto">
                                            <h5 class="product-price mb-3">Rp {{ number_format($item->hargaproduk, 0, ',', '.') }}</h5>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('produk.edit', $item->produkID) }}" class="btn btn-warning btn-sm flex-fill fw-bold">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('produk.destroy', $item->produkID) }}" method="POST" class="flex-fill" onsubmit="return confirm('Hapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
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