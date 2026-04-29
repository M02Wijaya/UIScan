<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'user_id',
        'amount',
        'status',
    ];

    // Relasi: Setiap topup dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}