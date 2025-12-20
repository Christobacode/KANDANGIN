@extends('layouts.main')

@section('title', 'Profil Saya - Kandangin')
@section('body-class', 'page-profil')

@section('content')
{{-- Profil Saya --}}
    <main class="account-page py-5">
        <div class="container">
            <div class="row align-items-center justify-content-center gx-lg-5">
                
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <div class="big-profile-icon-wrapper-square">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="big-profile-svg-curved">
                            <circle cx="8" cy="4.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.5" />
                            <path d="M 2 15 C 2 8, 14 8, 14 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </div>

                    {{-- Nama User dari Database --}}
                    <h4 class="fw-bold mt-4 mb-0" style="color: #0B132A;">
                        {{ Auth::user()->username }}
                    </h4>
                    {{-- Opsional: Menampilkan Email --}}
                    <p class="text-muted small">{{ Auth::user()->email }}</p>
                </div>

                <div class="col-lg-6">
                    
                    <div class="mb-4">
                        <h2 class="fw-bold" style="color: #0B132A;">HALO <span>{{ strtoupper(Auth::user()->username) }}</span>!</h2>
                    </div>

                    <h6 class="account-section-title">AKUN</h6>
                    <ul class="list-group list-group-flush account-menu">
                        
                        {{-- Pastikan Anda sudah membuat route 'profil.password' atau sesuaikan --}}
                        <li class="list-group-item">
                            <a href="{{ route('profil.password') }}" class="d-flex justify-content-between align-items-center text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-wrapper me-3"><i class="bi bi-key-fill"></i></div>
                                    <span class="menu-text">Ganti Kata Sandi</span>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        {{-- Ganti Username --}}
                        <li class="list-group-item">
                            <a href="{{ route('profil.username') }}" class="d-flex justify-content-between align-items-center text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-wrapper me-3"><i class="bi bi-person-fill"></i></div>
                                    <span class="menu-text">Ganti Username</span>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>

                        <li class="list-group-item">
                            <form action="{{ route('logout') }}" method="POST" id="form-logout-profil" class="w-100">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); document.getElementById('form-logout-profil').submit();" 
                                   class="d-flex justify-content-between align-items-center text-decoration-none">
                                    <div class="d-flex align-items-center">
                                        <div class="menu-icon-wrapper me-3"><i class="bi bi-box-arrow-right"></i></div>
                                        <span class="menu-text">Keluar</span>
                                    </div>
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </form>
                        </li>
                        {{-- modal hapus akun --}}
                        <li class="list-group-item">
                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none"
                                data-bs-toggle="modal" data-bs-target="#hapusAkunModal">
                                <div class="d-flex align-items-center">
                                    <div class="menu-icon-wrapper me-3"><i class="bi bi-x-circle-fill"></i></div>
                                    <span class="menu-text">Hapus Akun</span>
                                </div>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="hapusAkunModal" tabindex="-1" aria-labelledby="hapusAkunModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="delete-icon-wrapper mb-4"><i class="bi bi-x-lg"></i></div>
                    <h3 class="confirmation-text mb-4">Apakah Anda Yakin Ingin Menghapus Akun ?</h3>
                    <div class="d-flex justify-content-center gap-3">
                        <form action="{{ route('profil.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-confirm-action btn-confirm-yes" style="background-color: #A9A9A9; color: #fff;">YA</button>
                        </form>
                        <button type="button" class="btn btn-confirm-action btn-confirm-no" data-bs-dismiss="modal" style="background-color: #A9A9A9; color: #fff;">TIDAK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection