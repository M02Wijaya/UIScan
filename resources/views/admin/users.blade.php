@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold">Manajemen Pengguna</h3>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-bold">Daftar Pengguna Terdaftar</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3">Informasi Pengguna</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Sisa Saldo</th>
                            <th class="py-3">Tanggal Daftar</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="px-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="text-muted" style="font-size: 12px;">
                                    <i class="fas fa-phone-alt me-1"></i> {{ $user->whatsapp_number ?? 'Belum diset' }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    Rp {{ number_format($user->wallet->balance ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" onclick="alert('Fitur edit pengguna segera hadir!')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 text-light"></i>
                                <h5>Belum ada pengguna</h5>
                                <p>Saat ini belum ada pengguna yang mendaftar selain admin.</p>
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