<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Kandangin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    {{-- section masuk --}}
    <a href="{{ route('home') }}" class="btn-back-custom">
        <i class="bi bi-chevron-left"></i>
        <span class="back-text-wrapper"><span class="back-text">BACK</span></span>
    </a>

    <div class="auth-container">
        <div class="col-lg-6 d-none d-lg-flex auth-image-panel">
            <div class="auth-image-placeholder">
                <img src="{{ asset('assets/Logo_kandangin_authentication.jpg') }}" alt="Logo Kandangin" class="img-fluid">
            </div>
        </div>

        <div class="col-lg-6 col-md-12 auth-form-panel">
            <div class="form-wrapper">
                <h1 class="form-title">Masuk</h1>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    {{-- username --}}
                    @csrf <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username Anda" required>
                    </div>
                    <div class="mb-4">
                        {{-- kata sandi --}}
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan kata sandi Anda" required>
                            <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        {{-- masuk --}}
                        <button type="submit" class="btn btn-auth-primary">MASUK</button>
                    </div>
                </form>
                {{-- belum punya akun --}}
                <div class="text-center mt-4">
                    <p class="register-prompt">Belum punya akun? <a href="{{ route('register') }}" class="register-link">REGISTRASI</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>