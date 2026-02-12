<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\KriteriaController; 

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard
Route::get('/dashboard', [KelasController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk Manajemen Kelas
Route::get('/kelas', [KelasController::class, 'index'])->middleware(['auth'])->name('kelas.index');
Route::get('/kelas/tambah', [KelasController::class, 'create'])->middleware(['auth'])->name('kelas.create');
Route::post('/kelas/simpan', [KelasController::class, 'store'])->middleware(['auth'])->name('kelas.store');

// --- SELIPAN CODE: ROUTE DOWNLOAD PDF KELAS ---
Route::get('/kelas/download-pdf', [KelasController::class, 'downloadPDF'])
    ->middleware(['auth'])
    ->name('kelas.download-pdf');
// ----------------------------------------------

// Route untuk Penilaian
Route::get('/penilaian/baru', [PenilaianController::class, 'create'])->middleware(['auth'])->name('penilaian.create');
Route::post('/penilaian/simpan', [PenilaianController::class, 'store'])->middleware(['auth'])->name('penilaian.store');
Route::get('/penilaian/riwayat-semua', [PenilaianController::class, 'index'])->middleware(['auth'])->name('penilaian.index');

// --- ROUTE RIWAYAT (ARSIP) ---
Route::get('/penilaian/riwayat', [PenilaianController::class, 'riwayat'])
    ->middleware(['auth'])
    ->name('penilaian.riwayat');

// --- ROUTE KRITERIA ---
Route::get('/kriteria/tambah', [KriteriaController::class, 'create'])
    ->middleware(['auth'])
    ->name('kriteria.create');

Route::post('/kriteria/simpan', [KriteriaController::class, 'store'])
    ->middleware(['auth'])
    ->name('kriteria.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- TAMBAHAN RUTE EDIT & HAPUS KELAS ---
    Route::get('/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/hapus/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Tambahan route hapus penilaian
    Route::delete('/penilaian/hapus/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');
});

require __DIR__.'/auth.php';