@extends('layouts.main')

@section('title', 'Ganti Kata Sandi - Kandangin')
@section('body-class', 'page-ganti-sandi')

@section('content')
<main class="change-password-page py-5">
    <div class="container">
        <div class="row align-items-center justify-content-center gx-lg-5">
            
            <div class="col-lg-4 text-center mb-5 mb-lg-0">
                <div class="big-profile-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="big-profile-svg">
                        <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="form-title fw-bold mb-4" style="color: #0B132A;">Ganti Kata Sandi</h2>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profil.password.update') }}" method="POST" id="form-ganti-sandi">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#gantiSandiModal">
                            Simpan
                        </button>
                        <a href="{{ route('profil') }}" class="btn btn-danger px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="gantiSandiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <h3 class="confirmation-text mb-4">
                    Apakah Anda Yakin Ingin Mengubah Kata Sandi?
                </h3>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-confirm-action btn-confirm-yes" 
                        onclick="document.getElementById('form-ganti-sandi').submit()">YA</button>
                    <button type="button" class="btn btn-confirm-action btn-confirm-no" data-bs-dismiss="modal">TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection