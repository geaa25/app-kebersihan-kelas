<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // IMPORT BARU UNTUK PDF

class KelasController extends Controller
{
    /**
     * Menampilkan daftar kelas dengan fitur Pencarian dan Skor Terbaru.
     */
    public function index(Request $request)
    {
        // Menangkap input pencarian dari user
        $search = $request->get('search');
        
        // Mengambil data kelas dengan relasi penilaian terbaru (Eager Loading)
        $data_kelas = Kelas::with(['penilaian' => function($query) {
                $query->latest(); 
            }])
            ->when($search, function($query) use ($search) {
                return $query->where('nama_kelas', 'like', "%{$search}%")
                             ->orWhere('wali_kelas', 'like', "%{$search}%");
            })
            ->get();

        return view('kelas.index', compact('data_kelas'));
    }

    /**
     * FITUR REVISI: Download Laporan PDF (Bisa Filter Berdasarkan Pencarian)
     */
    public function downloadPDF(Request $request)
    {
        $search = $request->get('search');

        // Tambahkan with(['penilaian' => ...]) agar skor terbaca di PDF
        $data_kelas = Kelas::with(['penilaian' => function($query) {
                $query->latest(); 
            }])
            ->when($search, function($query) use ($search) {
                return $query->where('nama_kelas', 'like', "%{$search}%")
                            ->orWhere('wali_kelas', 'like', "%{$search}%");
            })->get();

        $pdf = Pdf::loadView('kelas.pdf', compact('data_kelas', 'search'));
        $nama_file = $search ? 'laporan-kelas-' . $search . '.pdf' : 'laporan-semua-kelas.pdf';

        return $pdf->download($nama_file);
    }

    /**
     * Dashboard: Menampilkan statistik, pengumuman, dan data grafik mingguan.
     */
    public function dashboard()
    {
        $jumlah_kelas = Kelas::count();
        
        $penilaianTerbaruIds = Penilaian::selectRaw('MAX(id)')
                                ->groupBy('kelas_id')
                                ->pluck('MAX(id)');

        $queryTerbaru = Penilaian::with('kelas')->whereIn('id', $penilaianTerbaruIds);
        
        $terbersih = (clone $queryTerbaru)
                    ->orderBy('skor_total', 'desc')
                    ->take(3)
                    ->get();
        
        $terkotor = (clone $queryTerbaru)
                    ->orderBy('skor_total', 'asc')
                    ->take(3)
                    ->get();

        $grafik = [];
        $hari = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        foreach ($hari as $h) {
            $rataRata = Penilaian::whereRaw("DAYNAME(tanggal_penilaian) = ?", [$h])
                        ->avg('skor_total') ?? 0;
            $grafik[] = round($rataRata);
        }

        return view('dashboard', compact('jumlah_kelas', 'terbersih', 'terkotor', 'grafik'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas' => $request->wali_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        Penilaian::where('kelas_id', $id)->delete();
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas dan data penilaian terkait berhasil dihapus!');
    }
}