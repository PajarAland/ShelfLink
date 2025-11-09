<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-lg font-semibold text-gray-800">{{ now()->format('F j, Y') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="p-6 space-y-8">
        <!-- Animated Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Books -->
            <!-- <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-500">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-white/5 rounded-full"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-book-open text-2xl opacity-80"></i>
                        <div class="text-white/60 text-sm">Total</div>
                    </div>
                    <h3 class="text-4xl font-bold mb-2">{{ $bookCount }}</h3>
                    <p class="text-blue-100 font-medium">Books in Library</p>
                    <div class="mt-3 w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2" style="width: 85%"></div>
                    </div>
                </div>
            </div> -->

            <!-- Registered Readers -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-500">
                <div class="absolute -left-6 -top-6 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -left-2 -bottom-2 w-16 h-16 bg-white/5 rounded-full"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-users text-2xl opacity-80"></i>
                        <div class="text-white/60 text-sm">Active</div>
                    </div>
                    <h3 class="text-4xl font-bold mb-2">{{ $readerCount }}</h3>
                    <p class="text-purple-100 font-medium">Registered Readers</p>
                    <div class="mt-3 w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2" style="width: {{ $readerPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Borrowed Books -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-500">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -left-2 -top-2 w-16 h-16 bg-white/5 rounded-full"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-bookmark text-2xl opacity-80"></i>
                        <div class="text-white/60 text-sm">Currently</div>
                    </div>
                    <h3 class="text-4xl font-bold mb-2">{{ \App\Models\Borrowing::where('status', 'borrowed')->count() }}</h3>
                    <p class="text-green-100 font-medium">Books Borrowed</p>
                    <div class="mt-3 w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2" style="width: {{ $borrowedPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Overdue -->
            <div class="group relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-2xl transform hover:scale-105 transition-all duration-500">
                <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                <div class="absolute -right-2 -top-2 w-16 h-16 bg-white/5 rounded-full"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-exclamation-triangle text-2xl opacity-80"></i>
                        <div class="text-white/60 text-sm">Attention</div>
                    </div>
                    <h3 class="text-4xl font-bold mb-2">{{ \App\Models\Borrowing::where('status', 'overdue')->count() }}</h3>
                    <p class="text-red-100 font-medium">Overdue Books</p>
                    <div class="mt-3 w-full bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2" style="width: {{ $overduePercentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Featured Book & Quick Actions -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Featured Book - Glass Morphism -->
                @php
                    $featured = \App\Models\Book::inRandomOrder()->first();
                @endphp

                @if($featured)
                <div class="relative overflow-hidden bg-white/80 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full -translate-y-16 translate-x-16"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                🌟 Featured Book of The Day
                            </h2>
                            <div class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                Featured
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-6">
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $featured->cover) }}" 
                                     class="w-24 h-32 object-cover rounded-2xl shadow-2xl transform group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl"></div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $featured->title }}</h3>
                                <p class="text-gray-600 text-lg mb-3">by {{ $featured->author }}</p>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $featured->description ?: 'An amazing read waiting to be discovered...' }}</p>
                                
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('books.show', $featured->id) }}" 
                                       class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 font-semibold">
                                        Explore Book
                                    </a>
                                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span>Featured Pick</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Actions - Modern Cards -->
                <div class="bg-white/80 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">🚀 Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('borrowings.create') }}" 
                           class="group p-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-plus text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Borrow Book</h3>
                                    <p class="text-sm text-gray-600">New to library</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('catalog.index') }}" 
                           class="group p-6 bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-book text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">View Books</h3>
                                    <p class="text-sm text-gray-600">Browse collection</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}" 
                           class="group p-6 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-users text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">Manage Users</h3>
                                    <p class="text-sm text-gray-600">User management</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Recent Activity & Stats -->
            <div class="space-y-8">
                <!-- Library Stats -->
                <div class="bg-white/80 backdrop-blur-lg rounded-3xl p-6 shadow-2xl border border-white/20">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Library Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Available Books</span>
                            <span class="font-semibold text-gray-800">
                                {{ \App\Models\Book::count() - \App\Models\Borrowing::where('status', 'borrowed')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Categories</span>
                            <span class="font-semibold text-gray-800">
                                {{ \App\Models\Book::distinct('category')->count('category') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Avg. Rating</span>
                            <span class="font-semibold text-gray-800">4.2/5</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white/80 backdrop-blur-lg rounded-3xl p-6 shadow-2xl border border-white/20">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">🔄 Recent Activity</h3>
                    <div class="space-y-3">
    @forelse($activities as $a)
        <div class="flex items-center space-x-3 p-3 rounded-xl
            @if($a['type'] == 'borrowed') bg-blue-50
            @elseif($a['type'] == 'user') bg-purple-50
            @endif
        ">
            <div class="w-8 h-8 flex items-center justify-center rounded-lg
                @if($a['type'] == 'borrowed') bg-blue-500
                @elseif($a['type'] == 'user') bg-purple-500
                @endif
            ">
                @if($a['type'] == 'borrowed')
                    <i class="fas fa-book text-white text-xs"></i>
                @else
                    <i class="fas fa-user text-white text-xs"></i>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800">{{ $a['text'] }}</p>
                <p class="text-xs text-gray-500">{{ $a['time']->diffForHumans() }}</p>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">No recent activity yet.</p>
    @endforelse
</div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</x-app-layout>