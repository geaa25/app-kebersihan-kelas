<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // Tambahkan baris di bawah ini untuk mengizinkan input data
    protected $fillable = ['nama_kelas', 'wali_kelas'];

    public function penilaian() {
        return $this->hasMany(Penilaian::class);
    }
}