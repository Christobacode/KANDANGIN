@extends('layouts.main')

@section('title', 'Ubah Username')
@section('body-class', 'page-ubah-username')

@section('content')
<main class="change-username-page py-5">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">
            <div class="col-lg-5 text-center">
                <div class="big-profile-icon-wrapper-square">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="big-profile-svg-curved">
                        <circle cx="8" cy="4.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.5" />
                        <path d="M 2 15 C 2 8, 14 8, 14 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex align-items-center mb-4">
                    <div class="menu-icon-wrapper me-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h2 class="form-title mb-0">Ubah Username</h2>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('profil.username.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username Saat Ini</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->username }}" disabled>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Username Baru</label>
                        <input type="text" name="new_username" class="form-control" placeholder="Masukkan Username Baru" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-auth-primary">Ubah Username</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection