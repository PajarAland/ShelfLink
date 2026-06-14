<x-app-layout>
    @push('head')
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script src="//unpkg.com/alpinejs" defer></script>
    @endpush

    <main class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-hand-holding-book mr-3 text-indigo-600"></i>
                                Form Peminjaman Buku
                            </h1>
                            <p class="text-gray-600 mt-1">Pinjam buku dari koleksi perpustakaan</p>
                        </div>
                        <a href="{{ route('borrowings.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Error Alert -->
            @if (session('error'))
                <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span class="text-red-800 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Form Section -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('borrowings.store') }}" method="POST" 
                          class="space-y-6" 
                          x-data="{ search: '', selectedBook: null, books: @js($books) }">
                        @csrf

                        <!-- Book Search -->
                         <!-- Upload Barcode -->
<div class="mb-5">

    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Scan Barcode Buku
    </label>

    <label 
        for="barcodeImage"
        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition"
    >

        <div 
            id="barcode-upload-area"
            class="flex flex-col items-center justify-center"
        >
            <i class="fas fa-barcode text-3xl text-indigo-500 mb-2"></i>

            <p class="text-sm text-gray-600 font-medium">
                Klik untuk upload foto barcode
            </p>

            <p class="text-xs text-gray-400 mt-1">
                Barcode buku / ISBN
            </p>
        </div>

        <input
            id="barcodeImage"
            type="file"
            accept="image/*"
            class="hidden"
        >
    </label>

</div>

<!-- Camera Scanner -->
<div class="mt-4">

    <button
        type="button"
        id="startScannerBtn"
        class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition"
    >
        <i class="fas fa-camera mr-2"></i>
        Scan Barcode via Camera
    </button>

    <!-- CAMERA PREVIEW -->
    <!-- CAMERA PREVIEW -->
<div 
    id="scanner-container"
    class="hidden mt-4 overflow-hidden rounded-xl border border-gray-300"
>

    <div
        id="scanner-video"
        class="w-full min-h-[300px] bg-black"
    ></div>

</div>

</div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Cari Buku <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="relative">
                                <input type="text" 
                                       x-model="search" 
                                       placeholder="Ketik judul buku..."
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 border">
                                
                                <input type="hidden" name="book_id" :value="selectedBook?.id">

                                <!-- Search Results Dropdown -->
                                <div x-show="search.length > 0" 
                                     x-transition
                                     class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                    <template x-for="book in books.filter(b => b.title.toLowerCase().includes(search.toLowerCase()))" :key="book.id">
                                        <div @click="selectedBook = book; search = book.title"
                                             class="px-4 py-3 cursor-pointer hover:bg-indigo-50 border-b border-gray-100 last:border-b-0 transition">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-900" x-text="book.title"></span>
                                                <span class="text-sm px-2 py-1 rounded-full" 
                                                      :class="book.stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                                      x-text="book.stock > 0 ? 'Stok: ' + book.stock : 'Stok habis'">
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1" x-text="book.author"></p>
                                        </div>
                                    </template>
                                    <div x-show="books.filter(b => b.title.toLowerCase().includes(search.toLowerCase())).length === 0"
                                         class="px-4 py-3 text-gray-500 text-center">
                                        <i class="fas fa-search mr-2"></i>Tidak ada buku yang ditemukan
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Book Info -->
                            <template x-if="selectedBook">
                                <div class="mt-3 p-4 bg-indigo-50 border border-indigo-200 rounded-md">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-indigo-800" x-text="selectedBook.title"></p>
                                            <p class="text-sm text-indigo-600" x-text="selectedBook.author"></p>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-check mr-1"></i> Terpilih
                                        </span>
                                    </div>
                                </div>
                            </template>

                            @error('book_id')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Borrow Date -->
                        <div>
                            <label for="borrow_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Pinjam <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="borrow_date" 
                                   id="borrow_date" 
                                   value="{{ old('borrow_date', now()->toDateString()) }}"
                                   required
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 px-4 border">
                            @error('borrow_date')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 rounded-md bg-yellow-50 border border-yellow-200">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5 mr-3"></i>
                                <div>
                                    <p class="text-sm text-yellow-800 font-medium">Peraturan Peminjaman</p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Buku harus dikembalikan dalam waktu <strong>14 hari</strong> sejak tanggal pinjam. 
                                        Keterlambatan pengembalian akan dikenakan denda.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 pt-4">
                            <a href="{{ route('borrowings.index') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                <i class="fas fa-save mr-2"></i> Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
