<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Kandangin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    {{-- ragistrasi --}}
    <a href="{{ route('home') }}" class="btn-back-custom">
        <i class="bi bi-chevron-left"></i>
        {{-- button back --}}
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
                <h1 class="form-title">Registrasi</h1>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- nama depan --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Depan</label>
                            <input type="text" name="nama_depan" class="form-control" placeholder="Nama Depan" required value="{{ old('nama_depan') }}">
                        </div>
                        {{-- nama belakang --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Belakang</label>
                            <input type="text" name="nama_belakang" class="form-control" placeholder="Nama Belakang" required value="{{ old('nama_belakang') }}">
                        </div>
                    </div>
                    {{-- username --}}
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required value="{{ old('username') }}">
                    </div>
                    <div class="mb-4">
                    {{-- kata sandi --}}
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Min. 8 karakter" required>
                            <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" id="togglePassword">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                        <small class="form-text text-muted">Minimal 8 karakter.</small>
                    </div>
                    {{-- tombol registrasi --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-auth-primary">REGISTRASI</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="register-prompt">Sudah punya akun? <a href="{{ route('login') }}" class="register-link">MASUK</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ... script toggle password sama seperti login ...
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