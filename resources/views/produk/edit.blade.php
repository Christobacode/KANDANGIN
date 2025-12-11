@extends('layouts.main')

@section('title', 'Edit Produk')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Edit Produk</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.update', $produk->produkID) }}" method="POST" id="formEditProduk">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" name="namaproduk" class="form-control" value="{{ $produk->namaproduk }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="kategoriID" class="form-select" required>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->kategoriID }}" {{ $produk->kategoriID == $kat->kategoriID ? 'selected' : '' }}>
                                        {{ $kat->namakategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Harga</label>
                                <input type="number" name="hargaproduk" class="form-control" value="{{ $produk->hargaproduk }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Stok</label>
                                <input type="number" name="stokproduk" class="form-control" value="{{ $produk->stokproduk }}" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Produk</button>
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/edit-produk.js') }}"></script>
@endpush