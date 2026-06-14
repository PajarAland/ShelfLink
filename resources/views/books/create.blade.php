<x-app-layout>
@push('head')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-book-medical mr-3 text-blue-500"></i>
                Tambah Buku Baru
            </h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Judul Field -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2 text-blue-500"></i>
                        Judul Buku
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="title"
                            name="title" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Masukkan judul buku"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-check-circle text-green-500 opacity-0 transition-opacity duration-200" id="title-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Cover Field -->
                <div class="mb-6">
                    <label for="cover" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-blue-500"></i>
                        Cover Buku
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="cover" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" id="cover-upload-area">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                <p class="mb-1 text-sm text-gray-500">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG (MAX. 5MB)</p>
                            </div>
                            <input 
                                id="cover" 
                                name="cover" 
                                type="file" 
                                class="hidden" 
                                accept=".png,.jpg,.jpeg"
                            />
                            <div id="cover-preview" class="hidden w-full h-full flex items-center justify-center">
                                <img id="cover-preview-image" class="max-h-24 max-w-full rounded object-contain" />
                                <button type="button" id="remove-cover" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors duration-200">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Penulis Field -->
                <div class="mb-6">
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                        Penulis
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="author"
                            name="author" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Nama penulis buku"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-check-circle text-green-500 opacity-0 transition-opacity duration-200" id="author-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Category Field -->
                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                        Kategori
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="category"
                            name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Kategori buku"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-check-circle text-green-500 opacity-0 transition-opacity duration-200" id="category-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Field -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-500"></i>
                        Deskripsi Buku
                    </label>
                    <textarea 
                        id="description"
                        name="description" 
                        rows="4" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                        placeholder="Tulis deskripsi singkat tentang buku ini"
                    ></textarea>
                    <div class="flex justify-between mt-1 text-sm text-gray-500">
                        <span>Opsional</span>
                        <span id="char-count">0 karakter</span>
                    </div>
                </div>

                <!-- Tahun Terbit Field -->
                <div class="mb-8">
                    <label for="published_year" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                        Tahun Terbit
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="published_year"
                            name="published_year" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Tahun terbit buku"
                            min="1000" 
                            max="9999"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-history text-blue-500"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Contoh: 2023</p>
                </div>

                <!-- Barcode Field -->
<div class="mb-6">
    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-barcode mr-2 text-blue-500"></i>
        Barcode Buku / ISBN
    </label>

    <!-- Barcode Input -->
    <div class="relative">
        <input 
            type="text" 
            id="barcode"
            name="barcode" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
            placeholder="Upload foto barcode buku"
            required
        >

        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="fas fa-barcode text-blue-500"></i>
        </div>
    </div>

    <!-- Upload Barcode -->
    <div class="mt-4">
        <label 
            for="barcodeImage" 
            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200"
        >

            <div class="flex flex-col items-center justify-center pt-5 pb-6" id="barcode-upload-area">
                <i class="fas fa-barcode text-gray-400 text-2xl mb-2"></i>

                <p class="mb-1 text-sm text-gray-500">
                    <span class="font-semibold">Klik untuk upload</span> foto barcode
                </p>

                <p class="text-xs text-gray-500">
                    JPG, PNG barcode buku / ISBN
                </p>
            </div>

            <input
                id="barcodeImage"
                type="file"
                class="hidden"
                accept="image/*"
            />

        </label>
    </div>

    <p class="mt-2 text-sm text-gray-500">
        Upload foto barcode belakang buku untuk auto detect ISBN
    </p>
</div>

                <!-- Stock Field -->
                <div class="relative">
                        <input 
                            type="number" 
                            id="stock"
                            name="stock" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Jumlah stok buku"
                            min="0"
                            value="1"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-boxes text-blue-500"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Jumlah buku yang tersedia</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Simpan Buku
                    </button>
                    <a 
                        href="{{ route('books.index') }}" 
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                    >
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>

        <!-- Success Message (Hidden by default) -->
        <div id="success-message" class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg hidden transition-all duration-300">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Buku berhasil ditambahkan!</span>
            </div>
        </div>
    </div>

    @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const coverInput = document.getElementById('cover');
    const previewArea = document.getElementById('cover-preview');
    const uploadArea = document.getElementById('cover-upload-area');
    const previewImage = document.getElementById('cover-preview-image');
    const removeButton = document.getElementById('remove-cover');

    // Saat user pilih file
    coverInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewArea.classList.remove('hidden');
                uploadArea.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Tombol hapus cover
    removeButton.addEventListener('click', function(e) {
        e.preventDefault();
        coverInput.value = '';
        previewArea.classList.add('hidden');
        uploadArea.classList.remove('hidden');
    });

    // Deskripsi counter
    const desc = document.getElementById('description');
    const charCount = document.getElementById('char-count');
    desc.addEventListener('input', () => {
        charCount.textContent = desc.value.length + ' karakter';
    });
});
</script>
<!-- QUAGGA BARCODE SCANNER -->
<script src="https://cdn.jsdelivr.net/npm/quagga/dist/quagga.min.js"></script>

<script>

    const barcodeInput = document.getElementById('barcode');
    const barcodeImage = document.getElementById('barcodeImage');

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

                    barcodeInput.value = result.codeResult.code;

                    // UPDATE UI
                    document.getElementById('barcode-upload-area').innerHTML = `
                        <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                        <p class="text-sm text-green-600 font-semibold">
                            Barcode berhasil dibaca
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            ${result.codeResult.code}
                        </p>
                    `;

                } else {

                    alert('Barcode gagal dibaca');

                }

            });

        };

        reader.readAsDataURL(file);

    });

</script>
@endpush
</x-app-layout>