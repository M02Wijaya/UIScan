@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white text-center pt-5 pb-2 border-0">
                    <div class="mb-3">
                        <i class="fas fa-rocket" style="font-size: 50px; color: #20c997;"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #6f42c1;">Buat Akun Baru</h3>
                    <p class="text-muted mb-0">Bergabunglah dan pastikan dokumen Anda orisinal.</p>
                </div>

                <div class="card-body p-4 p-md-5 pt-3">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold text-muted small">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                <input id="name" type="text" class="form-control bg-light border-start-0 py-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Contoh: Budi Santoso">
                            </div>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-muted small">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold text-muted small">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold text-muted small">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-circle text-muted"></i></span>
                                <input id="password-confirm" type="password" class="form-control bg-light border-start-0 py-2" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi">
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn text-white py-2 rounded-pill fw-bold shadow-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);">
                                Daftar Akun <i class="fas fa-user-plus ms-1"></i>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted small mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #fd7e14;">Masuk di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection