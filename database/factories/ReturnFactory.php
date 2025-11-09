<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReturnFactory extends Factory
{
    protected $model = Borrowing::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'status' => $this->faker->randomElement(['borrowed', 'returned', 'overdue']),
            'borrow_date' => now()->subDays(rand(1, 10)),
            'return_deadline' => now()->addDays(rand(-3, 7)),
            'return_date' => null,
        ];
    }
}
