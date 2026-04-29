@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white text-center pt-5 pb-2 border-0">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt" style="font-size: 50px; color: #fd7e14;"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #6f42c1;">Selamat Datang!</h3>
                    <p class="text-muted mb-0">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                <div class="card-body p-4 p-md-5 pt-3">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-muted small">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-start-0 py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Masukkan email Anda">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-bold text-muted small">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small" style="color: #6f42c1;" href="{{ route('password.request') }}">Lupa Sandi?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-start-0 py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn text-white py-2 rounded-pill fw-bold shadow-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);">
                                Masuk Sekarang <i class="fas fa-sign-in-alt ms-1"></i>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted small mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #fd7e14;">Daftar di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection