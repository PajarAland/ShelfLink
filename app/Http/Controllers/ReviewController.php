<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookReview;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah pernah memberikan ulasan untuk buku ini
        $existingReview = $book->reviews()->where('user_id', auth()->id())->first();

        if ($existingReview) {
            return back()->with('error', 'Kamu sudah memberikan ulasan untuk buku ini.');
        }

        // Simpan ulasan baru
        $book->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

}
