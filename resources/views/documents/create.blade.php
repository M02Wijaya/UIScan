@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Pindai Dokumen Baru</h3>
                <p class="text-muted">Pilih jenis analisis dan unggah dokumen PDF Anda.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Bab 1 Pendahuluan" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">Pilih Jenis Layanan (Biaya: Rp 5.000) <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="service_type" id="service_ai" value="ai" required {{ old('service_type') == 'ai' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-info w-100 p-3 text-start rounded-3 h-100" for="service_ai">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-robot fs-4 me-2 text-info"></i>
                                            <span class="fw-bold text-dark fs-5">Deteksi AI</span>
                                        </div>
                                        <small class="text-muted d-block">Mendeteksi teks hasil *generate* mesin (ChatGPT, Gemini, dll).</small>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" class="btn-check" name="service_type" id="service_plagiarism" value="plagiarism" required {{ old('service_type') == 'plagiarism' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning w-100 p-3 text-start rounded-3 h-100" for="service_plagiarism">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-copy fs-4 me-2 text-warning"></i>
                                            <span class="fw-bold text-dark fs-5">Cek Plagiasi</span>
                                        </div>
                                        <small class="text-muted d-block">Memeriksa kesamaan teks dengan sumber dari internet (Similarity).</small>
                                    </label>
                                </div>
                            </div>
                            @error('service_type')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="file" class="form-label fw-semibold">Unggah File PDF <span class="text-danger">*</span></label>
                            <div class="p-4 border border-2 border-dashed rounded-3 text-center bg-light">
                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file" accept="application/pdf" required>
                                <small class="text-muted d-block mt-2">Maksimal ukuran file: 2MB. Hanya format PDF.</small>
                            </div>
                            @error('file')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg btn-custom shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Mulai Pemindaian (Potong Rp 5.000)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-color: #dee2e6; }
    .btn-check:checked + .btn-outline-info { background-color: rgba(13, 202, 240, 0.1); border-color: #0dcaf0; }
    .btn-check:checked + .btn-outline-warning { background-color: rgba(255, 193, 7, 0.1); border-color: #ffc107; }
</style>
@endsection