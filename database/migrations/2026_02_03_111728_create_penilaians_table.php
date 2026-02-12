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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Petugas yang menilai [cite: 171]
            $table->foreignId('kelas_id')->constrained(); // Kelas yang dinilai [cite: 172]
            $table->date('tanggal_penilaian'); // Tanggal penilaian dilakukan [cite: 173]
            $table->integer('skor_total'); // Total skor dari semua kriteria [cite: 174]
            $table->text('catatan')->nullable(); // Catatan tambahan dari penilai [cite: 175]
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
