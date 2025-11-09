<x-app-layout>
    @push('head')
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @endpush
    
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-book-reader mr-3 text-indigo-600"></i>
                                Daftar Peminjaman Buku
                            </h1>
                            <p class="text-gray-600 mt-1">Kelola riwayat peminjaman buku perpustakaan</p>
                        </div>
                        <a href="{{ route('borrowings.create') }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 transition">
                            <i class="fas fa-plus mr-2"></i> Pinjam Buku
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Error Alert -->
            @if (session('error'))
                <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span class="text-red-800 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Borrowings Table -->
            @if ($borrowings->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Batas Pengembalian</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($borrowings as $borrow)
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Book Title -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $borrow->book->title }}</div>
                                        </td>

                                        <!-- Borrow Date -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}
                                            </div>
                                        </td>

                                        <!-- Return Deadline -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($borrow->return_deadline)->format('d M Y') }}
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($borrow->status === 'borrowed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Dipinjam
                                                </span>
                                            @elseif ($borrow->status === 'overdue')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Terlambat
                                                </span>
                                            @elseif ($borrow->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu Konfirmasi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Dikembalikan
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Action Buttons -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($borrow->status === 'borrowed' || $borrow->status === 'overdue')
                                                <form action="{{ route('borrowings.return', $borrow->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                                    @csrf
                                                    <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs font-semibold rounded hover:bg-yellow-600 transition">
                                                        <i class="fas fa-undo mr-1"></i> Kembalikan
                                                    </button>
                                                </form>
                                            @elseif ($borrow->status === 'pending')
                                                <span class="text-sm text-yellow-600 font-medium">Menunggu konfirmasi admin...</span>
                                            @else
                                                <span class="text-sm text-green-600 font-medium">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-12 text-center">
                        <i class="fas fa-book-open text-gray-400 text-6xl mb-4"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada peminjaman</h3>
                        <p class="mt-2 text-sm text-gray-500">Mulai dengan meminjam buku pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('borrowings.create') }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                <i class="fas fa-plus mr-2"></i> Pinjam Buku Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
</x-app-layout>
