<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    /**
     * Tampilkan katalog buku dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Jika ada keyword pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        // Pagination
        $books = $query->paginate(8);

        // Buku rekomendasi
        $recommendedBooks = $this->getRecommendedBooks();

        // arahkan ke view katalog
        return view('catalog.index', compact('books', 'recommendedBooks'));
    }

    public function show(Book $book)
    {
        // Rekomendasi buku berdasarkan kategori yang sama
        $relatedBooks = Book::where('category', $book->category)
            ->where('id', '!=', $book->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('catalog.show', compact('book', 'relatedBooks'));
    }

    /**
     * Mendapatkan buku rekomendasi berdasarkan 2 kategori:
     * 1. Buku yang sering dipinjam (popularitas) - PRIORITAS UTAMA
     * 2. Buku periode tertentu (terbaru) - PRIORITAS KEDUA
     */
   private function getRecommendedBooks()
{
    // Step 1: Ambil buku yang pernah dipinjam (minimal 1x) dalam 3 bulan terakhir
    $booksWithBorrows = Book::select('books.*', DB::raw('COUNT(borrowings.id) as borrow_count'))
        ->join('borrowings', function($join) {
            $join->on('books.id', '=', 'borrowings.book_id')
                 ->where('borrowings.created_at', '>=', now()->subMonths(3));
        })
        ->where('books.stock', '>', 0)
        ->groupBy('books.id')
        ->orderBy('borrow_count', 'desc')
        ->orderBy('books.created_at', 'desc')
        ->take(4)
        ->get();

    // Jika sudah dapat 4 buku yang pernah dipinjam, return
    if ($booksWithBorrows->count() >= 4) {
        return $booksWithBorrows;
    }

    // Step 2: Jika kurang dari 4, tambahkan buku terbaru yang belum pernah dipinjam
    $existingIds = $booksWithBorrows->pluck('id');
    $needed = 4 - $booksWithBorrows->count();

    $recentBooks = Book::where('stock', '>', 0)
        ->whereNotIn('id', $existingIds)
        ->orderBy('created_at', 'desc')
        ->take($needed)
        ->get()
        ->map(function($book) {
            $book->borrow_count = 0; // Set borrow_count untuk konsistensi
            return $book;
        });

    return $booksWithBorrows->merge($recentBooks);
}
}