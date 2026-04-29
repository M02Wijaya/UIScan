<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UIScan') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            color: #333;
        }
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9) !important;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .btn-custom {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 20px;
            transition: transform 0.2s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                    <i class="fas fa-shield-check me-2"></i>UIScan
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(auth()->user()->role == 'admin')
                                <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">Pengguna</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.documents') }}">Riwayat Scan</a></li>
                            @else
                                <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('home') }}">Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('documents.index') }}">Dokumen Saya</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('user.topup') }}">Isi Saldo</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('user.history') }}">Riwayat</a></li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-primary btn-custom ms-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user()->role != 'admin')
                            <li class="nav-item me-2">
                                <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                                    <i class="fas fa-wallet me-1"></i> Rp {{ number_format(auth()->user()->wallet->balance ?? 0, 0, ',', '.') }}
                                </span>
                            </li>
                            @endif
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="Avatar" class="rounded-circle me-1" width="30">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item py-2" href="{{ route('profile.index') }}">
                                        <i class="fas fa-user-circle me-2 text-muted"></i> Profil Saya
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>x    