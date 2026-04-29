@extends('layouts.admin') @section('admin_content')
    <div class="mb-4 mt-2">
        <h3 class="fw-bold text-dark mb-1">Dasbor Administrator</h3>
        <p class="text-muted small">Selamat datang, <strong>Administrator</strong>. Pantau dan kelola sistem UIScan.id dari sini.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 6px solid #0d6efd !important;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-bold small mb-2 text-uppercase" style="letter-spacing: 0.5px;">Total Pengguna</h6>
                        <h3 class="fw-bold text-primary mb-0">{{ $totalUsers }} User</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fas fa-user-friends text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 6px solid #198754 !important;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-bold small mb-2 text-uppercase" style="letter-spacing: 0.5px;">Pemasukan Top-Up</h6>
                        <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fas fa-chart-line text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 6px solid #ffc107 !important;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted fw-bold small mb-2 text-uppercase" style="letter-spacing: 0.5px;">Antrean Top-Up</h6>
                        <h3 class="fw-bold text-warning mb-0">{{ $allTopup->where('status', 'pending')->count() }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white border-0 py-4 px-4" style="border-radius: 15px 15px 0 0;">
            <h6 class="fw-bold mb-0 text-dark fs-5">
                <i class="fas fa-money-bill-wave text-success me-2"></i> Permintaan Persetujuan Top-Up
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless align-middle mb-0">
                    <thead class="bg-light border-bottom border-top">
                        <tr class="text-dark">
                            <th class="ps-4 py-3 fw-bold">Tanggal</th>
                            <th class="fw-bold">Nama Pengguna</th>
                            <th class="fw-bold">Nominal Top-up</th>
                            <th class="fw-bold">Status</th>
                            <th class="text-center pe-4 fw-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allTopup as $topup)
                        <tr class="border-bottom">
                            <td class="ps-4 text-muted small fw-bold">{{ $topup->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $topup->user->name }}</div>
                                <div class="small text-muted">{{ $topup->user->email }}</div>
                            </td>
                            <td class="fw-bold text-dark">Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($topup->status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu</span>
                                @elseif($topup->status === 'approved')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Berhasil</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                @if($topup->status === 'pending')
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('admin.topup.approve', $topup->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 px-3 fw-bold"><i class="fas fa-check me-1"></i></button>
                                        </form>
                                        <form action="{{ route('admin.topup.reject', $topup->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3 fw-bold"><i class="fas fa-times me-1"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small fw-bold">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <h6 class="fw-bold text-dark mb-1">Tidak ada antrean</h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection