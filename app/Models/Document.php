<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_path', // Saya biarkan ini jika sebelumnya Anda pakai
        'extracted_text',
        'status',
        
        // --- Kolom Baru dari Step 2 ---
        'ref_number',            
        'service_type',          
        'whatsapp_number',       
        'exclude_quotes',        
        'exclude_bibliography',  
        'price',                 
        'payment_status',        
        'file_name'              
    ];

    // Relasi ke tabel user 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel scan_results (agar gampang dipanggil di halaman riwayat nanti)
    public function scanResult()
    {
        return $this->hasOne(ScanResult::class);
    }
}