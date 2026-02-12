<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    // Tambahkan baris ini untuk mencocokkan dengan nama tabel di database kamu
    protected $table = 'penilains'; 

    protected $fillable = [
        'user_id', 
        'kelas_id', 
        'tanggal_penilaian', 
        'skor_total', 
        'catatan'
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}