<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Kelas: {{ $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label for="nama_kelas" class="block font-medium text-sm text-gray-700">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas" 
                               value="{{ old('nama_kelas', $kelas->nama_kelas) }}" 
                               class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="wali_kelas" class="block font-medium text-sm text-gray-700">Wali Kelas</label>
                        <input type="text" name="wali_kelas" id="wali_kelas" 
                               value="{{ old('wali_kelas', $kelas->wali_kelas) }}" 
                               class="border-gray-300 rounded-md shadow-sm w-full focus:ring-blue-500 focus:border-blue-500" 
                               required>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('kelas.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold">
                            ← Kembali ke Daftar Kelas
                        </a>

                        <div class="flex space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Update Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>