<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
   public function definition(): array
{
    $borrowDate = $this->faker->dateTimeBetween('-3 months', 'now');
    $deadline = (clone $borrowDate)->modify('+14 days');
    $isReturned = $this->faker->boolean(70);

    return [
        'book_id' => \App\Models\Book::factory(),
        'user_id' => \App\Models\User::factory(),
        'borrow_date' => $borrowDate,
        'return_deadline' => $deadline,
        'return_date' => $isReturned ? $this->faker->dateTimeBetween($borrowDate, $deadline) : null,
        'status' => $isReturned
            ? 'returned'
            : ($this->faker->boolean(20) ? 'overdue' : 'borrowed'),
    ];
}

}
