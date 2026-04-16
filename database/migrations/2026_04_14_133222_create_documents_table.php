<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->string('title'); // Judul dokumen
            $table->string('file_path')->nullable(); // Path file PDF/Word jika diupload
            $table->longText('extracted_text'); // Teks mentah untuk di-scan dengan Cosine Similarity
            $table->enum('status', ['pending', 'scanned'])->default('pending'); // Status scan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
