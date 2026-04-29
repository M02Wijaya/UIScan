@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold">Riwayat Pemindaian Dokumen</h3>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-bold">Daftar Dokumen dari Semua Pengguna</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3">Pengguna</th>
                            <th class="py-3">Info Dokumen</th>
                            <th class="py-3">Layanan</th>
                            <th class="py-3 text-center">Status / Hasil</th>
                            <th class="py-3">Tanggal Scan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $index => $doc)
                        <tr>
                            <td class="px-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $doc->user->name ?? 'User Dihapus' }}</div>
                                <div class="text-muted" style="font-size: 12px;">{{ $doc->user->email ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;" title="{{ $doc->title }}">
                                    {{ $doc->title }}
                                </div>
                                <div class="text-muted" style="font-size: 12px;">{{ $doc->file_name }}</div>
                            </td>
                            <td>
                                @if($doc->service_type == 'ai')
                                    <span class="badge bg-info text-dark">Deteksi AI</span>
                                @else
                                    <span class="badge bg-warning text-dark">Plagiasi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($doc->status == 'completed')
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-eye"></i> Lihat Hasil
                                    </a>
                                @elseif($doc->status == 'failed')
                                    <span class="badge bg-danger">Gagal</span>
                                @else
                                    <span class="badge bg-secondary">Diproses</span>
                                @endif
                            </td>
                            <td>{{ $doc->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-file-alt fa-3x mb-3 text-light"></i>
                                <h5>Belum ada dokumen</h5>
                                <p>Belum ada satupun dokumen yang dipindai di sistem ini.</p>
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