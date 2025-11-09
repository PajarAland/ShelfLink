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
                            <i class="fas fa-book-open mr-3 text-indigo-600"></i>
                            Detail Buku
                        </h1>
                        <p class="text-gray-600 mt-1">Informasi lengkap tentang buku 📖</p>
                    </div>
                    <a href="{{ route('catalog.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>

        <!-- Book Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Book Cover & Basic Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" 
                                 alt="{{ $book->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-book text-6xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="p-6">
                        <form action="{{ route('borrowings.store', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $book->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-book-open mr-2"></i> 
                                {{ $book->stock > 0 ? 'Pinjam Buku' : 'Stok Habis' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Book Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>

                        <!-- Book Metadata -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-user-edit text-indigo-600 mr-3"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Penulis</p>
                                    <p class="font-medium text-gray-900">{{ $book->author ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-calendar text-indigo-600 mr-3"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Tahun Terbit</p>
                                    <p class="font-medium text-gray-900">{{ $book->published_year ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-layer-group text-indigo-600 mr-3"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Kategori</p>
                                    <p class="font-medium text-gray-900">{{ $book->category ?? 'Umum' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="fas fa-copy text-indigo-600 mr-3"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Stok Tersedia</p>
                                    <p class="font-medium text-gray-900 {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $book->stock ?? 0 }} buku
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-align-left mr-2 text-indigo-600"></i>
                                Deskripsi Buku
                            </h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $book->description ?? 'Tidak ada deskripsi tersedia untuk buku ini.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-star mr-3 text-yellow-400"></i>
                        Ulasan Buku
                    </h2>
                    <p class="text-gray-600 mt-1">Bagikan pendapatmu tentang buku ini ⭐</p>
                </div>

                <!-- Add Review Form -->
                <div class="p-6 border-b border-gray-200">
                    @auth
                        <form action="{{ route('reviews.store', $book->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <div class="sm:w-48">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <select name="rating" class="w-full border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                        <option value="5">★★★★★ - Sangat Keren</option>
                                        <option value="4">★★★★☆ - Bagus</option>
                                        <option value="3">★★★☆☆ - Cukup</option>
                                        <option value="2">★★☆☆☆ - Kurang</option>
                                        <option value="1">★☆☆☆☆ - Buruk</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ulasan</label>
                                    <textarea name="comment" rows="3" 
                                              class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition"
                                              placeholder="Bagikan pengalaman membaca buku ini..."></textarea>
                                </div>
                            </div>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Ulasan
                            </button>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-lock text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-600">
                                Silakan <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">login</a> 
                                untuk menulis ulasan
                            </p>
                        </div>
                    @endauth
                </div>

                <!-- Reviews List -->
                <div class="p-6">
                    @if($reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($reviews as $review)
                                <div class="bg-gray-50 rounded-lg p-5 hover:shadow-sm transition group">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                                <div class="flex items-center text-yellow-400 text-sm">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                                    @endfor
                                                    <span class="ml-2 text-gray-500 text-xs">{{ $review->rating }}/5</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-comment-slash text-gray-400 text-4xl mb-3"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ulasan</h3>
                            <p class="text-gray-500 text-sm">Jadilah yang pertama mengulas buku ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</main>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
</x-app-layout>