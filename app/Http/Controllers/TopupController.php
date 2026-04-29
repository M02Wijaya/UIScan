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

    /**
     * Menampilkan riwayat transaksi user
     */
    public function history()
    {
        // Mengambil transaksi milik user yang sedang login
        // Diurutkan dari yang terbaru (latest)
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->paginate(10); // Menggunakan pagination agar tidak terlalu panjang

        return view('user.history', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        // Membuat data transaksi awal dengan status pending
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'trx_code' => 'TRX-IN-' . time() . '-' . Auth::id(),
            'type' => 'kredit',
            'amount' => $request->amount,
            'description' => 'Top Up Saldo via Xendit',
            'status' => 'pending',
        ]);

        // Buat Invoice (Link Pembayaran) via Xendit API
        $response = Http::withBasicAuth(env('XENDIT_SECRET_KEY'), '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'TOPUP-' . $transaction->id . '-' . time(),
                'amount' => $transaction->amount,
                'payer_email' => Auth::user()->email,
                'description' => 'Top Up Saldo Aplikasi UIScan',
                // Redirect kembali ke halaman topup dengan parameter success untuk notifikasi visual
                'success_redirect_url' => route('user.topup', ['payment' => 'success']), 
            ]);

        if ($response->successful()) {
            $invoiceUrl = $response->json('invoice_url');
            return redirect($invoiceUrl); 
        }

        return back()->with('error', 'Gagal membuat tagihan Xendit. Pastikan XENDIT_SECRET_KEY di .env sudah benar.');
    }

    public function callback(Request $request)
    {
        // --- 🛡️ KODE KEAMANAN DIMULAI ---
        $xenditToken = env('XENDIT_WEBHOOK_TOKEN');

        if ($request->header('x-callback-token') !== $xenditToken) {
            return response()->json(['message' => 'Akses Ditolak! Token tidak valid.'], 403);
        }
        // --- 🛡️ KODE KEAMANAN SELESAI ---

        $status = $request->status;
        $externalId = $request->external_id;

        // Cek jika ini notifikasi test dari dashboard Xendit
        if (!str_contains($externalId, 'TOPUP-')) {
            return response()->json(['message' => 'Test Webhook Xendit Berhasil Diterima']);
        }

        // Proses jika status pembayaran sukses (PAID atau SETTLED)
        if ($status == 'PAID' || $status == 'SETTLED') {
            $parts = explode('-', $externalId);
            
            if (isset($parts[1])) {
                $transactionId = $parts[1];
                $transaction = Transaction::find($transactionId);

                if ($transaction && $transaction->status == 'pending') {
                    // Update status transaksi jadi success
                    $transaction->update(['status' => 'success']);
                    
                    // Tambah Saldo ke Wallet User
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