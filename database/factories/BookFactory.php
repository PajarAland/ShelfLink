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
            'title' => $this->faker->sentence(3),
            'cover' => $this->faker->imageUrl(400, 600, 'books', true, 'Cover'),
            'author' => $this->faker->name(),
            'category' => $this->faker->randomElement(['Novel', 'Teknologi', 'Sains', 'Sejarah', 'Fiksi', 'Pendidikan']),
            'description' => $this->faker->paragraph(3),
            'published_year' => $this->faker->year(),
            'stock' => $this->faker->numberBetween(1, 20),

        ];
    }
}
