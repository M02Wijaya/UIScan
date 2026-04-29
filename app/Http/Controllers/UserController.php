<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan halaman form Top-Up
     */
    public function topup()
    {
        return view('user.topup');
    }

    /**
     * Memproses request Top-Up ke Midtrans
     */
    public function processTopup(Request $request)
    {
        // Validasi input nominal
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        // Buat data transaksi (status masih pending)
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'type' => 'credit', // credit = uang masuk
            'status' => 'pending',
        ]);

        // Konfigurasi Kunci API Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Parameter yang dikirim ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'TOPUP-' . $transaction->id . '-' . time(),
                'gross_amount' => $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]
        ];

        try {
            // Dapatkan token Snap dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Kembalikan ke halaman topup dengan membawa token
            return back()->with(['snapToken' => $snapToken, 'amount' => $request->amount]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran. Pastikan kunci Midtrans di .env sudah benar. Error: ' . $e->getMessage());
        }
    }
}