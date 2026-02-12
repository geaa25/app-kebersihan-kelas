<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenilaianController extends Controller
{
    /**
     * Menampilkan daftar riwayat penilaian (Halaman Utama Penilaian).
     */
    public function index()
    {
        // Mengambil data penilaian terbaru beserta relasi kelasnya
        $riwayat = Penilaian::with('kelas')->latest()->get();
        
        return view('penilaian.index', compact('riwayat'));
    }

    /**
     * Menampilkan form input penilaian (create.blade.php).
     */
    public function create()
    {
        $kelas = Kelas::all();
        $kriteria = Kriteria::all();
        return view('penilaian.create', compact('kelas', 'kriteria'));
    }

    /**
     * Menyimpan data penilaian ke database.
     * FIX: Logika upload foto disatukan & menghapus duplikasi penyimpanan.
     */
    public function store(Request $request)
    {
    $request->validate([
        'kelas_id'          => 'required',
        'tanggal_penilaian' => 'required',
        'skor'              => 'required|array',
        'foto'              => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);
        
        $skor_total = array_sum($request->skor);
        // DEBUG: Cek apakah file benar-benar masuk ke sistem
        $path_foto = null;
        if ($request->hasFile('foto')) {
            // Simpan ke folder storage/app/public/foto_bukti
            $path_foto = $request->file('foto')->store('foto_bukti', 'public');
        }

     Penilaian::create([
            'user_id'           => auth()->id(),
            'kelas_id'          => $request->kelas_id,
            'tanggal_penilaian' => $request->tanggal_penilaian,
            'skor_total'        => $skor_total,
            'catatan'           => $request->catatan,
            'foto'              => $path_foto, // Jika ini NULL di DB, berarti hasFile('foto') bernilai false
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Fitur: Menampilkan riwayat penilaian dengan filter rentang tanggal.
     */
    public function riwayat(Request $request)
    {
        $query = Penilaian::with(['kelas', 'user']);

    if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            query->whereBetween('tanggal_penilaian', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $riwayat = $query->latest('tanggal_penilaian')->get();

        return view('penilaian.riwayat', compact('riwayat'));
    }

    /**
     * Menghapus data penilaian beserta file fotonya.
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        
        // Hapus file foto dari storage jika ada
        if ($penilaian->foto) {
            Storage::disk('public')->delete($penilaian->foto);
        }

        $penilaian->delete();

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil dihapus!');
    }
}