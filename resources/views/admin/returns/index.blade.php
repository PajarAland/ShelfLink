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
                                <i class="fas fa-undo-alt mr-3 text-indigo-600"></i>
                                Manajemen Pengembalian Buku
                            </h1>
                            <p class="text-gray-600 mt-1">Kelola status pengembalian dan stok buku</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Section -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

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
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Nama Peminjam
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Judul Buku
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Tanggal Pinjam
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Batas Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($borrowings as $borrow)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $borrow->user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $borrow->book->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $borrow->borrow_date }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $borrow->return_deadline ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @if ($borrow->status === 'borrowed')
                                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                                    Dipinjam
                                                </span>
                                            @elseif ($borrow->status === 'returned')
                                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                    Dikembalikan
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                    Terlambat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            @if ($borrow->status === 'returned')
                                                {{-- Tombol Batalkan Pengembalian --}}
                                                <form action="{{ route('admin.returns.revert', $borrow->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        data-confirm="Yakin ingin membatalkan pengembalian buku ini?"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 transition">
                                                        <i class="fas fa-undo mr-1"></i> Batalkan Pengembalian
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Tombol Tandai Dikembalikan --}}
                                                <form action="{{ route('admin.returns.update', $borrow->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        data-confirm="Tandai buku ini sebagai sudah dikembalikan?"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 transition">
                                                        <i class="fas fa-check mr-1"></i> Tandai Dikembalikan
                                                    </button>
                                                </form>
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
                        <i class="fas fa-undo text-gray-400 text-6xl mb-4"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada peminjaman aktif</h3>
                        <p class="mt-2 text-sm text-gray-500">Semua buku telah dikembalikan atau belum ada transaksi.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Modal Konfirmasi -->
        <div id="confirmModal"
            class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
                <h2 class="text-lg font-semibold text-gray-900 mb-3" id="confirmTitle">Konfirmasi Aksi</h2>
                <p class="text-sm text-gray-600 mb-6" id="confirmMessage">Yakin ingin melanjutkan aksi ini?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelBtn"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Batal
                    </button>
                    <button id="confirmBtn"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>

        <!-- Script Modal -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let formToSubmit = null;

                // Tangkap semua tombol dengan atribut data-confirm
                document.querySelectorAll('[data-confirm]').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        formToSubmit = btn.closest('form');

                        const message = btn.dataset.confirm;
                        document.getElementById('confirmMessage').textContent = message;
                        document.getElementById('confirmModal').classList.remove('hidden');
                    });
                });

                // Tombol batal
                document.getElementById('cancelBtn').addEventListener('click', () => {
                    document.getElementById('confirmModal').classList.add('hidden');
                    formToSubmit = null;
                });

                // Tombol konfirmasi
                document.getElementById('confirmBtn').addEventListener('click', () => {
                    if (formToSubmit) formToSubmit.submit();
                });
            });
        </script>
    </main>
</x-app-layout>
