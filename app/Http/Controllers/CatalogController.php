<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

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

        // arahkan ke view katalog
        return view('catalog.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('catalog.show', compact('book'));
    }

}
