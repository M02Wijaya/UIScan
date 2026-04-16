<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiDetectionService
{
    /**
     * Fungsi untuk mendeteksi teks AI
     */
    public function detect($text)
    {
        /* * IMPLEMENTASI API ASLI (Bisa Anda buka komentarnya nanti)
         * * $response = Http::withHeaders([
         * 'Authorization' => 'Bearer ' . env('OPENAI_API_KEY')
         * ])->post('https://api.openai.com/v1/completions', [
         * 'model' => 'text-davinci-003', // atau model deteksi lain
         * 'prompt' => "Berapa persen kemungkinan teks ini ditulis oleh AI: " . $text,
         * ]);
         * * return $response->json('choices.0.text');
         */

        // SIMULASI SEMENTARA: 
        // Mengembalikan angka persentase acak antara 5% hingga 85% 
        // agar Anda bisa melihat bentuk outputnya di halaman hasil.
        return rand(500, 8500) / 100;
    }
}