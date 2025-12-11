@extends('layouts.main')

@section('title', 'Layanan - Kandangin')
@section('body-class', 'page-layanan')

@section('content')
<section id="layanan" class="layanan-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="layanan-title">Layanan</h2>
                <p class="layanan-description mt-3">Layanan KANDANGIN hadir untuk membantu para peternak...</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-4 text-center mb-4">
                <div class="layanan-icon-wrapper">
                    <img src="{{ asset('assets/layanan1.png') }}" alt="Layanan AkuBisa" class="layanan-icon-img">
                </div>
                <h5 class="layanan-item-title mt-4">Kemitraan AkuBisa</h5>
                <p class="layanan-item-description mt-3">Program AkuBisa ditujukan bagi Anda yang baru memulai usaha peternakan.</p>
            </div>
            <div class="col-lg-4 text-center mb-4">
                <div class="layanan-icon-wrapper">
                    <img src="{{ asset('assets/layanan2.png') }}" alt="Layanan AkuHebat" class="layanan-icon-img">
                </div>
                <h5 class="layanan-item-title mt-4">Kemitraan AkuHebat</h5>
                <p class="layanan-item-description mt-3">Program AkuHebat dirancang untuk peternak yang sudah memiliki kandang.</p>
            </div>
            <div class="col-lg-4 text-center mb-4">
                <div class="layanan-icon-wrapper">
                    <img src="{{ asset('assets/layanan3.png') }}" alt="Layanan AkuJago" class="layanan-icon-img">
                </div>
                <h5 class="layanan-item-title mt-4">Kemitraan AkuJago</h5>
                <p class="layanan-item-description mt-3">Program AkuJago adalah kemitraan premium bagi peternak profesional.</p>
            </div>
        </div>
    </div>
</section>
@endsection