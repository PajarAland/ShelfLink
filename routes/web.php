<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('welcome', [
        'bookCount' => \App\Models\Book::count(),
        'readerCount' => \App\Models\User::where('role', 'user')->count(),
        'featuredBook' => \App\Models\Book::inRandomOrder()->first(),
    ]);
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store']);
    Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{book}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::post('/catalog/{book}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/catalog/{book}', [BookController::class, 'show'])->name('catalog.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('books', BookController::class);
    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/admin/returns', [ReturnController::class, 'index'])->name('admin.returns.index');
    Route::post('/admin/returns/{id}', [ReturnController::class, 'update'])->name('admin.returns.update');
    Route::post('/admin/returns/{id}/revert', [ReturnController::class, 'revert'])->name('admin.returns.revert');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/returns', [ReturnController::class, 'index'])->name('admin.returns.index');
//     Route::post('/admin/returns/{id}', [ReturnController::class, 'update'])->name('admin.returns.update');
//     Route::post('/admin/returns/{id}/revert', [ReturnController::class, 'revert'])->name('admin.returns.revert');
// });


require __DIR__.'/auth.php';
