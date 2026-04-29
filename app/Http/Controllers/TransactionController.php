<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi milik user yang sedang login, dari yang paling baru
        $transactions = Transaction::where('user_id', auth()->id())->latest()->get();
        
        return view('transactions.index', compact('transactions'));
    }
}