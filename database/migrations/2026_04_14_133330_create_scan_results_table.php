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
        Schema::create('scan_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade'); // Relasi ke dokumen
            $table->decimal('ai_probability', 5, 2)->nullable(); // Persentase AI (0-100)
            $table->decimal('similarity_score', 5, 2)->nullable(); // Persentase Cosine Similarity (0-100)
            $table->json('similarity_details')->nullable(); // Simpan ID dokumen lain yang mirip (format JSON)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_results');
    }
};
