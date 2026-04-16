<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>UIScan.id - Cek Plagiasi & AI</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            padding: 15px 0;
        }
        .brand-text {
            color: #fd7e14; /* Warna orange mirip referensi */
            font-weight: 700;
            font-size: 24px;
        }
        .announcement-bar {
            background-color: #6f42c1; /* Warna ungu referensi */
            color: white;
            padding: 8px 0;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }
        /* Style untuk Sidebar Link (Persiapan untuk Step 3) */
        .sidebar-menu {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            text-decoration: none;
            color: #333;
            display: block;
            transition: all 0.3s;
        }
        .sidebar-menu:hover, .sidebar-menu.active {
            border-left: 4px solid #6f42c1;
            background: #f8f9fa;
        }
        .sidebar-icon {
            width: 30px;
            color: #555;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <i class="fas fa-shield-alt fs-3 me-2" style="color: #fd7e14;"></i>
                    <span class="brand-text">UIScan.id</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
                        <li class="nav-item">
                            <a class="nav-link text-dark mx-2" href="#">Cek Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark mx-2" href="#">Cara Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark mx-2" href="#">Jasa Kami <i class="fas fa-caret-down"></i></a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-warning text-white fw-bold px-4 ms-2" style="background-color: #fd7e14; border:none;" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle fs-4 me-2" style="color: #6f42c1;"></i>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item py-2" href="{{ route('home') }}">
                                        <i class="fas fa-tachometer-alt me-2 text-muted"></i> Dashboard
                                    </a>
                                    <hr class="dropdown-divider">
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

        <div class="announcement-bar">
            <i class="fas fa-fire me-1"></i> <i class="fas fa-bullhorn me-1"></i> INFO PENTING ‼️ KLIK TOMBOL AKTIFKAN NOTIFIKASI WHATSAPP ATAU DOWNLOAD FILE KAMU DI HALAMAN CEK PESANAN SEBELUM 24 JAM!
        </div>

        <main class="py-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>