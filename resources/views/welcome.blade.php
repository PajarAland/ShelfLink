<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes glow {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-glow {
            animation: glow 3s ease-in-out infinite;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .book-card {
            transform-style: preserve-3d;
            transition: transform 0.5s ease;
        }
        
        .book-card:hover {
            transform: rotateY(10deg) translateY(-10px);
        }
        
        .floating-book {
            animation: float 4s ease-in-out infinite;
        }
        
        .floating-book:nth-child(2) {
            animation-delay: 1s;
        }
        
        .floating-book:nth-child(3) {
            animation-delay: 2s;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#FDFDFC] via-[#F5F5F0] to-[#EBEBE5] dark:from-[#0a0a0a] dark:via-[#111111] dark:to-[#1a1a1a] min-h-screen overflow-x-hidden">

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-purple-300 dark:bg-purple-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-xl opacity-20 animate-glow"></div>
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-yellow-300 dark:bg-yellow-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-xl opacity-20 animate-glow" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-1/4 left-1/2 w-72 h-72 bg-blue-300 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-xl opacity-20 animate-glow" style="animation-delay: 2s;"></div>
    </div>

    <!-- Floating Books -->
    <div class="fixed top-20 left-10 floating-book opacity-60">
        <div class="w-16 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-2xl transform rotate-12"></div>
    </div>
    <div class="fixed top-40 right-20 floating-book opacity-40">
        <div class="w-20 h-28 bg-gradient-to-r from-green-400 to-blue-500 rounded-lg shadow-2xl transform -rotate-6"></div>
    </div>
    <div class="fixed bottom-32 left-20 floating-book opacity-50">
        <div class="w-14 h-22 bg-gradient-to-r from-orange-400 to-pink-500 rounded-lg shadow-2xl transform rotate-45"></div>
    </div>

    {{-- Header --}}
    <header class="relative w-full max-w-7xl mx-auto px-6 py-8 z-10">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <!-- <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-white text-lg"></i>
                </div> -->
                <div>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    ShelfLink
                </span>
            </div>
            
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-all duration-300 hover:shadow-lg">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition-all duration-300 hover:shadow-lg">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-all duration-300 hover:shadow-lg">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    {{-- Main Hero Section --}}
    <main class="relative w-full max-w-7xl mx-auto px-6 py-16 lg:py-24 z-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            
            {{-- Left: Content --}}
            <div class="space-y-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-full border border-gray-200 dark:border-gray-700">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Your Digital Library Awaits</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                            Discover
                        </span>
                        <br>
                        <span class="text-gray-800 dark:text-white">
                            Your Next
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 bg-clip-text text-transparent">
                            Favorite Book
                        </span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                        Explore thousands of books, track your reading journey, and connect with fellow book lovers. 
                        Your next literary adventure starts here.
                    </p>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-6 py-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ $bookCount }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Books Available</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">{{ $readerCount }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Active Readers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-blue-600 bg-clip-text text-transparent">∞</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Stories to Discover</div>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <i class="fas fa-rocket mr-3"></i>
                            Start Reading Free
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center px-8 py-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-white rounded-lg font-semibold text-lg hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
                            <i class="fas fa-sign-in-alt mr-3"></i>
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Right: Visual Showcase --}}
            <div class="relative">
                {{-- Main Book Showcase --}}
                <div class="relative z-10">
                    <div class="book-card relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-md mx-auto">

    <!-- FEATURED BADGE -->
    <span class="absolute down-1 right-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
        ⭐ Featured Book
    </span>
                        @if($featuredBook)
                            <div class="flex items-center space-x-4 mb-6">
                                <img src="{{ $featuredBook->cover_url }}" class="w-20 h-28 object-cover rounded-lg shadow-md">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                                        {{ $featuredBook->title }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                                        {{ Str::limit($featuredBook->author, 25) }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                                {{ Str::limit($featuredBook->description, 110) }}
                            </p>

                            <a href="{{ route('books.show', $featuredBook->id) }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-sm font-semibold">
                                View Book Details
                            </a>
                        @else
                            <p class="text-center text-gray-500">No books available yet.</p>
                        @endif
                    </div>
                </div>

                {{-- Floating Elements --}}
                <div class="absolute -top-10 -right-10 w-24 h-32 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl shadow-2xl transform rotate-12 animate-float"></div>
                <div class="absolute -bottom-8 -left-8 w-20 h-28 bg-gradient-to-r from-orange-400 to-pink-500 rounded-xl shadow-2xl transform -rotate-6 animate-float" style="animation-delay: 2s;"></div>
            </div>
        </div>

        {{-- Features Grid --}}
        <div class="grid md:grid-cols-3 gap-8 mt-24">
            <div class="group p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-search text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Smart Discovery</h3>
                <p class="text-gray-600 dark:text-gray-300">Find your next favorite book with AI-powered recommendations tailored to your taste.</p>
            </div>
            
            <div class="group p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Reading Analytics</h3>
                <p class="text-gray-600 dark:text-gray-300">Track your reading habits and progress with detailed insights and statistics.</p>
            </div>
            
            <div class="group p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 bg-gradient-to-r from-pink-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Community</h3>
                <p class="text-gray-600 dark:text-gray-300">Join discussions, share reviews, and connect with fellow book enthusiasts worldwide.</p>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="relative w-full max-w-7xl mx-auto px-6 py-8 mt-16 text-center text-gray-500 dark:text-gray-400 z-10">
        <p>ShelfLink © <script>document.write(new Date().getFullYear());</script>, made with <span class="text-red-500">❤</span> by Kelompok 4</p>
    </footer>

    <script>
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            document.querySelectorAll('.book-card, .group').forEach((el) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>