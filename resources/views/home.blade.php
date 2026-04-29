@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white overflow-hidden shadow-sm">
                <div class="card-body p-4 position-relative">
                    <div style="position: absolute; top: -20px; right: -20px; opacity: 0.1;">
                        <i class="fas fa-shield-check" style="font-size: 150px;"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mb-0 text-white-50">Selamat datang di dashboard analitik dokumen Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card h-100 border-0 border-start border-4 border-success">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 12px;">Saldo Dompet</p>
                        <h2 class="fw-bold mb-0 text-dark">Rp {{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('user.topup') }}" class="btn btn-sm btn-outline-success btn-custom w-100">
                        <i class="fas fa-plus me-1"></i> Isi Saldo
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 border-0 border-start border-4 border-info">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 12px;">Dokumen Dianalisis</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ \App\Models\Document::where('user_id', Auth::id())->count() }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('documents.create') }}" class="btn btn-sm btn-info text-white btn-custom w-100 shadow-sm">
                        <i class="fas fa-search me-1"></i> Pindai Dokumen Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i>Aktivitas Terakhir</h6>
                    <a href="{{ route('documents.index') }}" class="text-decoration-none" style="font-size: 14px;">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @php
                        $recentDocs = \App\Models\Document::where('user_id', Auth::id())->latest()->take(3)->get();
                    @endphp
                    
                    @if($recentDocs->count() > 0)
                        <div class="list-group list-group-flush rounded-bottom">
                            @foreach($recentDocs as $doc)
                                <a href="{{ route('documents.show', $doc->id) }}" class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-2 rounded me-3 text-center" style="width: 45px; height: 45px;">
                                            <i class="fas {{ $doc->service_type == 'ai' ? 'fa-robot text-info' : 'fa-copy text-warning' }} fs-5 mt-1"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $doc->title }}</h6>
                                            <small class="text-muted">{{ $doc->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <span class="badge {{ $doc->status == 'completed' ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                        {{ ucfirst($doc->status) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="No Data" width="100" class="mb-3 opacity-50">
                            <h5 class="text-muted fw-bold">Belum Ada Dokumen</h5>
                            <p class="text-muted mb-4">Anda belum memindai dokumen apapun.</p>
                            <a href="{{ route('documents.create') }}" class="btn btn-primary btn-custom shadow-sm">Pindai Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection