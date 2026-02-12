<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kelas SMKN 1 Maja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0 no-print">
                <form action="{{ route('kelas.index') }}" method="GET" class="flex w-full md:w-1/2">
                    <input type="text" name="search" placeholder="Cari Nama Kelas atau Wali Kelas..." 
                           value="{{ request('search') }}"
                           class="border-gray-300 rounded-l-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500 font-semibold text-sm">
                    <button type="submit" class="bg-gray-800 text-white px-4 rounded-r-md hover:bg-black transition font-semibold text-sm">
                        Cari
                    </button>
                </form>

                <div class="flex space-x-2">
                    <a href="{{ route('kelas.download-pdf', ['search' => request('search')]) }}" 
                       class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                        Download PDF
                    </a>
                    
                    <a href="{{ route('kelas.create') }}" class="bg-white hover:bg-gray-100 text-black font-semibold py-2 px-4 rounded shadow border border-gray-300 transition text-sm">
                        + Tambah Kelas
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 font-semibold no-print">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto text-black">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                                <th class="border border-gray-200 px-4 py-3 text-center w-16 font-semibold">No</th>
                                <th class="border border-gray-200 px-4 py-3 text-center font-semibold">Nama Kelas</th>
                                <th class="border border-gray-200 px-4 py-3 text-center font-semibold">Wali Kelas</th>
                                <th class="border border-gray-200 px-4 py-3 text-center font-semibold">Skor Terbaru</th>
                                <th class="border border-gray-200 px-4 py-3 text-center w-48 font-semibold no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($data_kelas as $index => $item)
                            <tr class="hover:bg-gray-50 transition border-b">
                                <td class="border border-gray-200 px-4 py-3 text-center font-semibold">{{ $index + 1 }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-center font-semibold">{{ $item->nama_kelas }}</td>
                                <td class="border border-gray-200 px-4 py-3 text-center font-semibold">{{ $item->wali_kelas }}</td>
                                
                                <td class="border border-gray-200 px-4 py-3 text-center font-semibold text-blue-600">
                                    {{ $item->penilaian->first()->skor_total ?? '0' }}
                                </td>

                                <td class="border border-gray-200 px-4 py-3 no-print">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('kelas.edit', $item->id) }}" class="bg-white hover:bg-gray-50 text-black font-semibold py-1.5 px-4 rounded shadow-sm border border-gray-300 text-xs transition inline-block text-center">
                                            Edit
                                        </a>

                                        <a href="#" 
                                           onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus kelas ini?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }"
                                           class="bg-white hover:bg-red-50 text-red-500 font-semibold py-1.5 px-4 rounded shadow-sm border border-red-500 text-xs transition inline-block text-center">
                                            Hapus
                                        </a>

                                        <form id="delete-form-{{ $item->id }}" action="{{ route('kelas.destroy', $item->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="border border-gray-200 px-4 py-10 text-center font-semibold text-gray-500">
                                    Data tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print, nav, header, form, button {
                display: none !important;
            }
            body { background-color: white !important; }
            .max-w-7xl { max-width: 100% !important; padding: 0 !important; }
            table { width: 100% !important; border: 1px solid black !important; }
            th, td { border: 1px solid black !important; }
        }
    </style>
</x-app-layout>