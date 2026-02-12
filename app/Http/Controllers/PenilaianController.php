<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * Menampilkan daftar riwayat penilaian (Halaman Utama Penilaian).
     */
    public function index()
    {
        $penilaians = Penilaian::with(['kelas', 'user'])->latest()->get();
        return view('penilaian.index', compact('penilaians'));
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
     * Sudah termasuk revisi Tanggal dan Perhitungan Skor Kriteria.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'kelas_id'          => 'required|exists:kelas,id',
            'tanggal_penilaian' => 'required|date',
            'skor'              => 'required|array',
            'skor.*'            => 'required|integer|min:0|max:100',
            'catatan'           => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 2. Hitung Skor Total
        // Di sini kita jumlahkan semua skor dari kriteria yang diinput
        $skor_total = array_sum($request->skor);

        // 3. Proses Upload Foto (Jika ada)
        $nama_foto = null;
        if ($request->hasFile('foto')) {
            $nama_foto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('uploads/penilaian'), $nama_foto);
        }

        // 4. Simpan ke Database
        Penilaian::create([
            'user_id'           => Auth::id(), // Mengambil ID petugas yang login
            'kelas_id'          => $request->kelas_id,
            'tanggal_penilaian' => $request->tanggal_penilaian, // Revisi Guru: Masuk ke DB
            'skor_total'        => $skor_total,
            'catatan'           => $request->catatan,
            'foto'              => $nama_foto,
        ]);

        // Kembali ke index dengan pesan sukses
        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil disimpan!');
    }

    /**
     * Fitur Baru: Menampilkan riwayat penilaian hari-hari sebelumnya dengan filter.
     */
    public function riwayat(Request $request)
    {
        $query = Penilaian::with(['kelas', 'user']);

        // Filter jika user/guru memilih rentang tanggal
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_penilaian', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $riwayat = $query->latest('tanggal_penilaian')->get();

        return view('penilaian.riwayat', compact('riwayat'));
    }

    /**
     * Menghapus data penilaian.
     */
    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        
        // Hapus foto dari folder jika ada agar tidak memenuhi storage
        if ($penilaian->foto && file_exists(public_path('uploads/penilaian/' . $penilaian->foto))) {
            unlink(public_path('uploads/penilaian/' . $penilaian->foto));
        }

        $penilaian->delete();

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil dihapus!');
    }
}