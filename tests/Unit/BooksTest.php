<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_fields_match()
    {
        $book = new Book();
        $this->assertEquals([
            'title',
            'cover',
            'author',
            'category',
            'description',
            'published_year',
            'stock',
        ], $book->getFillable());
    }

    public function test_cover_url_returns_default_if_no_cover()
    {
        $book = Book::factory()->create(['cover' => null]);
        $this->assertStringContainsString('default-book.png', $book->cover_url);
    }

    public function test_cover_url_returns_storage_path_if_has_cover()
    {
        $book = Book::factory()->create(['cover' => 'covers/test.jpg']);
        $this->assertStringContainsString('storage/covers/test.jpg', $book->cover_url);
    }

    public function test_book_has_reviews_relation()
    {
        $book = Book::factory()->create();
        $this->assertTrue(method_exists($book, 'reviews'));
    }
}
