<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @endpush

    <main class="py-8">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">

            <h1 class="text-2xl font-bold mb-6 text-gray-900 flex items-center">
                <i class="fas fa-camera mr-2 text-indigo-600"></i>
                Upload Bukti Kondisi Buku
            </h1>

            <div class="mb-6 bg-indigo-50 border border-indigo-100 p-4 rounded-lg">
                <h2 class="font-bold text-lg text-indigo-900">
                    {{ $borrowing->book->title }}
                </h2>

                <p class="text-sm text-indigo-700 mt-1">
                    Silakan unggah foto kondisi fisik buku dari 4 kategori berikut. Semua unggahan diperlukan untuk memproses pengembalian.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-4 mb-6 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('borrowings.return', $borrowing->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- 1. Cover Depan -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex flex-col justify-between hover:border-indigo-300 transition">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 tracking-wider uppercase block mb-1">Kategori 1</span>
                            <label class="block font-bold text-gray-800 mb-1">
                                <i class="fas fa-book-open text-indigo-500 mr-1.5"></i>
                                Cover Depan
                            </label>
                            <p class="text-xs text-gray-500 mb-4">Pastikan gambar cover depan terlihat jelas, bebas dari refleksi cahaya berlebih.</p>
                        </div>
                        <input type="file"
                               name="return_photos[]"
                               required
                               class="w-full border border-gray-300 rounded bg-white p-2 text-xs focus:ring-indigo-500 focus:ring-1 focus:outline-none">
                    </div>

                    <!-- 2. Cover Belakang -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex flex-col justify-between hover:border-indigo-300 transition">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 tracking-wider uppercase block mb-1">Kategori 2</span>
                            <label class="block font-bold text-gray-800 mb-1">
                                <i class="fas fa-book text-indigo-500 mr-1.5"></i>
                                Cover Belakang
                            </label>
                            <p class="text-xs text-gray-500 mb-4">Pastikan gambar cover belakang terlihat jelas dan menangkap seluruh bagian tepi.</p>
                        </div>
                        <input type="file"
                               name="return_photos[]"
                               required
                               class="w-full border border-gray-300 rounded bg-white p-2 text-xs focus:ring-indigo-500 focus:ring-1 focus:outline-none">
                    </div>

                    <!-- 3. Sisi Buku -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex flex-col justify-between hover:border-indigo-300 transition">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 tracking-wider uppercase block mb-1">Kategori 3</span>
                            <label class="block font-bold text-gray-800 mb-1">
                                <i class="fas fa-stream text-indigo-500 mr-1.5"></i>
                                Sisi Buku / Spine
                            </label>
                            <p class="text-xs text-gray-500 mb-4">Foto lipatan samping, ketebalan kertas, atau punggung buku untuk cek keretakan.</p>
                        </div>
                        <input type="file"
                               name="return_photos[]"
                               required
                               class="w-full border border-gray-300 rounded bg-white p-2 text-xs focus:ring-indigo-500 focus:ring-1 focus:outline-none">
                    </div>

                    <!-- 4. Isi Halaman -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 flex flex-col justify-between hover:border-indigo-300 transition">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 tracking-wider uppercase block mb-1">Kategori 4</span>
                            <label class="block font-bold text-gray-800 mb-1">
                                <i class="fas fa-file-alt text-indigo-500 mr-1.5"></i>
                                Isi Halaman
                            </label>
                            <p class="text-xs text-gray-500 mb-4">Ambil foto salah satu halaman acak di bagian dalam untuk memverifikasi coretan/sobekan.</p>
                        </div>
                        <input type="file"
                               name="return_photos[]"
                               required
                               class="w-full border border-gray-300 rounded bg-white p-2 text-xs focus:ring-indigo-500 focus:ring-1 focus:outline-none">
                    </div>
                </div>

                <div class="flex justify-between items-center border-t pt-6">
                    <a href="{{ route('borrowings.index') }}" 
                       class="text-sm font-medium text-gray-600 hover:text-gray-900 transition flex items-center">
                        <i class="fas fa-arrow-left mr-1.5"></i>
                        Batal
                    </a>
                    
                    <button type="submit"
                            class="bg-indigo-600 text-white font-semibold px-6 py-2.5 rounded-lg shadow hover:bg-indigo-700 hover:shadow-md transition flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Pengembalian
                    </button>
                </div>

            </form>

        </div>
    </main>
</x-app-layout>