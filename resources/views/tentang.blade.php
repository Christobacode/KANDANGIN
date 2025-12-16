@extends('layouts.main')

@section('title', 'Tentang Kami - Kandangin')
@section('body-class', 'page-tentang')

@section('content')
<main class="tentang-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="tentang-title">Tentang</h2>
                <p class="tentang-description mt-3">
                    KANDANGIN adalah platform digital yang dirancang untuk membantu para peternak mengelola
                    kandangnya dengan lebih mudah, efisien, dan modern. Kami percaya bahwa teknologi dapat menjadi
                    solusi nyata dalam meningkatkan produktivitas dan kesejahteraan peternak Indonesia.
                </p>
            </div>
        </div>

        <div class="row align-items-center mt-5">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <img src="{{ asset('assets/tentang1.jpeg') }}" alt="Tentang Kandangin" class="img-fluid rounded-4 shadow">
            </div>

            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <li class="d-flex align-items-start mb-4">
                        <div class="feature-icon-wrapper me-3">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <h5 class="feature-title">Customer Support</h5>
                            <p class="feature-description">
                                Tim kami siap membantu kapan pun Anda membutuhkan panduan teknis.
                            </p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start mb-4">
                        <div class="feature-icon-wrapper me-3">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <h5 class="feature-title">Harga Terbaik</h5>
                            <p class="feature-description">
                                Menyediakan peralatan berkualitas tinggi dengan harga kompetitif.
                            </p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start">
                        <div class="feature-icon-wrapper me-3">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <h5 class="feature-title">Layanan Terbaik</h5>
                            <p class="feature-description">
                                Konsultasi, pemasangan, dan pelatihan penggunaan alat secara profesional.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-5 pt-4">
            <div class="col-lg-6 mb-4">
                <div class="ads-card">
                    {{-- Menggunakan asset() ke folder assets langsung --}}
                    <img src="{{ asset('assets/tentang2.jpeg') }}" alt="tentang 1" class="ads-image">
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="ads-card">
                    {{-- Menggunakan asset() ke folder assets langsung --}}
                    <img src="{{ asset('assets/tentang3.jpeg') }}" alt="tentang 2" class="ads-image">
                </div>
            </div>
        </div>
    </div>
</main>
@endsection