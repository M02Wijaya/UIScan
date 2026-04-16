@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">
                    <i class="fas fa-cloud-upload-alt" style="color: #6f42c1;"></i> Form Upload Dokumen
                </h3>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    
                    @php
                        $serviceType = request('type', 'plagiarism');
                        $serviceName = $serviceType == 'ai' ? 'Cek Deteksi AI' : 'Cek Plagiarisme';
                        $price = $serviceType == 'ai' ? '10.000' : '15.000'; // Simulasi harga
                    @endphp

                    <div class="alert alert-info border-0 rounded-3 mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle fs-4 me-3"></i>
                        <div>
                            <strong>Layanan Pilihan Anda:</strong> {{ $serviceName }}<br>
                            <small>Pastikan dokumen yang Anda unggah sudah benar.</small>
                        </div>
                    </div>

                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="service_type" value="{{ $serviceType }}">
                        <input type="hidden" name="price" value="{{ str_replace('.', '', $price) }}">

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Judul Dokumen</label>
                            <input type="text" class="form-control bg-light" id="title" name="title" placeholder="Contoh: Bab 1 Skripsi Manajemen" required>
                        </div>

                        <div class="mb-3">
                            <label for="document_file" class="form-label fw-bold">Upload File (PDF / Word)</label>
                            <input class="form-control bg-light" type="file" id="document_file" name="document_file" accept=".pdf,.doc,.docx" required>
                            <div class="form-text text-danger small">* Maksimal ukuran file: 10MB.</div>
                        </div>

                        <div class="mb-3">
                            <label for="whatsapp_number" class="form-label fw-bold">Nomor WhatsApp Aktif</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fab fa-whatsapp text-success"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" id="whatsapp_number" name="whatsapp_number" placeholder="Contoh: 081234567890" required>
                            </div>
                            <div class="form-text small">Kami akan mengirimkan notifikasi dan file hasil via WhatsApp.</div>
                        </div>

                        @if($serviceType == 'plagiarism')
                            <div class="mb-4 p-3 border rounded-3 bg-light">
                                <label class="form-label fw-bold mb-2">Filter Tambahan (Standar Kampus)</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="exclude_quotes" name="exclude_quotes" value="1" checked>
                                    <label class="form-check-label" for="exclude_quotes">
                                        Kecualikan Kutipan (Exclude Quotes)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="exclude_bibliography" name="exclude_bibliography" value="1" checked>
                                    <label class="form-check-label" for="exclude_bibliography">
                                        Kecualikan Daftar Pustaka (Exclude Bibliography)
                                    </label>
                                </div>
                            </div>
                        @endif

                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                                <span class="text-muted small fw-bold">Total Tagihan:</span><br>
                                <h3 class="fw-bold text-success mb-0">Rp {{ $price }}</h3>
                            </div>
                            <button type="submit" class="btn text-white btn-lg rounded-pill px-4 shadow" style="background-color: #6f42c1;">
                                Proses Sekarang <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection