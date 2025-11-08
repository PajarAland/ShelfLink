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
                            <i class="fas fa-book mr-3 text-indigo-600"></i>
                            Katalog Buku ShelfLink
                        </h1>
                        <p class="text-gray-600 mt-1">Temukan buku favoritmu di sini 📚</p>
                    </div>
                    <form action="{{ route('catalog.index') }}" method="GET" class="w-full sm:w-80">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari buku, penulis, kategori..." 
                                   class="block w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Book Catalog -->
        @if ($books->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($books as $book)
                    <a href="{{ route('catalog.show', $book->id) }}" class="block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group">
                        <!-- Book Cover -->
                        <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                            @if ($book->cover)
                                <img src="{{ asset('storage/' . $book->cover) }}" 
                                    alt="{{ $book->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-book text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="p-4">
                            <h5 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition mb-1">
                                {{ $book->title }}
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">{{ $book->author }}</p>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $book->category ?? 'Umum' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $book->published_year ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="font-semibold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Stok: {{ $book->stock ?? 0 }}
                                </span>
                                <span class="text-gray-400">
                                    <i class="fas fa-copy mr-1"></i>1 copy
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $books->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-12 text-center">
                    <i class="fas fa-book-open text-gray-400 text-6xl mb-4"></i>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada buku ditemukan</h3>
                    <p class="mt-2 text-sm text-gray-500">Coba gunakan kata kunci lain untuk mencari buku.</p>
                    @if(request('search'))
                        <div class="mt-4">
                            <a href="{{ route('catalog.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                Tampilkan Semua Buku
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</main>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
</x-app-layout>