@extends('layouts.main')

@section('title', 'Kandangin')
@section('body-class', 'page-home')

@section('content')
<main id="home" class="hero-section-new" 
      style="
         background-image: url('{{ asset('assets/background-field2.1.jpg') }}');
         background-size: cover;
         background-position: center;
         background-attachment: fixed;
         padding: 8rem 0; 
         position: relative;
      ">
      
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <p class="hero-tagline">Solusi Cerdas untuk Peternakan Modern</p>
                <h1 class="hero-heading my-4">KANDANGIN</h1>
                <p class="hero-description">
                    Kelola kandang Anda dengan lebih efisien menggunakan teknologi otomatisasi dari KANDANGIN.
                    Pantau kondisi lingkungan, atur pencahayaan, dan kontrol peralatan secara real-time hanya dalam
                    satu aplikasi.
                </p>
                <a href="https://wa.me/6281234567890" class="btn btn-hubungi-kami mt-4" target="_blank">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</main>
@endsection