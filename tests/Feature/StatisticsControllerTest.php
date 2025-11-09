<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat 1 admin user untuk semua test
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@example.com',
        ]);
    }

    /** @test */
    public function index_returns_zero_values_when_no_data()
    {
        $response = $this->actingAs($this->admin)->get(route('statistics.index'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'totalBooks' => 0,
            'totalUsers' => 1, // karena admin dihitung juga
            'activeBorrowings' => 0,
            'returnedBorrowings' => 0,
            'averageBorrowDuration',
            'leaderboard',
            'borrowChart',
        ]);
    }

    /** @test */
    public function total_books_and_users_are_counted_correctly()
    {
        Book::factory()->count(5)->create();
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get(route('statistics.index'));

        $response->assertViewHas('totalBooks', 5);
        $response->assertViewHas('totalUsers', 4);
    }

    /** @test */
    public function active_and_returned_borrowings_are_counted_correctly()
    {
        Borrowing::factory()->create(['status' => 'borrowed']);
        Borrowing::factory()->create(['status' => 'returned']);
        Borrowing::factory()->create(['status' => 'borrowed']);

        $response = $this->actingAs($this->admin)->get(route('statistics.index'));

        $response->assertViewHas('activeBorrowings', 2);
        $response->assertViewHas('returnedBorrowings', 1);
    }

    /** @test */
    public function borrow_chart_contains_12_months_and_correct_counts()
    {
        Borrowing::factory()->create(['borrow_date' => now()->month(1)]);
        Borrowing::factory()->count(3)->create(['borrow_date' => now()->month(3)]);
        
        $response = $this->actingAs($this->admin)->get(route('statistics.index'));
        $borrowChart = $response->viewData('borrowChart');

        $this->assertCount(12, $borrowChart);
        $this->assertEquals(1, $borrowChart[1]);
        $this->assertEquals(3, $borrowChart[3]);
    }

    /** @test */
    public function average_borrow_duration_is_calculated_correctly()
    {
        Borrowing::factory()->create([
            'borrow_date' => '2025-01-01',
            'return_date' => '2025-01-04',
        ]);
        Borrowing::factory()->create([
            'borrow_date' => '2025-01-10',
            'return_date' => '2025-01-13',
        ]);

        $response = $this->actingAs($this->admin)->get(route('statistics.index'));
        $avg = $response->viewData('averageBorrowDuration');

        $this->assertEquals(3, round($avg));
    }

    /** @test */
    public function leaderboard_shows_top_5_users_by_borrow_count()
    {
        $users = User::factory()->count(6)->create();
        foreach ($users as $i => $user) {
            Borrowing::factory()->count($i + 1)->create(['user_id' => $user->id]);
        }

        $response = $this->actingAs($this->admin)->get(route('statistics.index'));
        $leaderboard = $response->viewData('leaderboard');

        $this->assertCount(5, $leaderboard);
        $this->assertGreaterThanOrEqual(
            $leaderboard[4]->total_borrowed,
            $leaderboard[0]->total_borrowed
        );
    }
}
