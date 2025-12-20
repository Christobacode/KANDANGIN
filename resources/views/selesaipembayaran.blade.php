@extends('layouts.main')

@section('title', 'Pembayaran Berhasil')

@section('content')
{{-- section Pembayaran Berhasil --}}
<main class="payment-success-page py-5 d-flex align-items-center" style="min-height: 60vh;">
    <div class="container text-center">
        <div class="mb-4">
            <img src="{{ asset('assets/pembayaranselesai.png') }}" alt="Sukses" class="img-fluid" style="max-width: 300px;">
        </div>
        <h2 class="fw-bold text-success mb-3">Pembayaran Selesai!</h2>
        <p class="text-muted mb-4">Terima kasih telah berbelanja di Kandangin. Pesananmu sedang kami proses.</p>
        
        <a href="{{ route('home') }}" class="btn btn-primary px-5 py-2 fw-bold rounded-pill">
            Kembali ke Beranda
        </a>
    </div>
</main>
@endsection