<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document; // Tambahkan ini untuk memanggil model Dokumen

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->id();
        
        // Menghitung statistik dokumen
        $totalDocs = Document::where('user_id', $userId)->count();
        $scannedDocs = Document::where('user_id', $userId)->where('status', 'scanned')->count();
        $pendingDocs = Document::where('user_id', $userId)->where('status', 'pending')->count();

        return view('home', compact('totalDocs', 'scannedDocs', 'pendingDocs'));
    }
}