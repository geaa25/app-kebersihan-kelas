<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Penilaian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Tanggal</th>
                            <th class="border px-4 py-2">Kelas</th>
                            <th class="border px-4 py-2">Skor</th>
                            <th class="border px-4 py-2">Foto Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                        <tr>
                            <td class="border px-4 py-2">{{ $r->tanggal_penilaian }}</td>
                            <td class="border px-4 py-2">{{ $r->kelas->nama_kelas }}</td>
                            <td class="border px-4 py-2">{{ $r->skor_total }}</td>
                            <td class="border px-4 py-2">
                                @if($r->foto)
                                    <a href="{{ asset('storage/' . $r->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $r->foto) }}" class="w-20 h-20 object-cover rounded">
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>