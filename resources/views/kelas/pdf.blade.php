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
        hr { border: 0.5px solid #eee; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA KELAS SMKN 1 MAJA</h2>
        <hr>
        @if($search)
            <p>Hasil Pencarian: <strong>{{ $search }}</strong></p>
        @else
            <p>Laporan Seluruh Data Kelas</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama Kelas</th>
                <th>Wali Kelas</th>
                <th style="width: 100px;">Skor Terbaru</th> </tr>
        </thead>
        <tbody>
            @foreach($data_kelas as $index => $kelas)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $kelas->nama_kelas }}</td>
                <td>{{ $kelas->wali_kelas }}</td>
                <td class="text-center">
                    {{ $kelas->penilaian->first()->skor_total ?? '0' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-size: 10px; margin-top: 20px;">Dicetak pada: {{ date('d/m/Y H:i') }}</p>
</body>
</html>