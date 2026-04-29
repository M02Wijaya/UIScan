<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Analisis - {{ $document->ref_number }}</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 14px; 
            color: #333; 
            line-height: 1.5; 
        }
        .header { 
            text-align: center; 
            border-bottom: 2px solid #0d6efd; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .header h1 { 
            margin: 0; 
            color: #0d6efd; 
            font-size: 24px; 
        }
        .header p { 
            margin: 5px 0 0; 
            color: #777; 
            font-size: 12px; 
        }
        .summary-box { 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin-bottom: 20px; 
            background-color: #f8f9fa; 
            border-radius: 5px;
        }
        .summary-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .summary-table td { 
            padding: 5px 10px; 
            vertical-align: top; 
        }
        .score-box { 
            text-align: center; 
            padding: 15px; 
            background-color: #fff; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
        }
        .score-title { 
            font-size: 14px; 
            font-weight: bold; 
            color: #555; 
        }
        .score-value { 
            font-size: 40px; 
            font-weight: bold; 
            margin: 5px 0; 
        }
        .text-danger { color: #dc3545; }
        .text-success { color: #198754; }
        .section-title { 
            font-size: 16px; 
            border-bottom: 1px solid #ddd; 
            padding-bottom: 5px; 
            margin-bottom: 10px; 
            margin-top: 20px; 
            font-weight: bold;
            color: #333; 
        }
        .source-list { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            font-size: 12px;
        }
        .source-list th, .source-list td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        .source-list th { 
            background-color: #f2f2f2; 
        }
        .source-list a {
            color: #0d6efd;
            text-decoration: none;
        }
        .text-content { 
            text-align: justify; 
            font-size: 12px; 
            line-height: 1.6; 
            background-color: #fdfdfd;
            border: 1px solid #eee;
            padding: 15px;
        }
        .footer { 
            position: fixed; 
            bottom: -30px; 
            left: 0px; 
            right: 0px; 
            height: 50px; 
            text-align: center; 
            font-size: 10px; 
            color: #777; 
            border-top: 1px solid #ddd; 
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Analisis Dokumen</h1>
        <p>ID Laporan: {{ $document->ref_number }} | Tanggal Analisis: {{ $document->updated_at->format('d M Y, H:i') }} WIB</p>
    </div>

    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td width="65%">
                    <strong>Judul Dokumen:</strong><br>
                    {{ $document->title }}<br><br>
                    <strong>Nama File PDF Asli:</strong><br>
                    {{ $document->file_name }}<br><br>
                    <strong>Layanan Dipilih:</strong><br>
                    {{ $document->service_type == 'ai' ? 'Deteksi Artificial Intelligence (AI)' : 'Cek Plagiasi / Similarity' }}<br><br>
                    <strong>Total Kata Diekstrak:</strong><br>
                    {{ number_format($details['word_count'] ?? 0) }} kata
                </td>
                <td width="35%">
                    <div class="score-box">
                        @if($document->service_type == 'ai')
                            <div class="score-title">Probabilitas Ditulis AI</div>
                            @php $aiColor = $scanResult->ai_probability > 50 ? 'text-danger' : 'text-success'; @endphp
                            <div class="score-value {{ $aiColor }}">{{ $scanResult->ai_probability }}%</div>
                        @else
                            <div class="score-title">Tingkat Kesamaan (Plagiasi)</div>
                            @php $plagColor = $scanResult->similarity_score > 20 ? 'text-danger' : 'text-success'; @endphp
                            <div class="score-value {{ $plagColor }}">{{ $scanResult->similarity_score }}%</div>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @if($document->service_type == 'plagiarism')
    <div class="section-title">Sumber Kesamaan (Internet Sources)</div>
    <table class="source-list">
        <thead>
            <tr>
                <th width="10%" style="text-align: center;">Skor</th>
                <th width="65%">Domain Sumber</th>
                <th width="25%">Tipe Sumber</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details['sources'] ?? [] as $source)
            <tr>
                <td align="center"><strong>{{ $source['percentage'] ?? 0 }}%</strong></td>
                <td><a href="{{ $source['url'] ?? '#' }}" target="_blank">{{ $source['name'] ?? 'Sumber Internet' }}</a></td>
                <td>{{ $source['type'] ?? 'Internet' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" align="center">Luar biasa! Tidak ditemukan satupun indikasi plagiasi di internet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif

    <div class="section-title">Pratinjau Teks yang Dianalisis</div>
    <div class="text-content">
        {{ $document->extracted_text }}
    </div>

    <div class="footer">
        Dihasilkan secara otomatis oleh sistem pada {{ date('d-m-Y H:i') }} | Ref ID: {{ $document->ref_number }}
    </div>
</body>
</html>