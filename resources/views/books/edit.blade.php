<x-app-layout>
@push('head')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-pen-to-square mr-3 text-blue-500"></i>
                Edit Buku
            </h1>
            <p class="text-gray-600 mt-2">Perbarui informasi buku yang sudah ada</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                
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
                            value="{{ old('title', $book->title) }}"
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
                    
                    <!-- Current Cover Preview -->
                    @if ($book->cover)
                    <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="text-sm text-gray-600 mb-2">Cover saat ini:</p>
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $book->cover) }}" 
                                 alt="Cover saat ini" 
                                 class="w-20 h-28 object-cover rounded-lg shadow-sm border">
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Biarkan kosong jika tidak ingin mengganti cover</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- New Cover Upload -->
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
                            <div id="cover-preview" class="hidden w-full h-full flex items-center justify-center relative">
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
                            value="{{ old('author', $book->author) }}"
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
                        <i class="fas fa-heading mr-2 text-blue-500"></i>
                        Kategori
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="category"
                            name="category" 
                            value="{{ old('category', $book->category) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Masukkan kategori buku"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-check-circle text-green-500 opacity-0 transition-opacity duration-200" id="category-check"></i>
                        </div>
                    </div>
                </div>

                <!-- <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-blue-500"></i>
                        Kategori
                    </label>
                    <div class="relative">
                        <select 
                            id="category"
                            name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none bg-white"
                            required
                        >
                            <option value="">Pilih Kategori</option>
                            <option value="Fiksi" {{ old('category', $book->category) == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Non-Fiksi" {{ old('category', $book->category) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                            <option value="Sains" {{ old('category', $book->category) == 'Sains' ? 'selected' : '' }}>Sains</option>
                            <option value="Teknologi" {{ old('category', $book->category) == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="Sejarah" {{ old('category', $book->category) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                            <option value="Biografi" {{ old('category', $book->category) == 'Biografi' ? 'selected' : '' }}>Biografi</option>
                            <option value="Pendidikan" {{ old('category', $book->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Anak" {{ old('category', $book->category) == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Lainnya" {{ old('category', $book->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div> -->

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
                    >{{ old('description', $book->description) }}</textarea>
                    <div class="flex justify-between mt-1 text-sm text-gray-500">
                        <span>Opsional</span>
                        <span id="char-count">{{ strlen(old('description', $book->description)) }} karakter</span>
                    </div>
                </div>

                <!-- Tahun Terbit Field -->
                <div class="mb-6">
                    <label for="published_year" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                        Tahun Terbit
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="published_year"
                            name="published_year" 
                            value="{{ old('published_year', $book->published_year) }}"
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

                <!-- Stock Field -->
                <div class="mb-8">
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-cubes mr-2 text-blue-500"></i>
                        Stok Buku
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="stock"
                            name="stock" 
                            value="{{ old('stock', $book->stock) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Jumlah stok buku"
                            min="0"
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
                        Simpan Perubahan
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
                <span>Buku berhasil diperbarui!</span>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Form validation and interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            const authorInput = document.getElementById('author');
            const descriptionInput = document.getElementById('description');
            const categoryInput = document.getElementById('category');
            const coverInput = document.getElementById('cover');
            const coverUploadArea = document.getElementById('cover-upload-area');
            const coverPreview = document.getElementById('cover-preview');
            const coverPreviewImage = document.getElementById('cover-preview-image');
            const removeCoverButton = document.getElementById('remove-cover');
            const charCount = document.getElementById('char-count');
            const titleCheck = document.getElementById('title-check');
            const authorCheck = document.getElementById('author-check');
            const successMessage = document.getElementById('success-message');
            const form = document.querySelector('form');
            
            // Initialize checkmarks if fields are pre-filled
            if (titleInput.value.trim().length > 0) {
                titleCheck.classList.remove('opacity-0');
            }
            
            if (authorInput.value.trim().length > 0) {
                authorCheck.classList.remove('opacity-0');
            }
            
            // Update character count for description
            descriptionInput.addEventListener('input', function() {
                charCount.textContent = this.value.length + ' karakter';
            });
            
            // Show checkmarks when required fields are filled
            titleInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    titleCheck.classList.remove('opacity-0');
                } else {
                    titleCheck.classList.add('opacity-0');
                }
            });
            
            authorInput.addEventListener('input', function() {
                if (this.value.trim().length > 0) {
                    authorCheck.classList.remove('opacity-0');
                } else {
                    authorCheck.classList.add('opacity-0');
                }
            });

            // Cover image preview functionality
            coverInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) { // 5MB limit
                        alert('Ukuran file maksimal 5MB');
                        coverInput.value = '';
                        return;
                    }

                    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                        alert('Hanya file JPG dan PNG yang diizinkan');
                        coverInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        coverPreviewImage.src = e.target.result;
                        coverUploadArea.classList.add('hidden');
                        coverPreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove cover image
            removeCoverButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                coverInput.value = '';
                coverPreview.classList.add('hidden');
                coverUploadArea.classList.remove('hidden');
            });

            // Drag and drop functionality for cover
            const dropArea = coverUploadArea.parentElement;
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            // function preventDefaults(e) {
            //     e.preventDefault();
            //     e.stopPropagation();
            // }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-50');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-50');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                coverInput.files = files;
                coverInput.dispatchEvent(new Event('change'));
            }
            
            // Form submission simulation
            form.addEventListener('submit', function(e) {
                // In real application, remove this preventDefault()
                // e.preventDefault();
                
                // Show success message
                successMessage.classList.remove('hidden');
                
                // Scroll to success message
                successMessage.scrollIntoView({ behavior: 'smooth' });
                
                // For demo purposes only - in real app, let the form submit normally
                // setTimeout(() => {
                //     successMessage.classList.add('hidden');
                // }, 3000);
            });
        });
    </script>
    @endpush
</x-app-layout>
