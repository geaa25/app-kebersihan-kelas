<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    // Membuat data kelas
    \App\Models\Kelas::create(['nama_kelas' => 'XII RPL 1', 'wali_kelas' => 'Bpk. Budi']); 
    \App\Models\Kelas::create(['nama_kelas' => 'XII RPL 2', 'wali_kelas' => 'Ibu Siti']); 

    // Membuat data kriteria
    \App\Models\Kriteria::create(['nama_kriteria' => 'Kebersihan Lantai', 'bobot' => 25]); 
    \App\Models\Kriteria::create(['nama_kriteria' => 'Kerapihan Meja', 'bobot' => 25]); 
    }
}