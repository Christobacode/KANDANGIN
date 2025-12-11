@extends('layouts.main')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container py-5" style="margin-top: 2rem;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h4 class="fw-bold text-dark">Tambah Produk Baru</h4>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('produk.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Produk</label>
                            <input type="text" name="namaproduk" class="form-control" placeholder="Contoh: Sensor Panas" required>
                            <div class="form-text text-muted">
                                *Tips: Gunakan kata kunci (Panas, Dingin, Angin, Lampu, Siram, Pupuk) agar gambar muncul otomatis.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="kategoriID" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->kategoriID }}">{{ $kat->namakategori }}</option>
                                @endforeach
                            </select>
                            @if($kategori->isEmpty())
                                <small class="text-danger">Kategori kosong! Tambahkan data di database tabel 'kategori' dulu.</small>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="hargaproduk" class="form-control" placeholder="50000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stok Awal</label>
                                <input type="number" name="stokproduk" class="form-control" placeholder="10" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Produk</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection