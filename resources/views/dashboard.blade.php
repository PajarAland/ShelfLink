<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    @if($role === 'admin')
                        Welcome back, Admin {{ Auth::user()->name }}! Here's the library health status today.
                    @else
                        Welcome back, {{ Auth::user()->name }}! Ready to discover your next favorite book?
                    @endif
                </p>
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
        
        @if($role === 'admin')
            <!-- ================= ADMIN DASHBOARD ================= -->
            
            <!-- Admin Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Books -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-book-open text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">Catalog Size</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $bookCount }}</h3>
                        <p class="text-blue-100 text-sm font-medium">Total Volumes Listed</p>
                        <div class="mt-4 w-full bg-white/20 rounded-full h-1.5">
                            <div class="bg-white rounded-full h-1.5" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <!-- Registered Readers -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -left-6 -top-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -left-2 -bottom-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-users text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">Active Users</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $readerCount }}</h3>
                        <p class="text-purple-100 text-sm font-medium">Registered Readers</p>
                        <div class="mt-4 w-full bg-white/20 rounded-full h-1.5">
                            <div class="bg-white rounded-full h-1.5" style="width: {{ $readerPercentage }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Borrowed Books -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -left-2 -top-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-bookmark text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">Out Circulation</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $borrowed }}</h3>
                        <p class="text-green-100 text-sm font-medium">Books Borrowed</p>
                        <div class="mt-4 w-full bg-white/20 rounded-full h-1.5">
                            <div class="bg-white rounded-full h-1.5" style="width: {{ $borrowedPercentage }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Overdue Books -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -right-2 -top-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-exclamation-triangle text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono font-mono">Requires Action</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $overdue }}</h3>
                        <p class="text-red-100 text-sm font-medium">Overdue Books</p>
                        <div class="mt-4 w-full bg-white/20 rounded-full h-1.5">
                            <div class="bg-white rounded-full h-1.5" style="width: {{ $overduePercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: Actions & Featured -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Admin Quick Actions -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-tools text-indigo-500 mr-2"></i>
                            Administrative Quick Actions
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('books.create') }}" 
                               class="group p-5 bg-gradient-to-br from-indigo-50 to-indigo-100/50 border border-indigo-100 rounded-xl hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-plus text-white text-md"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm">Add New Book</h4>
                                        <p class="text-xs text-gray-500">Insert new item</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('admin.returns.index') }}" 
                               class="group p-5 bg-gradient-to-br from-green-50 to-green-100/50 border border-green-100 rounded-xl hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-undo text-white text-md"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm">Manage Returns</h4>
                                        <p class="text-xs text-gray-500">Approve returns</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('statistics.index') }}" 
                               class="group p-5 bg-gradient-to-br from-amber-50 to-amber-100/50 border border-amber-100 rounded-xl hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-chart-line text-white text-md"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm">View Statistics</h4>
                                        <p class="text-xs text-gray-500">Analyze performance</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Featured Book of the Day -->
                    @if($featuredBook)
                        <div class="relative overflow-hidden bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 rounded-full -translate-y-16 translate-x-16"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                        <i class="fas fa-star text-amber-500 mr-2"></i>
                                        Featured Book of The Day
                                    </h3>
                                    <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-full text-xs font-semibold">
                                        System Spotlight
                                    </span>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                                    <img src="{{ asset('storage/' . $featuredBook->cover) }}" 
                                         class="w-24 h-32 object-cover rounded-xl shadow-md border border-gray-100">
                                    <div class="flex-1 text-center sm:text-left">
                                        <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $featuredBook->title }}</h4>
                                        <p class="text-gray-600 text-sm mb-3">by {{ $featuredBook->author }}</p>
                                        <p class="text-gray-500 text-sm mb-4 leading-relaxed line-clamp-2">
                                            {{ $featuredBook->description ?: 'No description available for this book.' }}
                                        </p>
                                        
                                        <div class="flex items-center justify-center sm:justify-start gap-4">
                                            <a href="{{ route('books.edit', $featuredBook->id) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition-all shadow-sm">
                                                <i class="fas fa-edit mr-1 text-xs"></i>
                                                Edit Book Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Side: System Activity Log -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                        <i class="fas fa-history text-gray-500 mr-2"></i>
                        Recent System Activity
                    </h3>
                    <div class="space-y-4">
                        @forelse($activities as $act)
                            <div class="flex items-start space-x-3 p-3 rounded-xl border border-gray-50 bg-gray-50/50 hover:bg-gray-50 transition duration-150">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                    @if($act['type'] == 'borrowed') bg-blue-100 text-blue-600
                                    @else bg-purple-100 text-purple-600
                                    @endif">
                                    @if($act['type'] == 'borrowed')
                                        <i class="fas fa-book text-xs"></i>
                                    @else
                                        <i class="fas fa-user text-xs"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-800 truncate" title="{{ $act['text'] }}">
                                        {{ $act['text'] }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                        {{ $act['time']->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <i class="fas fa-inbox text-gray-300 text-3xl mb-2"></i>
                                <p class="text-gray-400 text-xs">No recent activity detected.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        @else
            <!-- ================= STANDARD USER DASHBOARD ================= -->
            
            <!-- User Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- My Borrowed Books -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -right-2 -bottom-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-book text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">My Reading</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $myBorrowedCount }}</h3>
                        <p class="text-indigo-100 text-sm font-medium">Currently Checked Out</p>
                    </div>
                </div>

                <!-- My Overdue Count -->
                <div class="group relative overflow-hidden @if($myOverdueCount > 0) bg-gradient-to-br from-red-500 to-red-600 @else bg-gradient-to-br from-green-500 to-green-600 @endif rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -left-6 -top-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -left-2 -bottom-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas @if($myOverdueCount > 0) fa-exclamation-triangle @else fa-check-circle @endif text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">Overdue Alerts</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $myOverdueCount }}</h3>
                        <p class="text-white/90 text-sm font-medium">
                            @if($myOverdueCount > 0)
                                Action Required! Please return books.
                            @else
                                All clear! No overdue items.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Total Available -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -left-2 -top-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-globe text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">Explore Selection</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">{{ $totalAvailableBooks }}</h3>
                        <p class="text-emerald-100 text-sm font-medium">Total Books in ShelfLink</p>
                    </div>
                </div>

                <!-- Total Fines -->
                <div class="group relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -left-2 -top-2 w-16 h-16 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <i class="fas fa-coins text-2xl opacity-85"></i>
                            <div class="text-white/70 text-xs font-semibold uppercase tracking-wider font-mono">My Fines</div>
                        </div>
                        <h3 class="text-4xl font-bold mb-2">Rp{{ number_format($myTotalFines, 0, ',', '.') }}</h3>
                        <p class="text-amber-100 text-sm font-medium">Accumulated Fine Fees</p>
                    </div>
                </div>
            </div>

            <!-- User Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Side: Active Borrowings & Actions -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- User Quick Actions -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-directions text-indigo-500 mr-2"></i>
                            What would you like to do?
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('catalog.index') }}" 
                               class="group p-5 bg-gradient-to-br from-indigo-50 to-indigo-100/50 border border-indigo-100 rounded-xl hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-search text-white text-md"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm">Browse Catalog</h4>
                                        <p class="text-xs text-gray-500">Discover new books</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('borrowings.index') }}" 
                               class="group p-5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 border border-emerald-100 rounded-xl hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-history text-white text-md"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm">My History</h4>
                                        <p class="text-xs text-gray-500">Check return status</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('profile.edit') }}" 
                               class="group p-5 bg-gradient-to-br from-purple-50 to-purple-100/50 border border-purple-100 rounded-xl hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                        <i class="fas fa-user-cog text-white text-md"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-sm">Profile Settings</h4>
                                        <p class="text-xs text-gray-500">Configure profile</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- My Active Borrowings List -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center">
                            <i class="fas fa-bookmark text-indigo-500 mr-2"></i>
                            My Active Borrowings
                        </h3>
                        
                        @if($myActiveBorrowings->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100 text-left">
                                    <thead>
                                        <tr class="text-xs font-semibold text-gray-500 uppercase">
                                            <th class="py-3 px-4">Book Details</th>
                                            <th class="py-3 px-4">Borrow Date</th>
                                            <th class="py-3 px-4">Return Deadline</th>
                                            <th class="py-3 px-4 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($myActiveBorrowings as $borrow)
                                            <tr class="hover:bg-gray-50/50 transition">
                                                <td class="py-4 px-4">
                                                    <div class="flex items-center space-x-3">
                                                        <img src="{{ asset('storage/' . $borrow->book->cover) }}" 
                                                             class="w-10 h-14 object-cover rounded-md border border-gray-100 shadow-sm flex-shrink-0">
                                                        <div>
                                                            <div class="text-sm font-semibold text-gray-900">{{ $borrow->book->title }}</div>
                                                            <div class="text-xs text-gray-500">by {{ $borrow->book->author }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-4 text-sm text-gray-600">
                                                    {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}
                                                </td>
                                                <td class="py-4 px-4">
                                                    <div class="text-sm text-gray-700">
                                                        {{ \Carbon\Carbon::parse($borrow->return_deadline)->format('d M Y') }}
                                                    </div>
                                                    
                                                    @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($borrow->return_deadline)))
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-red-100 text-red-700 mt-1">
                                                            <i class="fas fa-exclamation-circle mr-0.5"></i>
                                                            Overdue
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-green-50 text-green-700 border border-green-100 mt-1">
                                                            Within limits
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-4 text-right">
                                                    <a href="{{ route('borrowings.return.form', $borrow->id) }}" 
                                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-all duration-200 shadow-sm font-semibold">
                                                        <i class="fas fa-undo mr-1 text-xs"></i>
                                                        Return
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-book-reader text-gray-400 text-lg"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800 text-sm">No Active Borrowings</h4>
                                <p class="text-gray-500 text-xs mt-1 mb-4">You don't have any books checked out right now.</p>
                                <a href="{{ route('catalog.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition-all">
                                    Browse Books Catalog
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Discovery Widget -->
                <div class="space-y-8">
                    <!-- Featured Book of the Day -->
                    @if($featuredBook)
                        <div class="relative overflow-hidden bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 rounded-full -translate-y-16 translate-x-16"></div>
                            
                            <div class="relative z-10 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-full text-xs font-semibold mb-4">
                                    💡 Daily Recommendation
                                </span>
                                
                                <img src="{{ asset('storage/' . $featuredBook->cover) }}" 
                                     class="w-28 h-40 object-cover rounded-xl shadow-md mx-auto mb-4 border border-gray-100 hover:scale-[1.03] transition-transform duration-200">
                                
                                <h4 class="text-lg font-bold text-gray-900 mb-0.5">{{ $featuredBook->title }}</h4>
                                <p class="text-gray-500 text-xs mb-3">by {{ $featuredBook->author }}</p>
                                <p class="text-gray-500 text-xs mb-5 leading-relaxed line-clamp-3">
                                    {{ $featuredBook->description ?: 'No description available for this book.' }}
                                </p>
                                
                                <a href="{{ route('catalog.show', $featuredBook->id) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition-all shadow-sm">
                                    <i class="fas fa-book-open mr-1.5"></i>
                                    Explore Book
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Library Stats Summary -->
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-xs font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-chart-bar text-gray-400 mr-2"></i>
                            ShelfLink Library Stats
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Available Books in Shelf</span>
                                <span class="font-bold text-gray-800">{{ $totalAvailableBooks }}</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Total Genres / Categories</span>
                                <span class="font-bold text-gray-800">
                                    {{ \App\Models\Book::distinct('category')->count('category') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Average Review Rating</span>
                                <span class="font-bold text-gray-800">4.5 / 5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>