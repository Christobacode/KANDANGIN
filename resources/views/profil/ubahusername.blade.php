@extends('layouts.main')

@section('title', 'Ubah Username - Kandangin')
@section('body-class', 'page-ubah-username')

@section('content')
<main class="change-username-page py-5">
    <div class="container">
        <div class="row align-items-center justify-content-center gx-lg-5">
            
            <div class="col-lg-4 text-center mb-5 mb-lg-0">
                <div class="big-profile-icon-wrapper-square">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="big-profile-svg-curved">
                        <circle cx="8" cy="4.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.5" />
                        <path d="M 2 15 C 2 8, 14 8, 14 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="form-title fw-bold mb-4" style="color: #0B132A;">Ubah Username</h2>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('profil.username.update') }}" method="POST" id="form-ubah-username">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Username Lama</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->username }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Username Baru</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username baru" required>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#ubahUsernameModal">
                            Simpan
                        </button>
                        <a href="{{ route('profil') }}" class="btn btn-danger px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="ubahUsernameModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <h3 class="confirmation-text mb-4">
                    Apakah Anda Yakin Ingin Mengubah Username?
                </h3>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-confirm-action btn-confirm-yes"
                        onclick="document.getElementById('form-ubah-username').submit()">YA</button>
                    <button type="button" class="btn btn-confirm-action btn-confirm-no" data-bs-dismiss="modal">TIDAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection