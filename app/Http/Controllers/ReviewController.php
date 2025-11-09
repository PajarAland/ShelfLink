<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🔹 Tambahkan ini
use App\Models\Book;
use App\Models\BookReview;
use App\Models\ReviewVote;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
        {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:1000',
            ]);

            $existingReview = $book->reviews()->where('user_id', auth()->id())->first();
            if ($existingReview) {
                return back()->with('error', 'Kamu sudah memberikan ulasan untuk buku ini.');
            }

            // 🔹 Filter kata kasar
            $badWords = ['anjing', 'bangsat', 'goblok', 'tolol'];
            $cleanComment = $request->comment;
            foreach ($badWords as $word) {
                $cleanComment = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', str_repeat('*', strlen($word)), $cleanComment);
            }

            $book->reviews()->create([
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'comment' => $cleanComment,
            ]);

            return back()->with('success', 'Ulasan berhasil ditambahkan!');
        }

        // 🔹 Admin menyembunyikan atau menampilkan ulasan
    public function toggleVisibility($id)
        {
            $review = \App\Models\BookReview::findOrFail($id);
            $review->is_hidden = !$review->is_hidden;
            $review->save();

            return back()->with('success', $review->is_hidden ? 'Ulasan disembunyikan.' : 'Ulasan ditampilkan kembali.');
        }

        // 🔹 Admin pin/unpin ulasan
        public function togglePin($id)
        {
            $review = \App\Models\BookReview::findOrFail($id);
            $review->is_pinned = !$review->is_pinned;
            $review->save();

            return back()->with('success', $review->is_pinned ? 'Ulasan dipin ke atas.' : 'Pin ulasan dihapus.');
        }

        // Upvote / Downvote
        public function vote(Request $request, $id)
        {
            $request->validate([
                'vote' => 'required|in:up,down',
            ]);

            $review = BookReview::findOrFail($id);
            $userId = Auth::id();
            $voteType = $request->vote === 'up' ? 'upvote' : 'downvote';

            $existingVote = ReviewVote::where('review_id', $review->id)
                ->where('user_id', $userId)
                ->first();

            if ($existingVote) {
                if ($existingVote->type === $voteType) {
                    $existingVote->delete();
                } else {
                    $existingVote->update(['type' => $voteType]);
                }
            } else {
                ReviewVote::create([
                    'review_id' => $review->id,
                    'user_id' => $userId,
                    'type' => $voteType,
                ]);
            }

            $upvotes = $review->votes()->where('type', 'upvote')->count();
            $downvotes = $review->votes()->where('type', 'downvote')->count();
            $score = $upvotes - $downvotes;

            $review->update(['votes' => $score]);

            return back();
        }



}
