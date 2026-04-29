@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Riwayat Transaksi</h4>
                    <p class="text-muted small mb-0">Pantau semua aktivitas saldo wallet Anda di sini.</p>
                </div>
                <a href="{{ route('user.topup') }}" class="btn btn-success btn-sm shadow-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Top Up Lagi
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="py-3">Kode / Deskripsi</th>
                                    <th class="py-3">Tipe</th>
                                    <th class="py-3">Nominal</th>
                                    <th class="px-4 py-3 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $trx)
                                    <tr>
                                        <td class="px-4 py-3 text-muted small">
                                            {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}<br>
                                            <span class="opacity-75">{{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }} WIB</span>
                                        </td>
                                        <td class="py-3">
                                            <span class="fw-semibold d-block text-dark">{{ $trx->trx_code }}</span>
                                            <small class="text-muted">{{ $trx->description }}</small>
                                        </td>
                                        <td class="py-3">
                                            @if($trx->type == 'kredit')
                                                <span class="badge bg-soft-success text-success border border-success border-opacity-25 rounded-pill px-2">Top Up</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger border border-danger border-opacity-25 rounded-pill px-2">Layanan</span>
                                            @endif
                                        </td>
                                        <td class="py-3 fw-bold">
                                            @if($trx->type == 'kredit')
                                                <span class="text-success">+ Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-danger">- Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-end">
                                            @if($trx->status == 'success')
                                                <span class="text-success"><i class="fas fa-check-circle me-1"></i>Berhasil</span>
                                            @elseif($trx->status == 'pending')
                                                <span class="text-warning"><i class="fas fa-clock me-1"></i>Tertunda</span>
                                            @else
                                                <span class="text-danger"><i class="fas fa-times-circle me-1"></i>Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-receipt fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0 fw-medium">Belum ada riwayat transaksi.</p>
                                            <small>Lakukan top up atau gunakan layanan kami untuk melihat riwayat.</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $transactions->links() }}
            </div>

        </div>
    </div>
</div>

<style>
    /* Tambahan style agar tampilan badge lebih estetik */
    .bg-soft-success { background-color: #e8f5e9; }
    .bg-soft-danger { background-color: #ffebee; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .fw-semibold { font-weight: 600 !important; }
</style>
@endsection