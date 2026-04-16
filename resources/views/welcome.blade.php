<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIScan - Pengecekan Orisinalitas Dokumen</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
        <h1 class="display-3 fw-bold text-primary mb-3">UIScan</h1>
        <p class="lead mb-4 text-secondary">Sistem Pengecekan Orisinalitas Dokumen berbasis Cosine Similarity & Integrasi AI</p>
        
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary btn-lg px-4 shadow-sm">Masuk ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-2 shadow-sm">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4 shadow-sm">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</body>
</html>