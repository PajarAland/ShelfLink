<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title'          => $this->faker->sentence(3),
            'cover'          => null,
            'author'         => $this->faker->name,
            'category'       => $this->faker->word,
            'description'    => $this->faker->paragraph,
            'published_year' => $this->faker->year,
            'stock'          => 5,
        ];
    }
}
