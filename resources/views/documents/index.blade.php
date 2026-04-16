@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold"><i class="fas fa-history" style="color: #6f42c1;"></i> Riwayat Pesanan Saya</h3>
                <a href="{{ route('home') }}" class="btn text-white rounded-pill px-4 shadow-sm" style="background-color: #6f42c1;">
                    + Buat Pesanan Baru
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th class="py-3 px-4 fw-semibold border-bottom-0">No. Pesanan</th>
                                <th class="py-3 fw-semibold border-bottom-0">Layanan</th>
                                <th class="py-3 fw-semibold border-bottom-0">Detail Dokumen</th>
                                <th class="py-3 fw-semibold border-bottom-0">Biaya</th>
                                <th class="py-3 fw-semibold border-bottom-0">Status</th>
                                <th class="py-3 text-center fw-semibold border-bottom-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse ($documents as $doc)
                                <tr>
                                    <td class="px-4">
                                        <span class="fw-bold text-dark">{{ $doc->ref_number ?? 'UISCAN-LAMA' }}</span>
                                    </td>
                                    
                                    <td>
                                        @if($doc->service_type == 'ai')
                                            <span class="badge bg-info text-dark px-2 py-1 rounded-pill"><i class="fas fa-robot"></i> Deteksi AI</span>
                                        @else
                                            <span class="badge text-white px-2 py-1 rounded-pill" style="background-color: #fd7e14;"><i class="fas fa-file-alt"></i> Plagiarisme</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark mb-1">{{ $doc->title }}</div>
                                        <div class="text-muted small">
                                            <i class="far fa-clock"></i> {{ $doc->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark">Rp {{ number_format($doc->price, 0, ',', '.') }}</div>
                                        <span class="badge bg-success mt-1" style="font-size: 10px;"><i class="fas fa-check"></i> {{ $doc->payment_status }}</span>
                                    </td>
                                    
                                    <td>
                                        @if($doc->status == 'pending')
                                            <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">
                                                <i class="fas fa-spinner fa-spin"></i> In Process
                                            </span>
                                        @elseif($doc->status == 'scanned')
                                            <span class="badge bg-success px-2 py-1 rounded-pill">
                                                <i class="fas fa-check-circle"></i> Done
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($doc->status) }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($doc->status == 'pending')
                                            <a href="{{ route('documents.scan', $doc->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 shadow-sm" title="Proses Dokumen">
                                                <i class="fas fa-cogs"></i> Proses
                                            </a>
                                        @elseif($doc->status == 'scanned')
                                            <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm text-white rounded-pill px-3 shadow-sm" style="background-color: #6f42c1;" title="Lihat Hasil">
                                                <i class="fas fa-eye"></i> Hasil
                                            </a>
                                        @endif
                                        
                                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus riwayat dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill shadow-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open mb-3" style="font-size: 48px; color: #e9ecef;"></i>
                                            <h5>Belum ada riwayat pesanan.</h5>
                                            <p class="small">Silakan buat pesanan baru untuk mulai mengecek dokumen Anda.</p>
                                        </div>
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
@endsection