<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class BorrowingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_borrowing_record()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => Carbon::now(),
            'return_deadline' => Carbon::now()->addDays(14),
            'status' => 'borrowed',
        ]);

        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'borrowed',
        ]);
    }

    /** @test */
    public function borrowing_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertInstanceOf(User::class, $borrowing->user);
        $this->assertEquals($user->id, $borrowing->user->id);
    }

    /** @test */
    public function borrowing_belongs_to_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertInstanceOf(Book::class, $borrowing->book);
        $this->assertEquals($book->id, $borrowing->book->id);
    }
}
