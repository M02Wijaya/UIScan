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
        // 1. CEK ROLE: Jika yang login adalah admin, langsung lempar ke Panel Admin!
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 2. Jika yang login adalah user biasa, jalankan perhitungan statistik ini
        $userId = auth()->id();
        
        // Menghitung statistik dokumen
        $totalDocs = Document::where('user_id', $userId)->count();
        $scannedDocs = Document::where('user_id', $userId)->where('status', 'scanned')->count();
        $pendingDocs = Document::where('user_id', $userId)->where('status', 'pending')->count();

        return view('home', compact('totalDocs', 'scannedDocs', 'pendingDocs'));
    }
}