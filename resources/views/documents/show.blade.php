@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold"><i class="fas fa-file-contract text-primary"></i> Laporan Analisis Dokumen</h3>
        <div>
            <a href="{{ route('documents.pdf', $document->id) }}" class="btn btn-danger me-2 shadow-sm"><i class="fas fa-file-pdf"></i> Download Laporan PDF</a>
            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0">{{ $document->title }}</h5>
                    <p class="text-muted small mb-0">File Asli: {{ $document->file_name }}</p>
                </div>
                <hr>
                <div class="card-body pt-0" style="font-size: 1.05rem; line-height: 2; color:#333;">
                    @php
                        // Memberikan warna buatan pada teks untuk simulasi
                        $text = htmlspecialchars($document->extracted_text);
                        $highlighted = str_replace(
                            "membandingkannya dengan miliaran database jurnal, artikel internet, dan publikasi ilmiah.", 
                            "<mark class='bg-danger text-white px-1 rounded'>membandingkannya dengan miliaran database jurnal, artikel internet, dan publikasi ilmiah. <sup class='fw-bold'>1</sup></mark>", 
                            $text
                        );
                        $highlighted = str_replace(
                            "Penelitian ini bertujuan untuk mengukur efektivitas sistem tersebut", 
                            "<mark class='bg-warning px-1 rounded'>Penelitian ini bertujuan untuk mengukur efektivitas sistem tersebut <sup class='fw-bold'>2</sup></mark>", 
                            $highlighted
                        );
                    @endphp
                    
                    <p style="white-space: pre-wrap;">{!! $highlighted !!}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            
            <div class="card shadow-sm border-0 mb-3 bg-light">
                <div class="card-body p-3 small text-muted">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span>WORD COUNT</span>
                        <span class="fw-bold text-dark">{{ $details['word_count'] ?? 0 }} Words</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span>TIME SUBMITTED</span>
                        <span class="fw-bold text-dark">{{ $document->updated_at->format('d-M-Y H:i A') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>PAPER ID</span>
                        <span class="fw-bold text-dark">{{ $details['paper_id'] ?? '123456789' }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body text-center py-4">
                    @if($document->service_type == 'plagiarism')
                        <h6 class="text-muted fw-bold mb-1">ORIGINALITY REPORT (SIMILARITY INDEX)</h6>
                        <h1 class="display-3 fw-bold" style="color: #dc3545;">{{ $scanResult->similarity_score }}%</h1>
                        
                        <div class="d-flex justify-content-center text-muted small mt-3">
                            <div class="mx-3">
                                <h5 class="fw-bold text-dark mb-0">{{ $details['internet_sources'] ?? 0 }}%</h5>
                                Internet Sources
                            </div>
                            <div class="mx-3 border-start border-end px-3">
                                <h5 class="fw-bold text-dark mb-0">{{ $details['publications'] ?? 0 }}%</h5>
                                Publications
                            </div>
                            <div class="mx-3">
                                <h5 class="fw-bold text-dark mb-0">{{ $details['student_papers'] ?? 0 }}%</h5>
                                Student Papers
                            </div>
                        </div>
                    @else
                        <h6 class="text-muted fw-bold mb-1">AI DETECTION PROBABILITY</h6>
                        <h1 class="display-3 fw-bold" style="color: #0dcaf0;">{{ $scanResult->ai_probability }}%</h1>
                        <p class="text-muted small">Kemungkinan teks ditulis oleh AI (ChatGPT, dll)</p>
                    @endif
                </div>
            </div>

            @if($document->service_type == 'plagiarism')
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">PRIMARY SOURCES</div>
                <ul class="list-group list-group-flush">
                    @if(isset($details['sources']))
                        @foreach($details['sources'] as $index => $source)
                        <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                            <div class="ms-2 me-auto small">
                                <div class="fw-bold">
                                    <span class="badge {{ $index == 0 ? 'bg-danger' : 'bg-warning text-dark' }} me-1">{{ $index + 1 }}</span>
                                    {{ $source['name'] }}
                                </div>
                                <span class="text-muted">{{ $source['type'] }}</span>
                            </div>
                            <span class="fw-bold fs-5">{{ $source['percentage'] }}%</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            @endif

            <div class="card shadow-sm border-0 bg-light small">
                <div class="card-body p-3 fw-bold text-muted text-uppercase">
                    <div class="mb-1">Exclude Quotes <span class="float-end text-dark">{{ $document->exclude_quotes ? 'ON' : 'OFF' }}</span></div>
                    <div class="mb-1">Exclude Bibliography <span class="float-end text-dark">{{ $document->exclude_bibliography ? 'ON' : 'OFF' }}</span></div>
                    <div>Exclude Sources <span class="float-end text-dark">OFF</span></div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection