<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(5)->create();
        $books = Book::factory(10)->create();

        Borrowing::factory(20)->create([
            'user_id' => $users->random()->id,
            'book_id' => $books->random()->id,
        ]);
    }
}
