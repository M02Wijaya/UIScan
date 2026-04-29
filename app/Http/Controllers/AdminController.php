<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Halaman Dashboard Admin
    public function index()
    {
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalDocuments = Document::count();
        
        // Menghitung total pendapatan dari transaksi layanan (debit) yang sukses
        $totalIncome = Transaction::where('type', 'debit')
                                  ->where('status', 'success')
                                  ->sum('amount');
        
        // Mengambil permintaan top-up yang masih 'pending' (untuk notifikasi/approval)
        $pendingTopups = Transaction::with('user')
                            ->where('type', 'credit')
                            ->where('status', 'pending')
                            ->latest()
                            ->get();

        // [BARU] Mengambil semua riwayat top-up (untuk tabel riwayat)
        $allTopup = Transaction::with('user')
                            ->where('type', 'credit')
                            ->latest()
                            ->get();

        // Menambahkan $allTopup ke dalam compact()
        return view('admin.dashboard', compact('totalUsers', 'totalDocuments', 'totalIncome', 'pendingTopups', 'allTopup'));
    }

    // 2. Halaman Daftar Pengguna
    public function users()
    {
        $users = User::with('wallet')->where('role', '!=', 'admin')->latest()->get();
        return view('admin.users', compact('users'));
    }

    // 3. Halaman Riwayat Dokumen
    public function documents()
    {
        $documents = Document::with('user')->latest()->get();
        return view('admin.documents', compact('documents'));
    }

    // 4. Proses Setujui Top-Up
    public function approveTopup($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaction = Transaction::findOrFail($id);
                
                if ($transaction->status !== 'pending' || $transaction->type !== 'credit') {
                    throw new \Exception('Transaksi tidak valid untuk disetujui.');
                }

                // Update status transaksi
                $transaction->update(['status' => 'success']);

                // Tambah saldo ke dompet user
                $wallet = Wallet::firstOrCreate(['user_id' => $transaction->user_id]);
                $wallet->increment('balance', $transaction->amount);
            });

            return back()->with('success', 'Top-Up berhasil disetujui! Saldo user telah bertambah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui Top-Up: ' . $e->getMessage());
        }
    }

    // 5. Proses Tolak Top-Up
    public function rejectTopup($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'failed']);
            return back()->with('success', 'Top-Up berhasil ditolak.');
        }

        return back()->with('error', 'Transaksi tidak valid.');
    }
}