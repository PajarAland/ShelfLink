<x-app-layout>
    @push('head')
        <script src="https://cdn.tailwindcss.com"></script>
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

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Peminjam
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Buku
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Tanggal Pinjam
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Deadline
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Bukti Foto
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach ($borrowings as $borrow)

                                    <tr class="hover:bg-gray-50 transition">

                                        <!-- User -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $borrow->user->name }}
                                            </div>

                                        </td>

                                        <!-- Book -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-900">
                                                {{ $borrow->book->title }}
                                            </div>

                                        </td>

                                        <!-- Borrow Date -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}
                                            </div>

                                        </td>

                                        <!-- Deadline -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($borrow->return_deadline)->format('d M Y') }}
                                            </div>

                                        </td>

                                        <!-- Photos -->
                                        <td class="px-6 py-4">

                                            @if ($borrow->return_photos)

                                                <div class="flex gap-2 flex-wrap">

                                                    @foreach ($borrow->return_photos as $photo)

                                                        <a href="{{ asset('storage/' . $photo) }}"
                                                           target="_blank">

                                                            <img src="{{ asset('storage/' . $photo) }}"
                                                                 class="w-16 h-16 object-cover rounded border hover:scale-105 transition">

                                                        </a>

                                                    @endforeach

                                                </div>

                                            @else

                                                <span class="text-sm text-gray-400">
                                                    Belum upload
                                                </span>

                                            @endif

                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if ($borrow->status === 'pending')

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>

                                            @elseif ($borrow->status === 'returned')

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Returned
                                                </span>

                                            @elseif ($borrow->status === 'borrowed')

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Borrowed
                                                </span>

                                            @elseif ($borrow->status === 'overdue')

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Overdue
                                                </span>

                                            @endif

                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right">

                                            @if ($borrow->status === 'pending')

                                                <!-- Approve -->
                                                <form action="{{ route('admin.returns.update', $borrow->id) }}"
                                                      method="POST"
                                                      class="inline-flex items-center gap-2">

                                                    @csrf

                                                    <input type="number"
                                                           name="fine"
                                                           placeholder="Denda"
                                                           min="0"
                                                           class="w-24 px-2 py-1 text-sm border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                                                    <button type="submit"
                                                            onclick="return confirm('Approve pengembalian buku ini?')"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 transition">

                                                        <i class="fas fa-check mr-1"></i>
                                                        Approve

                                                    </button>

                                                </form>

                                                <!-- Reject -->
                                                <form action="{{ route('admin.returns.revert', $borrow->id) }}"
                                                      method="POST"
                                                      class="inline-block ml-2">

                                                    @csrf

                                                    <button type="submit"
                                                            onclick="return confirm('Tolak pengembalian buku ini?')"
                                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 transition">

                                                        <i class="fas fa-times mr-1"></i>
                                                        Reject

                                                    </button>

                                                </form>

                                            @elseif ($borrow->status === 'returned')

                                                <span class="text-sm text-green-600 font-medium">
                                                    Sudah dikembalikan
                                                </span>

                                            @else

                                                <span class="text-sm text-gray-400">
                                                    Menunggu user
                                                </span>

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

                        <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>

                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            Tidak ada pengembalian
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Belum ada data pengembalian buku yang perlu diverifikasi.
                        </p>

                    </div>

                </div>

            @endif

        </div>
    </main>
</x-app-layout>