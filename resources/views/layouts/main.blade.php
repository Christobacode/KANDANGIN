<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kandangin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="@yield('body-class')">

    <header class="bg-white shadow-sm sticky-top">
        <nav id="mainNav" class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/Logo_kandangin.jpg') }}" alt="Logo Kandangin" class="navbar-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">Produk</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('layanan') ? 'active' : '' }}" href="{{ route('layanan') }}">Layanan</a></li>
                        <li class="nav-item"><a class="nav-link {{ Request::is('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang</a></li>
                        
                        <li class="nav-item d-none d-lg-flex align-items-center right-group">
                            <div class="nav-divider"></div>
                            @guest
                                <a href="{{ route('register') }}" class="nav-link link-registrasi">Registrasi</a>
                                <a href="{{ route('login') }}" class="btn-masuk-custom">Masuk</a>
                            @else
                                <div class="dropdown">
                                    <a href="#" class="profile-icon-wrapper" data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="width: 20px; height: 20px; color: #fff;">
                                            <circle cx="8" cy="4.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.5" />
                                            <path d="M 2 15 C 2 8, 14 8, 14 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Halo, {{ Auth::user()->nama }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('order.history') }}">Riwayat Order</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <p class="footer-copyright">© 2025 KANDANGIN. Semua hak cipta dilindungi.</p>
                    <p class="footer-description">
                        “Dari peternak, untuk peternak menuju sistem kandang cerdas Indonesia.”
                    </p>
                    <div class="mt-1">
                        <a href="#" class="social-icon-footer"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-icon-footer"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>