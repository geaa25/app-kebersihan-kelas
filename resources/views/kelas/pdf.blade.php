<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Kelas</title>
        <style>
            body { font-family: sans-serif; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
            th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
            .header { text-align: center; margin-bottom: 20px; }
            .text-center { text-align: center; }
        </style>
</head>
    <body>
        <div class="header">
            <h2>LAPORAN DATA KELAS SMKN 1 MAJA</h2>
            @if($search) <p>Hasil Pencarian: <strong>{{ $search }}</strong></p>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Skor Terbaru</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($data_kelas as $index => $kelas)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kelas->nama_kelas }}</td>
                    <td>{{ $kelas->wali_kelas }}</td>
                    <td style="text-align: center;">
                        {{ $kelas->penilaian->first()->skor_total ?? '0' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
    </body>
</html>