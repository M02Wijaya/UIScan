<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ScanResult;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::where('user_id', auth()->id())->latest()->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input dari Form
        $request->validate([
            'title' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Maksimal 10MB
            'whatsapp_number' => 'required|string|max:20',
            'service_type' => 'required|in:plagiarism,ai',
            'price' => 'required|numeric'
        ]);

        $user = auth()->user();

        // --- SISTEM PEMOTONGAN SALDO ---
        // Cek apakah saldo cukup untuk membayar harga pesanan
        if ($user->balance < $request->price) {
            return back()->withInput()->withErrors(['saldo_kurang' => 'Maaf, saldo Anda tidak mencukupi untuk memproses pesanan ini. Silakan top up terlebih dahulu.']);
        }

        // Potong saldo user dan simpan
        $user->balance -= $request->price;
        $user->save();
        // -------------------------------

        // 2. Proses Upload File
        $filePath = null;
        $fileName = null;
        
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            
            // File akan disimpan di folder storage/app/public/documents
            $filePath = $file->store('documents', 'public'); 
        }

        // 3. Buat Nomor Referensi Unik (Contoh: UISCAN-A1B2C)
        $refNumber = 'UISCAN-' . strtoupper(Str::random(5));

        // 4. Simpan Data Pesanan ke Database
        Document::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'status' => 'pending', // Status awal
            'ref_number' => $refNumber,
            'service_type' => $request->service_type,
            'whatsapp_number' => $request->whatsapp_number,
            'exclude_quotes' => $request->has('exclude_quotes'),
            'exclude_bibliography' => $request->has('exclude_bibliography'),
            'price' => $request->price,
            'payment_status' => 'PAID',
            'extracted_text' => 'File dokumen siap diproses...', 
        ]);

        // Pesan sukses diubah untuk menampilkan jumlah saldo yang terpotong
        return redirect()->route('documents.index')->with('success', 'Pesanan berhasil dibuat! Saldo Anda telah dipotong sebesar Rp ' . number_format($request->price, 0, ',', '.'));
    }

    public function destroy(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus!');
    }

    // --- FUNGSI SCAN (SIMULASI PROSES FILE) ---
    public function scan(Document $document)
    {
        $simulatedText = "Ini adalah simulasi teks yang berhasil diekstrak dari file " . $document->file_name . ". \n\nDalam sistem produksi nyata, mesin kami akan membaca seluruh paragraf dari dokumen Anda, membandingkannya dengan miliaran database jurnal, artikel internet, dan publikasi ilmiah. \n\nBeberapa kalimat ini mungkin terdeteksi memiliki kemiripan dengan sumber yang sudah ada di internet, sehingga sistem akan menandainya sebagai indikasi plagiarisme. Selain itu, pola kalimat tertentu juga dapat memicu deteksi kecerdasan buatan (AI) jika strukturnya terlalu kaku atau mekanis. \n\nPenelitian ini bertujuan untuk mengukur efektivitas sistem tersebut dalam lingkungan akademik.";

        $isPlagiarism = $document->service_type == 'plagiarism';
        
        $similarityScore = $isPlagiarism ? rand(15, 35) : rand(1, 5); 
        $aiProbability = $isPlagiarism ? rand(1, 10) : rand(60, 95);  

        $matchedSources = [
            ['name' => 'ejournal.unsrat.ac.id', 'type' => 'Internet Source', 'percentage' => rand(5, 10)],
            ['name' => 'repository.uinjkt.ac.id', 'type' => 'Internet Source', 'percentage' => rand(3, 7)],
            ['name' => 'Submitted to Universitas Terbuka', 'type' => 'Student Paper', 'percentage' => rand(1, 4)],
            ['name' => 'Journal of Economic and Bussines', 'type' => 'Publication', 'percentage' => rand(1, 2)],
        ];

        usort($matchedSources, function($a, $b) { return $b['percentage'] <=> $a['percentage']; });

        $details = [
            'word_count' => rand(3000, 7000),
            'paper_id' => rand(111111111, 999999999),
            'internet_sources' => $similarityScore - rand(2, 5),
            'publications' => rand(2, 6),
            'student_papers' => rand(1, 5),
            'sources' => $matchedSources
        ];

        ScanResult::updateOrCreate(
            ['document_id' => $document->id],
            [
                'similarity_score' => $similarityScore,
                'ai_probability' => $aiProbability,
                'similarity_details' => json_encode($details)
            ]
        );

        $document->update([
            'status' => 'scanned',
            'extracted_text' => $simulatedText
        ]);

        return redirect()->route('documents.show', $document->id)->with('success', 'Proses scan selesai! Berikut adalah hasilnya.');
    }

    // --- FUNGSI SHOW (MENAMPILKAN HALAMAN HASIL) ---
    public function show(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $scanResult = ScanResult::where('document_id', $document->id)->first();
        $details = json_decode($scanResult->similarity_details, true) ?? [];

        return view('documents.show', compact('document', 'scanResult', 'details'));
    }

    // --- FUNGSI DOWNLOAD PDF ---
    public function downloadPdf(Document $document)
    {
        if ($document->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $scanResult = ScanResult::where('document_id', $document->id)->first();
        $details = json_decode($scanResult->similarity_details, true) ?? [];

        $pdf = Pdf::loadView('documents.pdf', compact('document', 'scanResult', 'details'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_' . $document->ref_number . '.pdf');
    }
}