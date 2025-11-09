<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistik Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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

            
            {{-- Average durasi peminjaman --}}
            <div class="bg-white overflow-hidden shadow rounded-xl p-6 text-center">
                <h3 class="text-gray-500 text-sm mb-2">Rata-Rata Durasi Peminjaman</h3>
                <p class="text-4xl font-bold text-purple-600">{{ number_format($averageBorrowDuration, 1) }} <span class="text-lg font-normal">hari</span></p>
            </div>

            {{-- Leaderboard--}}
            <div class="bg-white overflow-hidden shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Leaderboard Peminjam Terbanyak</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peringkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Buku Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($leaderboard as $index => $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                    #{{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $user->total_borrowed }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
