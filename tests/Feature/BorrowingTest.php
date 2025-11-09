<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\BorrowConfirmationMail;
use App\Mail\ReturnConfirmationMail;

class BorrowingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_borrow_a_book()
    {
        Mail::fake(); // ⛔ Cegah email asli terkirim

        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 3]);

        $response = $this->actingAs($user)->post('/borrowings', [
            'book_id' => $book->id,
            'borrow_date' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('borrowings.index'));
        $this->assertDatabaseHas('borrowings', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
        ]);

        $this->assertEquals(2, Book::find($book->id)->stock);

        Mail::assertSent(BorrowConfirmationMail::class);
    }

    /** @test */
    public function user_cannot_borrow_book_if_out_of_stock()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 0]);

        $response = $this->actingAs($user)->post('/borrowings', [
            'book_id' => $book->id,
            'borrow_date' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHas('error', 'Stok buku habis.');
        $this->assertDatabaseMissing('borrowings', ['book_id' => $book->id]);
    }

    /** @test */
    public function user_can_return_a_borrowed_book()
    {
        Mail::fake();

        $user = User::factory()->create();
        $book = Book::factory()->create(['stock' => 1]);
        $borrowing = Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'borrowed',
            'borrow_date' => now()->subDays(5),
        ]);

        $response = $this->actingAs($user)->post("/borrowings/{$borrowing->id}/return");

        $response->assertRedirect();
        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'pending',
        ]);

        // Pastikan stok buku bertambah kembali
        $this->assertEquals(2, Book::find($book->id)->stock);

        Mail::assertSent(ReturnConfirmationMail::class);
    }
}
