<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TopupController extends Controller
{
    public function index()
    {
        return view('user.topup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        // Menyimpan data sesuai dengan struktur migration tabel transactions Anda
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'trx_code' => 'TRX-IN-' . time() . '-' . Auth::id(), // Ditambahkan: Kode transaksi unik
            'type' => 'kredit',                                  // Diperbaiki: Pakai huruf 'k'
            'amount' => $request->amount,
            'description' => 'Top Up Saldo via Xendit',          // Ditambahkan: Keterangan wajib
            'status' => 'pending',
        ]);

        // Buat Invoice (Link Pembayaran) via Xendit API
        $response = Http::withBasicAuth(env('XENDIT_SECRET_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'TOPUP-' . $transaction->id . '-' . time(),
                'amount' => $transaction->amount,
                'payer_email' => Auth::user()->email,
                'description' => 'Top Up Saldo Aplikasi UIScan',
                'success_redirect_url' => route('user.topup'), // Arahkan kembali ke aplikasi setelah bayar
            ]);

        if ($response->successful()) {
            $invoiceUrl = $response->json('invoice_url');
            return redirect($invoiceUrl); // Arahkan user ke halaman Xendit
        }

        return back()->with('error', 'Gagal membuat tagihan Xendit. Pastikan XENDIT_SECRET_KEY di .env sudah benar.');
    }

    public function callback(Request $request)
    {
        // Tangkap notifikasi dari Xendit
        $status = $request->status;
        $externalId = $request->external_id;

        // 1. Cek apakah ini Notifikasi Test dari Dashboard Xendit
        if (!str_contains($externalId, 'TOPUP-')) {
            return response()->json(['message' => 'Test Webhook Xendit Berhasil Diterima']);
        }

        // 2. Jika ini transaksi asli dari aplikasi
        if ($status == 'PAID' || $status == 'SETTLED') {
            $parts = explode('-', $externalId);
            
            // Pastikan formatnya benar sebelum memproses ID
            if (isset($parts[1])) {
                $transactionId = $parts[1];
                $transaction = Transaction::find($transactionId);

                if ($transaction && $transaction->status == 'pending') {
                    $transaction->update(['status' => 'success']);
                    
                    // Tambah Saldo
                    $wallet = $transaction->user->wallet;
                    if (!$wallet) {
                        $wallet = $transaction->user->wallet()->create(['balance' => 0]);
                    }
                    $wallet->increment('balance', $transaction->amount);
                }
            }
        }

        return response()->json(['message' => 'Notifikasi Pembayaran Diterima']);
    }
}