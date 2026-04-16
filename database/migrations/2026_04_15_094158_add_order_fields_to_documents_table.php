<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'status'
            $table->string('ref_number')->nullable()->after('status');
            $table->string('service_type')->default('plagiarism')->after('ref_number'); // 'plagiarism' atau 'ai'
            $table->string('whatsapp_number')->nullable()->after('service_type');
            $table->boolean('exclude_quotes')->default(false)->after('whatsapp_number');
            $table->boolean('exclude_bibliography')->default(false)->after('exclude_quotes');
            $table->integer('price')->default(0)->after('exclude_bibliography');
            $table->string('payment_status')->default('PAID')->after('price'); // Default PAID untuk simulasi
            $table->string('file_name')->nullable()->after('payment_status'); // Nama file asli yang diunggah
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn([
                'ref_number', 
                'service_type', 
                'whatsapp_number', 
                'exclude_quotes', 
                'exclude_bibliography', 
                'price', 
                'payment_status',
                'file_name'
            ]);
        });
    }
};