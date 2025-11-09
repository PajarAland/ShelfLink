<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage; 

class BooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirect_to_login_when_access_books()
    {
        $response = $this->get('/books');
        $response->assertRedirect('/login');
    }

    public function test_non_admin_forbidden_access_books()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)->get('/books');
        $response->assertStatus(403);
    }

    public function test_admin_can_see_book_index()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get('/books');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_book()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        Storage::fake('public');

        $response = $this->actingAs($admin)->post('/books', [
            'title' => 'Judul Buku',
            'cover' => UploadedFile::fake()->image('cover.jpg'),
            'author' => 'John Doe',
            'category' => 'Novel',
            'description' => 'desc',
            'published_year' => '2020',
            'stock' => 3,
        ]);

        $response->assertRedirect('/books');

        $this->assertDatabaseHas('books', [
            'title' => 'Judul Buku',
            'author' => 'John Doe'
        ]);
    }

    public function test_admin_can_delete_book()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $book = Book::factory()->create();

        $response = $this->actingAs($admin)->delete('/books/'.$book->id);

        $response->assertRedirect('/books');
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
