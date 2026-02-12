<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Penilaian Kebersihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500 uppercase font-bold">Total Kelas</div>
                    <div class="text-2xl font-semibold">{{ $jumlah_kelas ?? 0 }}</div>
                </div>

                {{-- Bagian 🏆 3 Terbersih Pekan Ini --}}
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-sm text-gray-500 uppercase font-bold mb-2">🏆 3 Terbersih Pekan Ini</div>
                    @forelse($terbersih as $item)
                        <div class="mb-1">
                            <span class="text-lg font-semibold">{{ $item->kelas->nama_kelas ?? 'N/A' }}</span>
                            <span class="text-xs text-green-600 font-bold ml-1">(Skor: {{ $item->skor_total }})</span>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400">Belum ada data</div>
                    @endforelse
                </div>

                {{-- Bagian ⚠️ Perlu Perhatian (Terkotor) --}}
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-sm text-gray-500 uppercase font-bold mb-2">⚠️ Perlu Perhatian (Terkotor)</div>
                    @forelse($terkotor as $item)
                        <div class="mb-1">
                            <span class="text-lg font-semibold">{{ $item->kelas->nama_kelas ?? 'N/A' }}</span>
                            <span class="text-xs text-red-600 font-bold ml-1">(Skor: {{ $item->skor_total }})</span>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400">Belum ada data</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Grafik Perkembangan Kebersihan Mingguan</h3>
                <canvas id="kebersihanChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kebersihanChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                datasets: [{
                    label: 'Rata-rata Skor Sekolah',
                    // BAGIAN UPDATE: Mengambil data dinamis dari Controller
                    data: @json($grafik), 
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        min: 0, 
                        max: 100 
                    }
                }
            }
        });
    </script>
</x-app-layout>