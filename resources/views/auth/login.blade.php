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

    <div class="auth-container">
        <div class="auth-image-panel col-md-6 d-none d-md-flex">
            <div class="text-center">
                <img src="{{ asset('assets/Logo_kandangin.jpg') }}" alt="Logo" style="width: 200px; border-radius: 50%; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <h2 class="mt-4 fw-bold text-secondary">KANDANGIN</h2>
            </div>
        </div>

        <div class="auth-form-panel col-md-6 col-12 bg-white relative">
            
            <a href="{{ route('home') }}" class="btn-back-custom">
                <i class="bi bi-chevron-left"></i> Kembali
            </a>

            <div class="form-wrapper">
                <h1 class="form-title">Masuk</h1>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukan email kamu" required value="{{ old('email') }}">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="Masukan kata sandi kamu" required>
                            <span class="input-group-text"><i class="bi bi-eye-slash"></i></span>
                        </div>
                        <div class="text-end mt-2">
                            <a href="#" class="forgot-password-link">Lupa Kata Sandi?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-auth-primary w-100 mb-3">Masuk</button>
                    
                    <button type="button" class="btn btn-google w-100">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="G" width="20" class="google-icon">
                        Masuk dengan Google
                    </button>
                </form>

                <p class="register-prompt text-center mt-4">
                    Belum punya akun? <a href="{{ route('register') }}" class="register-link">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>