@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark">Riwayat Transaksi</h3>
            <p class="text-muted">Pantau semua aktivitas pemasukan (top-up) dan pengeluaran saldo Anda.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="card bg-primary text-white border-0 shadow-sm d-inline-block px-4 py-2" style="border-radius: 15px;">
                <h6 class="mb-1 small text-white-50">Sisa Saldo Saat Ini</h6>
                <h4 class="fw-bold mb-0">Rp {{ number_format(auth()->user()->wallet->balance ?? 0, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-secondary">Tanggal</th>
                            <th class="fw-bold text-secondary">Kode Trx</th>
                            <th class="fw-bold text-secondary">Keterangan</th>
                            <th class="fw-bold text-secondary">Tipe</th>
                            <th class="text-end pe-4 fw-bold text-secondary">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr class="border-bottom">
                            <td class="ps-4 text-muted small fw-bold">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $trx->trx_code }}</span>
                            </td>
                            <td class="fw-bold text-dark">{{ $trx->description }}</td>
                            <td>
                                @if($trx->type == 'kredit' || $trx->type == 'credit')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="fas fa-arrow-down me-1"></i> Masuk</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="fas fa-arrow-up me-1"></i> Keluar</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 fw-bold {{ ($trx->type == 'kredit' || $trx->type == 'credit') ? 'text-success' : 'text-danger' }}">
                                {{ ($trx->type == 'kredit' || $trx->type == 'credit') ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-receipt text-muted mb-3" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-dark mb-1">Belum ada transaksi</h6>
                                <p class="text-muted small mb-0">Anda belum melakukan top-up atau pemesanan layanan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection