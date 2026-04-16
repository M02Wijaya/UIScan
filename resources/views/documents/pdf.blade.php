<!DOCTYPE html>
<html>
<head>
    <title>Laporan Scan - {{ $document->ref_number }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        .header { border-bottom: 2px solid #dc3545; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .meta { color: #666; font-size: 11px; margin-top: 5px; }
        
        .content-wrapper { width: 100%; }
        /* Kolom Teks Kiri */
        .text-content { width: 65%; float: left; text-align: justify; line-height: 1.6; padding-right: 20px; }
        /* Kolom Sidebar Kanan */
        .sidebar { width: 30%; float: right; background: #f8f9fa; padding: 15px; border: 1px solid #ddd; }
        
        .score-box { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 15px;}
        .score-plagiat { color: #dc3545; font-size: 45px; font-weight: bold; margin: 10px 0; }
        .score-ai { color: #0dcaf0; font-size: 45px; font-weight: bold; margin: 10px 0; }
        
        .source-list { list-style: none; padding: 0; margin: 0; }
        .source-item { margin-bottom: 10px; font-size: 11px; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }
        
        .highlight-plagiat { background-color: #ffc107; padding: 0 2px;}
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $document->title }}</div>
        <div class="meta">
            File Asli: {{ $document->file_name }} | No. Pesanan: {{ $document->ref_number }} | Tanggal: {{ $document->updated_at->format('d M Y, H:i') }}
        </div>
    </div>

    <div class="content-wrapper">
        <div class="text-content">
            <h4 style="margin-top:0;">Teks Dokumen:</h4>
            @php
                $text = htmlspecialchars($document->extracted_text);
                $highlighted = str_replace(
                    "membandingkannya dengan miliaran database jurnal, artikel internet, dan publikasi ilmiah.", 
                    "<span class='highlight-plagiat'>membandingkannya dengan miliaran database jurnal, artikel internet, dan publikasi ilmiah. [1]</span>", 
                    $text
                );
                $highlighted = str_replace(
                    "Penelitian ini bertujuan untuk mengukur efektivitas sistem tersebut", 
                    "<span class='highlight-plagiat'>Penelitian ini bertujuan untuk mengukur efektivitas sistem tersebut [2]</span>", 
                    $highlighted
                );
            @endphp
            <p style="white-space: pre-wrap;">{!! $highlighted !!}</p>
        </div>

        <div class="sidebar">
            <div class="score-box">
                @if($document->service_type == 'plagiarism')
                    <div style="font-weight: bold; color:#666;">ORIGINALITY REPORT</div>
                    <div class="score-plagiat">{{ $scanResult->similarity_score }}%</div>
                    <div style="font-size: 11px; color:#555;">
                        <strong>{{ $details['internet_sources'] ?? 0 }}%</strong> Internet Sources<br>
                        <strong>{{ $details['publications'] ?? 0 }}%</strong> Publications<br>
                        <strong>{{ $details['student_papers'] ?? 0 }}%</strong> Student Papers
                    </div>
                @else
                    <div style="font-weight: bold; color:#666;">AI DETECTION</div>
                    <div class="score-ai">{{ $scanResult->ai_probability }}%</div>
                    <div style="font-size: 11px; color:#555;">Probability AI Generated</div>
                @endif
            </div>

            @if($document->service_type == 'plagiarism' && isset($details['sources']))
                <div style="font-weight: bold; margin-bottom: 10px; font-size:12px;">PRIMARY SOURCES:</div>
                <ul class="source-list">
                    @foreach($details['sources'] as $index => $source)
                    <li class="source-item">
                        <strong>{{ $source['percentage'] }}%</strong> - {{ $source['name'] }} <br>
                        <span style="font-size: 9px; color: #888;">{{ $source['type'] }}</span>
                    </li>
                    @endforeach
                </ul>
            @endif
            
            <div style="margin-top: 20px; font-size: 11px; border-top: 2px solid #ddd; padding-top: 10px;">
                <strong>WORD COUNT:</strong> {{ $details['word_count'] ?? 0 }}<br>
                <strong>PAPER ID:</strong> {{ $details['paper_id'] ?? '-' }}<br>
                <strong>EXCLUDE QUOTES:</strong> {{ $document->exclude_quotes ? 'ON' : 'OFF' }}<br>
                <strong>EXCLUDE BIBLIOGRAPHY:</strong> {{ $document->exclude_bibliography ? 'ON' : 'OFF' }}
            </div>
        </div>
        
        <div class="clear"></div>
    </div>
</body>
</html>