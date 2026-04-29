<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_id',
        'trx_code',
        'type',
        'amount',
        'status',
        'description'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Dokumen (Opsional)
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}