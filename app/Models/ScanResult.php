<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanResult extends Model
{
    use HasFactory;

    // Ini adalah kunci untuk mengatasi Mass Assignment Exception
    protected $fillable = [
        'document_id',
        'similarity_score',
        'ai_probability',
        'similarity_details',
    ];

    // Relasi kembali ke dokumen
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}