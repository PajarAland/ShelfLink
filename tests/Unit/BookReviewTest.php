<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\ReviewVote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = BookReview::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertInstanceOf(User::class, $review->user);
        $this->assertEquals($user->id, $review->user->id);
    }

    /** @test */
    public function it_belongs_to_a_book()
    {
        $book = Book::factory()->create();
        $review = BookReview::factory()->create([
            'book_id' => $book->id,
        ]);

        $this->assertInstanceOf(Book::class, $review->book);
        $this->assertEquals($book->id, $review->book->id);
    }

    /** @test */
    public function test_it_can_have_multiple_votes()
    {
        $review = BookReview::factory()->create();

        ReviewVote::factory()->count(3)->create([
            'review_id' => $review->id,
        ]);

        $review->load('reviewVotes');

        $this->assertCount(3, $review->reviewVotes);
        $this->assertInstanceOf(ReviewVote::class, $review->reviewVotes->first());
    }

}
