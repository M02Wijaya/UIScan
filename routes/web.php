<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TopupController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('documents', DocumentController::class)->middleware('auth');

Route::get('/documents/{document}/scan', [DocumentController::class, 'scan'])
    ->name('documents.scan')
    ->middleware('auth');

Route::get('/documents/{document}/pdf', [DocumentController::class, 'downloadPdf'])
    ->name('documents.download')
    ->middleware('auth');

// --- ROUTE USER TOP-UP & TRANSAKSI ---
Route::middleware(['auth'])->group(function () {
    Route::get('/user/topup', [TopupController::class, 'index'])->name('user.topup');
    
    // Perbaikan nama rute di sini (menjadi user.topup.process)
    Route::post('/user/topup', [TopupController::class, 'store'])->name('user.topup.process');
    
    // --- INI YANG DIUBAH: Mengarah ke fungsi history yang baru kita buat ---
    Route::get('/user/riwayat-transaksi', [TopupController::class, 'history'])->name('user.history');
});

// --- ROUTE ADMIN ---
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    
    // RUTE UNTUK MANAJEMEN PENGGUNA
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    
    // RUTE UNTUK RIWAYAT SCAN DOKUMEN
    Route::get('/documents', [App\Http\Controllers\AdminController::class, 'documents'])->name('documents');
    
    Route::post('/topup/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveTopup'])->name('topup.approve');
    Route::post('/topup/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectTopup'])->name('topup.reject');
    
    Route::get('/uji-coba-layanan', function () {
        return view('home');
    })->name('uji.layanan');
});

// --- ROUTE PROFILE ---
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');