<?php

namespace App\Services;

class CosineSimilarityService
{
    // Fungsi utama yang akan dipanggil dari luar
    public function calculate($text1, $text2)
    {
        $tokens1 = $this->tokenize($text1);
        $tokens2 = $this->tokenize($text2);

        // Gabungkan semua kata unik dari kedua dokumen
        $allTokens = array_unique(array_merge(array_keys($tokens1), array_keys($tokens2)));

        $vector1 = [];
        $vector2 = [];

        // Buat vektor frekuensi kata
        foreach ($allTokens as $token) {
            $vector1[] = $tokens1[$token] ?? 0;
            $vector2[] = $tokens2[$token] ?? 0;
        }

        return $this->cosineSimilarity($vector1, $vector2);
    }

    // Fungsi untuk memecah teks menjadi kata (Tokenization & Preprocessing)
    private function tokenize($text)
    {
        // Ubah ke huruf kecil dan hilangkan tanda baca
        $text = strtolower($text);
        $text = preg_replace('/[^\w\s]/', '', $text);
        $words = explode(' ', $text);

        $tokens = [];
        foreach ($words as $word) {
            $word = trim($word);
            if (!empty($word)) {
                if (!isset($tokens[$word])) {
                    $tokens[$word] = 0;
                }
                $tokens[$word]++; // Hitung frekuensi kata (Term Frequency)
            }
        }
        return $tokens;
    }

    // Fungsi matematika Cosine Similarity
    private function cosineSimilarity($vec1, $vec2)
    {
        $dotProduct = 0;
        $mag1 = 0;
        $mag2 = 0;

        for ($i = 0; $i < count($vec1); $i++) {
            $dotProduct += $vec1[$i] * $vec2[$i];
            $mag1 += pow($vec1[$i], 2);
            $mag2 += pow($vec2[$i], 2);
        }

        $mag1 = sqrt($mag1);
        $mag2 = sqrt($mag2);

        // Cegah pembagian dengan nol jika dokumen kosong
        if ($mag1 * $mag2 == 0) {
            return 0;
        }

        // Kembalikan hasil dalam bentuk persentase (0 - 100)
        return ($dotProduct / ($mag1 * $mag2)) * 100;
    }
}