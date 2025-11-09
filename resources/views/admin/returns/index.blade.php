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
                        <p class="text-gray-600 mt-1">Kelola pengembalian buku dan denda peminjaman</p>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-50 border border-green-200 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Borrowings Table -->
            @if ($borrowings->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul Buku</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Batas Waktu</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($borrowings as $borrow)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $borrow->user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $borrow->book->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $borrow->borrow_date }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $borrow->return_deadline ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            @if ($borrow->status === 'returned')
                                                <form action="{{ route('admin.returns.revert', $borrow->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 transition">
                                                        <i class="fas fa-undo mr-1"></i> Batalkan Pengembalian
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.returns.update', $borrow->id) }}" method="POST"
                                                    class="inline-flex items-center gap-2 return-form">
                                                    @csrf
                                                    <input type="number" name="fine" placeholder="Denda (Rp)" min="0"
                                                        class="w-28 px-2 py-1 text-sm border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                                        title="Isi jika ada denda kerusakan buku">

                                                    <button type="button"
                                                        onclick="openConfirmModal(this)"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 transition">
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
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-12 text-center">
                        <i class="fas fa-undo text-gray-400 text-6xl mb-4"></i>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada peminjaman aktif</h3>
                        <p class="mt-2 text-sm text-gray-500">Semua buku telah dikembalikan atau belum ada transaksi.</p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Custom Modal -->
    <div id="confirmModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Pengembalian</h2>
            <p id="confirmMessage" class="text-gray-700 mb-6"></p>
            <div class="flex justify-center space-x-3">
                <button id="cancelBtn"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Batal</button>
                <button id="confirmBtn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Konfirmasi</button>
            </div>
        </div>
    </div>

    <script>
        let currentForm = null;

        function openConfirmModal(button) {
            const form = button.closest('.return-form');
            const fineInput = form.querySelector('input[name="fine"]');
            const fine = parseInt(fineInput.value) || 0;
            const messageEl = document.getElementById('confirmMessage');

            const fineFormatted = fine.toLocaleString('id-ID');
            messageEl.innerHTML = fine > 0
                ? `Apakah kamu yakin ingin menandai buku ini sebagai sudah dikembalikan?<br><br><strong>Denda:</strong> Rp ${fineFormatted}`
                : `Apakah kamu yakin ingin menandai buku ini sebagai sudah dikembalikan?<br><br><em>Tidak ada denda yang diterapkan.</em>`;

            currentForm = form;
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        document.getElementById('cancelBtn').addEventListener('click', () => {
            document.getElementById('confirmModal').classList.add('hidden');
        });

        document.getElementById('confirmBtn').addEventListener('click', () => {
            if (currentForm) currentForm.submit();
            document.getElementById('confirmModal').classList.add('hidden');
        });
    </script>
</x-app-layout>
