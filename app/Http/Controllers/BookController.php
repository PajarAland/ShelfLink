<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index()
    {
        $books = \App\Models\Book::paginate(2); // ambil semua data buku
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'nullable|digits:4|integer',
            'stock' => 'required|integer|min:1',
        ]);

        $coverPath = null;

        // Jika ada file cover yang di-upload
        if ($request->hasFile('cover')) {
            // Simpan file ke storage/app/public/covers
            $coverPath = $request->file('cover')->store('covers', 'public');
        }
       
        Book::create([
            // 'user_id' => Auth::id(),
            'title' => $request->title,
            'cover' => $coverPath,
            'author' => $request->author,
            'category' => $request->category,
            'description' => $request->description,
            'published_year' => $request->published_year,
            'stock' => $request->stock,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        // $this->authorize('update', $book); // optional: untuk keamanan
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'nullable|digits:4|integer',
            'stock' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->only([
            'title',
            'author',
            'category',
            'description',
            'published_year',
            'stock',
        ]);

        // Handle cover baru jika diupload
        if ($request->hasFile('cover')) {
            // Hapus cover lama kalau ada
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // Simpan cover baru
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Update data buku
        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui!');
    }


    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
