<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Penilaian Kebersihan Kelas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('penilaian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <label class="block font-bold text-sm text-blue-800">Tanggal Penilaian</label>
                        <input type="date" name="tanggal_penilaian" value="{{ date('Y-m-d') }}" 
                               class="border-gray-300 rounded-md shadow-sm w-full mt-1 focus:ring-blue-500 focus:border-blue-500" required>
                        <p class="text-xs text-blue-600 mt-1">*Hari akan otomatis terbaca oleh sistem untuk grafik mingguan.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pilih Kelas</label>
                        <select name="kelas_id" class="border-gray-300 rounded-md shadow-sm w-full" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block font-medium text-sm text-gray-700">Input Skor (1-100)</label>
                            <a href="{{ route('kriteria.create') }}" class="bg-white hover:bg-gray-100 text-black font-bold py-1 px-3 rounded shadow border border-gray-300 text-xs">
                                + Tambah Kriteria
                            </a>
                        </div>
                        
                        @foreach($kriteria as $item)
                        <div class="flex items-center mb-2">
                            <span class="w-1/3 text-sm text-gray-600">{{ $item->nama_kriteria }} (Bobot: {{ $item->bobot }})</span>
                            <input type="number" name="skor[]" min="1" max="100" class="border-gray-300 rounded-md shadow-sm w-full" placeholder="Masukkan nilai" required>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Catatan/Bukti Tekstual</label>
                        <textarea name="catatan" class="border-gray-300 rounded-md shadow-sm w-full" placeholder="Contoh: Lantai masih berdebu"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Lampirkan Foto Bukti</label>
                        <input type="file" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">*Format: JPG, PNG. Maksimal 2MB</p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Penilaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>