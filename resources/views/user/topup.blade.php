@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(request()->query('payment') === 'success')
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <strong>🎉 Pembayaran Berhasil!</strong> Saldo Anda telah ditambahkan. (Jika belum berubah, silakan refresh halaman ini).
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card bg-success text-white shadow-sm mb-4 border-0">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50 fw-semibold">Saldo Saat Ini</p>
                        <h2 class="mb-0 fw-bold">Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</h2>
                    </div>
                    <i class="fas fa-wallet fa-4x opacity-50"></i>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4 text-center">Isi Ulang Saldo</h5>
                    
                    <form action="{{ route('user.topup.process') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-semibold">Nominal Top-Up <span class="text-danger">*</span></label>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-4"><button type="button" class="btn btn-outline-secondary w-100 nominal-btn" data-val="10000">10 Ribu</button></div>
                                <div class="col-4"><button type="button" class="btn btn-outline-secondary w-100 nominal-btn" data-val="25000">25 Ribu</button></div>
                                <div class="col-4"><button type="button" class="btn btn-outline-secondary w-100 nominal-btn" data-val="50000">50 Ribu</button></div>
                                <div class="col-6"><button type="button" class="btn btn-outline-secondary w-100 nominal-btn" data-val="100000">100 Ribu</button></div>
                                <div class="col-6"><button type="button" class="btn btn-outline-secondary w-100 nominal-btn" data-val="200000">200 Ribu</button></div>
                            </div>

                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" class="form-control border-start-0 ps-0" id="amount" name="amount" placeholder="Ketik nominal..." min="10000" required>
                            </div>
                            <small class="text-muted mt-2 d-block">Minimal top-up adalah Rp 10.000</small>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg btn-custom shadow-sm">
                                <i class="fas fa-lock me-2"></i> Lanjut ke Pembayaran
                            </button>
                        </div>
                        <p class="text-center text-muted small mt-3 mb-0">
                            *Sistem akan mengarahkan Anda ke halaman pembayaran yang aman. Saldo akan bertambah otomatis setelah pembayaran berhasil.
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script untuk tombol nominal cepat
    document.querySelectorAll('.nominal-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Hapus class active dari semua tombol
            document.querySelectorAll('.nominal-btn').forEach(btn => {
                btn.classList.remove('btn-success', 'text-white');
                btn.classList.add('btn-outline-secondary');
            });
            
            // Tambahkan class active ke tombol yang diklik
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-success', 'text-white');
            
            // Masukkan nilai ke dalam input teks
            document.getElementById('amount').value = this.getAttribute('data-val');
        });
    });

    // Reset warna tombol jika user mengetik manual
    document.getElementById('amount').addEventListener('input', function() {
        document.querySelectorAll('.nominal-btn').forEach(btn => {
            btn.classList.remove('btn-success', 'text-white');
            btn.classList.add('btn-outline-secondary');
        });
    });
</script>
@endsection