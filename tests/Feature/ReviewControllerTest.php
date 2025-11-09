<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\ReviewVote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_submit_a_review_successfully()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('reviews.store', $book->id), [
            'rating' => 5,
            'comment' => 'Buku ini luar biasa!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('book_reviews', [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Buku ini luar biasa!',
        ]);
    }

    /** @test */
    public function user_cannot_post_duplicate_review_for_same_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Review pertama
        BookReview::factory()->create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rating' => 4,
        ]);

        // Coba kirim review kedua
        $response = $this->actingAs($user)->post(route('reviews.store', $book->id), [
            'rating' => 5,
            'comment' => 'Mau review lagi tapi ditolak.',
        ]);

        $response->assertSessionHas('error', 'Kamu sudah memberikan ulasan untuk buku ini.');
    }

    /** @test */
    public function comment_with_bad_words_should_be_censored()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('reviews.store', $book->id), [
            'rating' => 4,
            'comment' => 'Buku ini goblok dan tolol.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('book_reviews', [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'comment' => 'Buku ini ****** dan *****.',
        ]);

    }
}