<!-- QUAGGA BARCODE -->
<script src="https://cdn.jsdelivr.net/npm/quagga/dist/quagga.min.js"></script>

<script>

    const barcodeImage = document.getElementById('barcodeImage');

    const startScannerBtn = document.getElementById('startScannerBtn');
    const scannerContainer = document.getElementById('scanner-container');
    const scannerVideo = document.getElementById('#scanner-video');

    /*
    |--------------------------------------------------------------------------
    | FUNCTION FETCH BOOK
    |--------------------------------------------------------------------------
    */

    function fetchBookByBarcode(barcode) {

        console.log('BARCODE:', barcode);

        fetch(`/books/barcode/${barcode}`)
            .then(response => response.json())
            .then(data => {

                console.log('FETCH RESULT:', data);

                if (data.success) {

                    // SET BOOK ID
                    document.querySelector('input[name="book_id"]').value = data.book.id;

                    // SET SEARCH INPUT
                    const searchInput = document.querySelector('input[x-model="search"]');

                    if (searchInput) {
                        searchInput.value = data.book.title;
                    }

                    // UPDATE UI
                    document.getElementById('barcode-upload-area').innerHTML = `
                        <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>

                        <p class="text-sm text-green-600 font-semibold">
                            Buku ditemukan
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            ${data.book.title}
                        </p>
                    `;

                } else {

                    alert('Barcode ditemukan tapi buku tidak ada di database');

                }

            })
            .catch(error => {

                console.error(error);

                alert('Gagal mengambil data buku');

            });

    }

    /*
    |--------------------------------------------------------------------------
    | IMAGE SCAN
    |--------------------------------------------------------------------------
    */

    barcodeImage.addEventListener('change', (event) => {

        const file = event.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {

            Quagga.decodeSingle({

                src: e.target.result,

                numOfWorkers: 0,

                inputStream: {
                    size: 1200
                },

                locator: {
                    patchSize: "large",
                    halfSample: false
                },

                decoder: {
                    readers: [
                        "ean_reader",
                        "ean_8_reader",
                        "upc_reader",
                        "upc_e_reader",
                        "code_128_reader"
                    ]
                },

                locate: true

            }, function(result) {

                console.log('RESULT:', result);

                if (result && result.codeResult) {

                    fetchBookByBarcode(result.codeResult.code);

                } else {

                    alert('Barcode gagal dibaca');

                }

            });

        };

        reader.readAsDataURL(file);

    });

    /*
    |--------------------------------------------------------------------------
    | CAMERA SCAN
    |--------------------------------------------------------------------------
    */

    startScannerBtn.addEventListener('click', () => {

        scannerContainer.classList.remove('hidden');

        Quagga.init({

            inputStream: {
                type: "LiveStream",

                target: document.querySelector('#scanner-video'),

                constraints: {
                    facingMode: "environment",
                    width: 1280,
                    height: 720
                }
            },

            locator: {
                patchSize: "large",
                halfSample: false
            },

            numOfWorkers: navigator.hardwareConcurrency || 4,

            decoder: {
                readers: [
                    "ean_reader",
                    "ean_8_reader",
                    "upc_reader",
                    "upc_e_reader",
                    "code_128_reader"
                ]
            },

            locate: true

        }, function(err) {

            if (err) {

                console.error(err);

                alert('Camera gagal diakses');

                return;

            }

            console.log('Quagga started');

            Quagga.start();

        });

    });

    /*
    |--------------------------------------------------------------------------
    | DETECT BARCODE CAMERA
    |--------------------------------------------------------------------------
    */

    Quagga.onDetected(function(result) {

        const barcode = result.codeResult.code;

        console.log('CAMERA BARCODE:', barcode);

        // STOP CAMERA
        Quagga.stop();

        scannerContainer.classList.add('hidden');

        // FETCH BOOK
        fetchBookByBarcode(barcode);

    });

</script>
@endpush
</x-app-layout>