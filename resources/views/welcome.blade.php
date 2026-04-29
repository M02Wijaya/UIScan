<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIScan - Deteksi AI & Plagiasi Akurat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .hero-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e0eafc 100%);
            padding: 120px 0 80px;
        }
        .feature-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .feature-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .icon-box {
            width: 80px; height: 80px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 50%; margin-bottom: 20px;
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="70">

    <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-4" href="{{ url('/') }}">
                <i class="fas fa-shield-check me-2"></i>UIScan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#fitur">Fitur Utama</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#harga">Tarif Layanan</a></li>
                    
                    @if (Route::has('login'))
                        @auth
                            @if(auth()->user()->role == 'admin')
                                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary rounded-pill px-4">Panel Admin</a>
                                </li>
                            @else
                                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">Dashboard Saya</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Masuk</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                    <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Daftar Gratis</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary text-white mb-3 px-3 py-2 rounded-pill shadow-sm">Kepercayaan Akademik Dimulai dari Sini</span>
                    <h1 class="display-4 fw-bold text-dark mb-4">Pastikan Dokumen Anda Bebas Plagiasi & Teks AI</h1>
                    <p class="lead text-muted mb-5">
                        Platform analisis dokumen terbaik untuk mahasiswa, dosen, dan profesional. Periksa orisinalitas karya tulis Anda dalam hitungan detik dengan teknologi cerdas kami.
                    </p>
                    @if (!Auth::check())
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow me-3 mb-3">Mulai Sekarang</a>
                        <a href="#fitur" class="btn btn-outline-secondary btn-lg rounded-pill px-5 mb-3">Pelajari Lebih Lanjut</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">Buka Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Layanan Unggulan Kami</h2>
                <p class="text-muted">Analisis mendalam untuk integritas dokumen Anda.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm feature-card h-100 p-4 text-center">
                        <div class="card-body">
                            <div class="icon-box bg-info bg-opacity-10 text-info">
                                <i class="fas fa-robot fa-3x"></i>
                            </div>
                            <h4 class="fw-bold mt-3">Deteksi Teks AI</h4>
                            <p class="text-muted mt-3">
                                Identifikasi apakah sebuah teks ditulis oleh manusia atau dihasilkan oleh mesin AI seperti ChatGPT, Gemini, atau Claude dengan tingkat akurasi tinggi.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm feature-card h-100 p-4 text-center">
                        <div class="card-body">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-copy fa-3x"></i>
                            </div>
                            <h4 class="fw-bold mt-3">Cek Plagiasi (Similarity)</h4>
                            <p class="text-muted mt-3">
                                Pindai dokumen Anda dengan miliaran sumber internet dan publikasi jurnal untuk menemukan indikasi penjiplakan (copy-paste) secara detail.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="harga" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Sistem Saldo yang Transparan</h2>
                <p class="text-muted">Bayar sesuai yang Anda gunakan (Pay-as-you-go). Tidak ada biaya bulanan yang mengikat.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-0 shadow rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white text-center py-4 border-0">
                            <h4 class="mb-0">Biaya Per Scan Dokumen</h4>
                        </div>
                        <div class="card-body p-5 text-center">
                            <h1 class="display-3 fw-bold text-dark mb-4">Rp 5.000<span class="fs-5 text-muted fw-normal"> /dokumen</span></h1>
                            <ul class="list-unstyled text-start mb-4 mx-auto" style="max-width: 300px;">
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Laporan PDF Detail</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Maksimal 10.000 kata</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Keamanan Privasi Dokumen</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Top-up saldo fleksibel</li>
                            </ul>
                            @if (!Auth::check())
                                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg w-100 rounded-pill">Buat Akun Sekarang</a>
                            @else
                                <a href="{{ route('user.topup') }}" class="btn btn-outline-primary btn-lg w-100 rounded-pill">Isi Saldo Saya</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} UIScan. All rights reserved.</p>
            <small class="text-muted">Sistem Deteksi AI & Plagiasi Berbasis Saldo</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>