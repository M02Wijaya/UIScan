<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    // Menampilkan halaman Saldo & Riwayat Transaksi
    public function index()
    {
        // Mengambil semua riwayat transaksi milik user yang sedang login, diurutkan dari yang terbaru
        $transactions = Transaction::where('user_id', auth()->id())->latest()->get();
        return view('wallet.index', compact('transactions'));
    }

    // Memproses form Top Up
    public function topup(Request $request)
    {
        // Validasi minimal top up Rp 10.000
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ], [
            'amount.min' => 'Minimal Top Up adalah Rp 10.000'
        ]);

        // Membuat kode transaksi unik (Misal: TRX-IN-A1B2C)
        $trxCode = 'TRX-IN-' . strtoupper(Str::random(5));

        // Mencatat transaksi masuk dengan status "pending" (Menunggu Pembayaran)
        Transaction::create([
            'user_id' => auth()->id(),
            'trx_code' => $trxCode,
            'type' => 'kredit',
            'amount' => $request->amount,
            'status' => 'pending', 
            'description' => 'Top Up Saldo Akun'
        ]);

        return redirect()->route('wallet.index')->with('success', 'Permintaan Top Up berhasil dibuat! Silakan hubungi Admin atau lakukan pembayaran.');
    }
}