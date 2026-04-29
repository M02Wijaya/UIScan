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
                        <h4 class="fw-bold text-success mb-0">Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</h4>
                    </div>

                    <hr class="mt-4">
                    
                    <div class="text-start mt-4">
                        <a href="{{ route('home') }}" class="sidebar-menu">
                            <i class="fas fa-layer-group sidebar-icon"></i> Layanan
                        </a>
                        <a href="{{ route('documents.index') }}" class="sidebar-menu">
                            <i class="fas fa-history sidebar-icon"></i> Riwayat Pesanan
                        </a>
                        <a href="{{ route('user.topup') }}" class="sidebar-menu">
                            <i class="fas fa-wallet sidebar-icon"></i> Saldo & Topup
                        </a>
                        <a href="{{ route('profile.index') }}" class="sidebar-menu active">
                            <i class="fas fa-user-cog sidebar-icon"></i> Profil
                        </a>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu text-danger fw-bold mt-2 border-top pt-3">
                                <i class="fas fa-user-shield sidebar-icon"></i> Panel Admin
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="mb-4 d-flex justify-content-between align-items-end">
                <div>
                    <h3 class="fw-bold mb-1"><i class="fas fa-user-cog text-primary"></i> Pengaturan Profil</h3>
                    <p class="text-muted mb-0">Kelola informasi data diri dan akun Anda di sini.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                        <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px; font-size: 30px; background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="ms-4">
                            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                            <span class="badge bg-light text-dark border"><i class="fas fa-envelope text-muted"></i> {{ $user->email }}</span>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger ms-1"><i class="fas fa-user-shield"></i> Administrator</span>
                            @else
                                <span class="badge bg-success ms-1"><i class="fas fa-user"></i> Pengguna Reguler</span>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="fw-bold mb-3">Informasi Pribadi</h5>
                        
                        <div class="mb-4">
                            <label for="name" class="form-label text-muted small fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-muted small fw-bold">Alamat Email (Tidak bisa diubah)</label>
                            <input type="email" class="form-control bg-light text-muted" id="email" value="{{ $user->email }}" readonly disabled>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">Tanggal Bergabung</label>
                            <input type="text" class="form-control bg-light text-muted" value="{{ $user->created_at->format('d F Y') }}" readonly disabled>
                        </div>

                        <hr class="my-4">

                        <div class="text-end">
                            <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background-color: #6f42c1;">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection