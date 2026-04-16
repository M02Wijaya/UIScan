@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; font-size: 24px; background-color: #6f42c1;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-0">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                    
                    <div class="bg-light rounded-3 p-3 mt-3 text-start border">
                        <div class="text-muted small fw-bold mb-1"><i class="fas fa-wallet text-success"></i> Saldo Aktif</div>
                        <h4 class="fw-bold text-success mb-0">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</h4>
                    </div>

                    <hr class="mt-4">
                    
                    <div class="text-start mt-4">
                        <a href="{{ route('home') }}" class="sidebar-menu active">
                            <i class="fas fa-layer-group sidebar-icon"></i> Layanan
                        </a>
                        <a href="{{ route('documents.index') }}" class="sidebar-menu">
                            <i class="fas fa-history sidebar-icon"></i> Riwayat Pesanan
                        </a>
                        <a href="#" class="sidebar-menu">
                            <i class="fas fa-wallet sidebar-icon"></i> Saldo & Topup
                        </a>
                        <a href="#" class="sidebar-menu">
                            <i class="fas fa-user-cog sidebar-icon"></i> Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="mb-4 d-flex justify-content-between align-items-end">
                <div>
                    <h3 class="fw-bold mb-1">Pilih Layanan</h3>
                    <p class="text-muted mb-0">Silakan pilih layanan scan dokumen yang Anda butuhkan.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-3 text-center">
                                <i class="fas fa-file-alt" style="font-size: 50px; color: #fd7e14;"></i>
                            </div>
                            <h5 class="fw-bold text-center">Cek Plagiarisme</h5>
                            <p class="text-muted small text-center mb-4">
                                Cek tingkat kemiripan dokumen dengan database global. Dilengkapi fitur filter daftar pustaka dan kutipan (mirip Turnitin).
                            </p>
                            <div class="mt-auto text-center">
                                <p class="fw-bold text-success mb-2 small"><i class="fas fa-check-circle"></i> Rp 15.000 / Dokumen</p>
                                <a href="{{ route('documents.create', ['type' => 'plagiarism']) }}" class="btn text-white w-100 rounded-pill fw-bold" style="background-color: #6f42c1;">
                                    Buat Pesanan Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-3 text-center">
                                <i class="fas fa-robot text-info" style="font-size: 50px;"></i>
                            </div>
                            <h5 class="fw-bold text-center">Cek Deteksi Teks AI</h5>
                            <p class="text-muted small text-center mb-4">
                                Ketahui apakah tulisan pada dokumen dihasilkan oleh kecerdasan buatan (ChatGPT, Gemini, Claude, dll).
                            </p>
                            <div class="mt-auto text-center">
                                <p class="fw-bold text-info mb-2 small"><i class="fas fa-check-circle"></i> Rp 10.000 / Dokumen</p>
                                <a href="{{ route('documents.create', ['type' => 'ai']) }}" class="btn btn-outline-info text-dark border-2 w-100 rounded-pill fw-bold">
                                    Buat Pesanan Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</div>

<style>
    .transition-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection