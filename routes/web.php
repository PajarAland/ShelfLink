<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store']);
    Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
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
