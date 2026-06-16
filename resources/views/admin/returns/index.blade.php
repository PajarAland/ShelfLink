<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @endpush

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
                <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-undo-alt mr-3 text-indigo-600"></i>
                            Manajemen Pengembalian Buku
                        </h1>

                        <p class="text-gray-600 mt-1">
                            Kelola approval pengembalian buku dan verifikasi kondisi buku.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>

                    <span class="text-green-800 font-medium">
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            <!-- Error Alert -->
            @if (session('error'))
                <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>

                    <span class="text-red-800 font-medium">
                        {{ session('error') }}
                    </span>
                </div>
            @endif

            <!-- Table -->
            @if ($borrowings->count() > 0)

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1 text-gray-400"></i>
                                        Peminjam
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-book mr-1 text-gray-400"></i>
                                        Buku
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                        Tanggal Pinjam
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-hourglass-half mr-1 text-gray-400"></i>
                                        Deadline
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-images mr-1 text-gray-400"></i>
                                        Bukti Foto
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-brain mr-1 text-gray-400"></i>
                                        Analisis AI
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-tag mr-1 text-gray-400"></i>
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1 text-gray-400"></i>
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="bg-white divide-y divide-gray-100">

                                @foreach ($borrowings as $borrow)

                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">

                                        <!-- User -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                    <span class="text-indigo-600 text-sm font-medium">
                                                        {{ strtoupper(substr($borrow->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $borrow->user->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        ID: {{ $borrow->user->id }}
                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                        <!-- Book -->
                                        <td class="px-6 py-4">

                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $borrow->book->title }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                {{ $borrow->book->author ?? 'Penulis tidak tersedia' }}
                                            </div>

                                        </td>

                                        <!-- Borrow Date -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-700">
                                                {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('H:i') }}
                                            </div>

                                        </td>

                                        <!-- Deadline -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-700">
                                                {{ \Carbon\Carbon::parse($borrow->return_deadline)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($borrow->return_deadline)->format('H:i') }}
                                            </div>

                                            @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($borrow->return_deadline)) && !in_array($borrow->status, ['returned', 'pending']))
                                                <span class="inline-flex items-center mt-1 px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">
                                                    <i class="fas fa-clock mr-0.5 text-red-500 text-xs"></i>
                                                    Terlambat
                                                </span>
                                            @endif

                                        </td>

                                        <!-- Photos -->
                                        <td class="px-6 py-4">

                                            @if ($borrow->return_photos)

                                                <div class="flex gap-2 flex-wrap">

                                                    @foreach ($borrow->return_photos as $index => $photo)

                                                        <a href="{{ asset('storage/' . $photo) }}"
                                                           target="_blank"
                                                           class="relative group/photo">

                                                            <img src="{{ asset('storage/' . $photo) }}"
                                                                 class="w-14 h-14 object-cover rounded-lg border-2 border-gray-200 hover:border-indigo-400 transition-all duration-200 shadow-sm hover:shadow-md">

                                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover/photo:bg-opacity-30 rounded-lg transition-all duration-200 flex items-center justify-center">
                                                                <i class="fas fa-search-plus text-white text-xs opacity-0 group-hover/photo:opacity-100 transition-opacity"></i>
                                                            </div>

                                                        </a>

                                                    @endforeach

                                                </div>

                                            @else

                                                <div class="flex items-center">
                                                    <i class="fas fa-cloud-upload-alt text-gray-300 mr-1 text-sm"></i>
                                                    <span class="text-sm text-gray-400">
                                                        Belum upload
                                                    </span>
                                                </div>

                                            @endif

                                        </td>

                                        <!-- AI Analysis -->
                                        <td class="px-6 py-4">
                                            @if ($borrow->status === 'pending' || $borrow->status === 'returned')
                                                @if ($borrow->ai_damage_detected === null)
                                                    <div class="flex items-center">
                                                        <div class="animate-pulse flex items-center">
                                                            <div class="h-2 w-2 bg-gray-300 rounded-full mr-1"></div>
                                                            <span class="text-sm text-gray-400">Belum dianalisis</span>
                                                        </div>
                                                    </div>
                                                @elseif ($borrow->ai_damage_detected)
                                                    <div class="space-y-2">
                                                        <div class="flex items-start">
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-red-50 to-red-100 text-red-700 border border-red-200">
                                                                <i class="fas fa-exclamation-triangle mr-1.5 text-red-500 text-xs"></i>
                                                                Terdeteksi Rusak
                                                                <span class="ml-1.5 bg-red-200 text-red-800 rounded-full px-1.5 py-0.5 text-xs font-bold">
                                                                    {{ intval($borrow->ai_confidence * 100) }}%
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="bg-amber-50 p-2 rounded-md border border-amber-100">
                                                            <p class="text-xs text-amber-700 leading-relaxed" title="{{ $borrow->ai_damage_details }}">
                                                                <i class="fas fa-clipboard-list mr-1 text-amber-500"></i>
                                                                {{ Str::limit($borrow->ai_damage_details, 60) }}
                                                            </p>
                                                            <p class="text-xs font-bold text-amber-700 mt-1">
                                                                <i class="fas fa-coins mr-1 text-amber-500"></i>
                                                                Denda: <span class="font-mono">Rp{{ number_format($borrow->ai_suggested_fine, 0, ',', '.') }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="space-y-2">
                                                        <div class="flex items-start">
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-50 to-green-100 text-green-700 border border-green-200">
                                                                <i class="fas fa-check-circle mr-1.5 text-green-500 text-xs"></i>
                                                                Kondisi Baik
                                                                <span class="ml-1.5 bg-green-200 text-green-800 rounded-full px-1.5 py-0.5 text-xs font-bold">
                                                                    {{ intval($borrow->ai_confidence * 100) }}%
                                                                </span>
                                                            </span>
                                                        </div>
                                                        <div class="bg-gray-50 p-2 rounded-md border border-gray-100">
                                                            <p class="text-xs text-gray-500 leading-relaxed">
                                                                <i class="fas fa-smile mr-1 text-gray-400"></i>
                                                                {{ Str::limit($borrow->ai_damage_details, 60) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="flex items-center text-gray-400">
                                                    <i class="fas fa-minus-circle mr-1 text-xs"></i>
                                                    <span class="text-sm">-</span>
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if ($borrow->status === 'pending')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                    <i class="fas fa-spinner fa-pulse mr-1.5 text-yellow-500"></i>
                                                    Pending
                                                </span>

                                            @elseif ($borrow->status === 'returned')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                                    <i class="fas fa-check-double mr-1.5 text-green-500"></i>
                                                    Returned
                                                </span>

                                            @elseif ($borrow->status === 'borrowed')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                    <i class="fas fa-book-open mr-1.5 text-blue-500"></i>
                                                    Borrowed
                                                </span>

                                            @elseif ($borrow->status === 'overdue')

                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                                    <i class="fas fa-exclamation-circle mr-1.5 text-red-500"></i>
                                                    Overdue
                                                </span>

                                            @endif

                                        </td

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">

                                            @if ($borrow->status === 'pending')

                                                <div class="flex flex-col items-center gap-2">
                                                    <!-- Approve Form -->
                                                    <form id="approve-form-{{ $borrow->id }}" 
                                                          action="{{ route('admin.returns.update', $borrow->id) }}"
                                                          method="POST"
                                                          class="w-full">

                                                        @csrf

                                                        <div class="flex flex-col gap-2">
                                                            <!-- Fine Input with label -->
                                                            <div class="w-full">
                                                                <label class="block text-xs text-gray-500 mb-1 text-left">
                                                                    <i class="fas fa-money-bill-wave mr-1 text-gray-400"></i>
                                                                    Denda (Rp)
                                                                </label>
                                                                <div class="relative">
                                                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">Rp</span>
                                                                    <input type="number"
                                                                           name="fine"
                                                                           placeholder="0"
                                                                           value="{{ $borrow->ai_suggested_fine }}"
                                                                           min="0"
                                                                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                                                                           title="Rekomendasi denda AI: Rp{{ number_format($borrow->ai_suggested_fine, 0, ',', '.') }}">
                                                                </div>
                                                                @if($borrow->ai_suggested_fine > 0)
                                                                    <p class="text-xs text-amber-600 mt-1 text-left">
                                                                        <i class="fas fa-robot mr-1"></i>
                                                                        Rekomendasi AI: Rp{{ number_format($borrow->ai_suggested_fine, 0, ',', '.') }}
                                                                    </p>
                                                                @endif
                                                            </div>

                                                            <!-- Action Buttons -->
                                                            <div class="flex gap-2 mt-1">
                                                                <button type="submit"
                                                                        onclick="return confirm('Approve pengembalian buku ini?')"
                                                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-semibold rounded-lg text-green-700 bg-green-50 border border-green-200 hover:bg-green-100 hover:border-green-300 transition-all duration-200">
                                                                    <i class="fas fa-check mr-1"></i>
                                                                    Approve
                                                                </button>

                                                                <button type="button"
                                                                        onclick="if(confirm('Tolak pengembalian buku ini?')) { document.getElementById('reject-form-{{ $borrow->id }}').submit(); }"
                                                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-semibold rounded-lg text-red-700 bg-red-50 border border-red-200 hover:bg-red-100 hover:border-red-300 transition-all duration-200">
                                                                    <i class="fas fa-times mr-1"></i>
                                                                    Reject
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <!-- Reject Form (Separate) -->
                                                    <form id="reject-form-{{ $borrow->id }}"
                                                          action="{{ route('admin.returns.revert', $borrow->id) }}"
                                                          method="POST"
                                                          class="hidden">
                                                        @csrf
                                                    </form>
                                                </div>

                                            @elseif ($borrow->status === 'returned')

                                                <div class="flex flex-col items-center gap-1">
                                                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                                                    <span class="text-xs text-green-600 font-medium">
                                                        Dikembalikan
                                                    </span>
                                                </div>

                                            @else

                                                <div class="flex flex-col items-center gap-1">
                                                    <i class="fas fa-hourglass-half text-gray-300 text-2xl"></i>
                                                    <span class="text-xs text-gray-400">
                                                        Menunggu user
                                                    </span>
                                                </div>

                                            @endif

                                        </td

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <!-- Optional: Add pagination links if needed -->
                    @if(method_exists($borrowings, 'links'))
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                            {{ $borrowings->links() }}
                        </div>
                    @endif

                </div>

            @else

                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">

                    <div class="p-12 text-center">

                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box-open text-gray-300 text-5xl"></i>
                        </div>

                        <h3 class="mt-4 text-lg font-semibold text-gray-900">
                            Tidak ada pengembalian
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 max-w-sm mx-auto">
                            Belum ada data pengembalian buku yang perlu diverifikasi.
                        </p>

                    </div>

                </div>

            @endif

        </div>
    </main>
</x-app-layout>