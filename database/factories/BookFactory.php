<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
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
