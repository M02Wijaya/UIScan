@extends('layouts.app') @section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold">Laporan Analisis Dokumen</h3>
            <div>
                <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-primary">{{ $document->title }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Nama File</div>
                        <div class="col-sm-8 fw-semibold">{{ $document->file_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">ID Laporan</div>
                        <div class="col-sm-8">{{ $document->ref_number }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Jumlah Kata</div>
                        <div class="col-sm-8">{{ number_format($details['word_count'] ?? 0) }} kata</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Tanggal Scan</div>
                        <div class="col-sm-8">{{ $document->updated_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-muted">Jenis Layanan</div>
                        <div class="col-sm-8">
                            @if($document->service_type == 'ai')
                                <span class="badge bg-info text-dark">Deteksi AI</span>
                            @else
                                <span class="badge bg-warning text-dark">Cek Plagiasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Pratinjau Teks Dokumen</h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                    <p style="font-size: 14px; line-height: 1.8; text-align: justify;">
                        {{ $document->extracted_text }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4 border-0 text-center">
                <div class="card-body py-5">
                    @if($document->service_type == 'ai')
                        <h5 class="text-muted mb-3">Probabilitas AI</h5>
                        @php
                            $aiColor = $scanResult->ai_probability > 50 ? 'text-danger' : 'text-success';
                        @endphp
                        <h1 class="display-1 fw-bold {{ $aiColor }} mb-0">
                            {{ $scanResult->ai_probability }}%
                        </h1>
                        <p class="text-muted mt-2">
                            {{ $scanResult->ai_probability > 50 ? 'Kemungkinan besar ditulis oleh AI.' : 'Terlihat seperti tulisan manusia.' }}
                        </p>
                    @else
                        <h5 class="text-muted mb-3">Indeks Plagiasi</h5>
                        @php
                            $plagColor = $scanResult->similarity_score > 20 ? 'text-danger' : 'text-success';
                        @endphp
                        <h1 class="display-1 fw-bold {{ $plagColor }} mb-0">
                            {{ $scanResult->similarity_score }}%
                        </h1>
                        <p class="text-muted mt-2">Ditemukan kesamaan dengan sumber internet.</p>
                    @endif
                </div>
            </div>

            @if($document->service_type == 'plagiarism')
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold">Sumber Kesamaan Teks</h6>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($details['sources'] ?? [] as $source)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold" style="font-size: 14px;">
                                    <a href="{{ $source['url'] ?? '#' }}" target="_blank" class="text-decoration-none text-dark">
                                        {{ $source['name'] ?? 'Sumber Internet' }}
                                    </a>
                                </div>
                                <span class="text-muted" style="font-size: 12px;">{{ $source['type'] ?? 'Internet' }}</span>
                            </div>
                            <span class="badge bg-danger rounded-pill">{{ $source['percentage'] ?? 0 }}%</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted">
                            Tidak ditemukan indikasi plagiasi di internet. Bagus!
                        </li>
                    @endforelse
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection