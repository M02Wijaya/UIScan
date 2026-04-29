@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-4 mb-4">
            
            <div class="card shadow-sm border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%); color: white;">
                <div class="card-body p-4">
                    <h6 class="text-white-50 fw-bold mb-1"><i class="fas fa-wallet"></i> Saldo Tersedia</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</h2>
                    <div class="mt-3 small text-white-50">
                        Gunakan saldo ini untuk membayar layanan Cek Plagiasi & Deteksi AI.
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-plus-circle text-success"></i> Isi Ulang Saldo</h5>
                    
                    <form action="{{ route('wallet.topup') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Nominal Top Up (Rp)</label>
                            <input type="number" name="amount" class="form-control bg-light" placeholder="Min. 10000" min="10000" required>
                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill shadow-sm">Ajukan Top Up</button>
                    </form>
                    
                    <div class="alert alert-warning mt-3 mb-0 small p-2 border-0 rounded-3">
                        <i class="fas fa-info-circle"></i> Setelah klik Ajukan, status akan Pending. Admin akan memverifikasi pembayaran Anda.
                    </div>
                </div>
            </div>
            
            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 rounded-pill mt-3"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-exchange-alt text-primary"></i> Riwayat Transaksi</h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 p-2 small" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.75rem;"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="py-2 border-bottom-0">Kode & Waktu</th>
                                    <th class="py-2 border-bottom-0">Keterangan</th>
                                    <th class="py-2 border-bottom-0">Nominal</th>
                                    <th class="py-2 border-bottom-0 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @forelse($transactions as $trx)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $trx->trx_code }}</span><br>
                                        <span class="text-muted" style="font-size: 11px;">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                                    </td>
                                    <td>
                                        {{ $trx->description }}
                                    </td>
                                    <td>
                                        @if($trx->type == 'kredit')
                                            <span class="text-success fw-bold">+ Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-danger fw-bold">- Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($trx->status == 'success')
                                            <span class="badge bg-success rounded-pill px-2">Success</span>
                                        @elseif($trx->status == 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-2">Pending</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-2">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection