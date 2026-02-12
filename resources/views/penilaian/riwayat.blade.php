<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Riwayat Penilaian Sebelumnya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form action="{{ route('penilaian.riwayat') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                    </div>
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        Cari Data
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600">
                            <th class="border px-4 py-3 text-left">Hari</th>
                            <th class="border px-4 py-3 text-left">Tanggal</th>
                            <th class="border px-4 py-3 text-left">Kelas</th>
                            <th class="border px-4 py-3 text-left">Skor</th>
                            <th class="border px-4 py-3 text-left">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($riwayat as $r)
                        <tr>
                            <td class="px-4 py-3 border font-bold text-blue-600">
                                {{ \Carbon\Carbon::parse($r->tanggal_penilaian)->translatedFormat('l') }}
                            </td>
                            <td class="px-4 py-3 border">
                                {{ \Carbon\Carbon::parse($r->tanggal_penilaian)->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 border">{{ $r->kelas->nama_kelas }}</td>
                            <td class="px-4 py-3 border">
                                <span class="font-bold {{ $r->skor_total < 75 ? 'text-red-500' : 'text-green-600' }}">
                                    {{ $r->skor_total }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border text-sm text-gray-500">
                                {{ $r->user->name }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-400 italic">Data tidak ditemukan pada rentang tanggal tersebut.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>