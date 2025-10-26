<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['book'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // Cek apakah ada peminjaman yang sudah lewat 14 hari
        foreach ($borrowings as $borrowing) {
            if ($borrowing->status === 'borrowed') {
                $borrowDate = Carbon::parse($borrowing->borrow_date);
                $daysPassed = $borrowDate->diffInDays(Carbon::now());

                if ($daysPassed > 14) {
                    $borrowing->update(['status' => 'overdue']);
                }
            }
        }

        return view('borrowings.index', compact('borrowings'));
    }

    // Form peminjaman baru
    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        return view('borrowings.create', compact('books'));
    }

    // Simpan data peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        // Hitung tanggal pengembalian (14 hari ke depan)
        $returnDeadline = Carbon::parse($request->borrow_date)->addDays(14);

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => $request->borrow_date,
            'return_deadline' => $returnDeadline->format('Y-m-d'), // tambahkan format ini agar aman
            'status' => 'borrowed',
        ]);

        $book->decrement('stock');

        return redirect()->route('borrowings.index')
            ->with('success', "Buku berhasil dipinjam! Harap dikembalikan sebelum tanggal {$returnDeadline->translatedFormat('d M Y')} atau akan dikenakan denda.");
    }

}
