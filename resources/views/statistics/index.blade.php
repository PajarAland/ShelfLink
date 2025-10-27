<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistik Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow rounded-xl p-6 text-center">
                    <h3 class="text-gray-500 text-sm">Total Buku</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $totalBooks }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-xl p-6 text-center">
                    <h3 class="text-gray-500 text-sm">User Terdaftar</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-xl p-6 text-center">
                    <h3 class="text-gray-500 text-sm">Peminjaman Aktif</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $activeBorrowings }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-xl p-6 text-center">
                    <h3 class="text-gray-500 text-sm">Telah Dikembalikan</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $returnedBorrowings }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Peminjaman per Bulan</h3>
                <canvas id="borrowChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('borrowChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                ],
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json(array_values($borrowChart->toArray())),
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
</x-app-layout>
