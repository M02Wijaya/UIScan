<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route bawaan dari UI Auth (Login/Register)
Auth::routes();

// Route untuk Dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route ajaib untuk CRUD Dokumen (Otomatis membuat documents.index, create, store, destroy, show)
Route::resource('documents', DocumentController::class)->middleware('auth');

// Route khusus untuk fitur Scan
Route::get('/documents/{document}/scan', [DocumentController::class, 'scan'])
    ->name('documents.scan')
    ->middleware('auth');

    // Route untuk Cetak PDF
Route::get('/documents/{document}/pdf', [App\Http\Controllers\DocumentController::class, 'downloadPdf'])
    ->name('documents.pdf')
    ->middleware('auth');

    Route::get('/documents/{document}/pdf', [App\Http\Controllers\DocumentController::class, 'downloadPdf'])->name('documents.pdf');