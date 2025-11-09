<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user login agar tidak redirect (302)
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_render_catalog_page()
    {
        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertViewIs('catalog.index');
    }

    /** @test */
    public function it_can_search_books_by_title_or_author_or_category()
    {
        Book::factory()->create(['title' => 'Laravel Mastery', 'author' => 'Taylor', 'category' => 'Web']);
        Book::factory()->create(['title' => 'Cooking Magic', 'author' => 'Chef Rio', 'category' => 'Food']);

        $response = $this->get('/catalog?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Mastery');
        $response->assertDontSee('Cooking Magic');
    }

    /** @test */
    public function it_returns_empty_result_when_search_has_no_matches()
    {
        Book::factory()->create(['title' => 'Physics 101', 'category' => 'Science']);

        $response = $this->get('/catalog?search=Cooking');

        $response->assertStatus(200);
        $response->assertDontSee('Physics 101');
        $response->assertViewIs('catalog.index');
    }

    /** @test */
    public function recommended_books_include_recent_books_if_not_enough_borrowed_books()
    {
        $recent1 = Book::factory()->create(['created_at' => now()->subDays(1)]);
        $recent2 = Book::factory()->create(['created_at' => now()->subDays(2)]);

        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertViewHas('recommendedBooks', function ($books) use ($recent1, $recent2) {
            return $books->contains($recent1) && $books->contains($recent2);
        });
    }

    /** @test */
    public function it_does_not_include_out_of_stock_books_in_recommendations()
    {
        $availableBook = Book::factory()->create(['stock' => 3]);
        $outOfStockBook = Book::factory()->create(['stock' => 0]);

        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertViewHas('recommendedBooks', function ($books) use ($availableBook, $outOfStockBook) {
            return $books->contains($availableBook) && !$books->contains($outOfStockBook);
        });
    }

    /** @test */
    public function recommended_books_are_limited_to_four_items()
    {
        Book::factory(6)->create(['stock' => 5]);

        $response = $this->get('/catalog');

        $response->assertStatus(200);
        $response->assertViewHas('recommendedBooks', function ($books) {
            return $books->count() <= 4;
        });
    }
}
