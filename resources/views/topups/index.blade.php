@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold text-dark">Top Up Saldo</h3>
            <p class="text-muted">Isi ulang saldo Anda menggunakan QRIS, GoPay, atau Virtual Account Bank.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="card bg-primary text-white border-0 shadow-sm d-inline-block px-4 py-2" style="border-radius: 15px;">
                <h6 class="mb-1 small text-white-50">Saldo Saat Ini</h6>
                <h4 class="fw-bold mb-0">Rp {{ number_format(auth()->user()->wallet->balance ?? 0, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Nominal Isi Ulang</h5>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('user.topup.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Pilih atau Ketik Nominal (Min. Rp 10.000)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-dark fw-bold">Rp</span>
                                <input type="number" name="amount" class="form-control border-start-0 ps-0" placeholder="Contoh: 50000" min="10000" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-pill">
                            Lanjut ke Pembayaran <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 fw-bold text-secondary">Tanggal</th>
                                    <th class="fw-bold text-secondary">Nominal</th>
                                    <th class="fw-bold text-secondary">Status</th>
                                    <th class="pe-4 fw-bold text-secondary text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topups as $topup)
                                <tr class="border-bottom">
                                    <td class="ps-4 text-muted small fw-bold">{{ $topup->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($topup->status == 'success')
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">Berhasil</span>
                                        @elseif($topup->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-1 rounded-pill">Menunggu</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill">Gagal</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($topup->status == 'pending' && $topup->snap_token)
                                            <button onclick="payMidtrans('{{ $topup->snap_token }}')" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold shadow-sm">
                                                Bayar <i class="fas fa-credit-card ms-1"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <h6 class="fw-bold text-dark mb-1">Belum ada riwayat Top-Up</h6>
                                    </td>
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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    // Fungsi untuk memanggil pop-up Midtrans saat tombol bayar diklik
    function payMidtrans(snapToken) {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                alert("Pembayaran berhasil! Saldo akan segera masuk.");
                window.location.reload();
            },
            onPending: function(result) {
                alert("Menunggu pembayaran Anda!");
                window.location.reload();
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
                window.location.reload();
            },
            onClose: function() {
                console.log('User menutup pop-up tanpa menyelesaikan pembayaran');
            }
        });
    }

    // Jika user baru saja membuat request Top Up, langsung munculkan pop-up nya otomatis!
    @if(session('snapToken'))
        payMidtrans('{{ session('snapToken') }}');
    @endif
</script>
@endsection