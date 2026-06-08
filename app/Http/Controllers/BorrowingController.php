<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

// Import Mailables
use App\Mail\BorrowConfirmationMail;
use App\Mail\ReturnConfirmationMail;
use App\Mail\OverdueReminderMail;

class BorrowingController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'user'])
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

                    // Kirim email peringatan keterlambatan
                    Mail::to($borrowing->user->email)
                        ->send(new OverdueReminderMail($borrowing));
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

        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => $request->borrow_date,
            'return_deadline' => $returnDeadline->format('Y-m-d'),
            'status' => 'borrowed',
        ]);

        $book->decrement('stock');

        // Kirim email konfirmasi peminjaman
        Mail::to(Auth::user()->email)->send(new BorrowConfirmationMail($borrowing));

        return redirect()->route('borrowings.index')
            ->with('success', "Buku berhasil dipinjam! Harap dikembalikan sebelum tanggal {$returnDeadline->translatedFormat('d M Y')} atau akan dikenakan denda.");
    }

    // Proses pengembalian buku
 public function returnBook(Request $request, $id)
{
    $request->validate([
        'return_photos' => 'required',
        'return_photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $borrowing = Borrowing::with('book', 'user')->findOrFail($id);

    if (!in_array($borrowing->status, ['borrowed', 'overdue'])) {
        return redirect()
            ->route('borrowings.index')
            ->with('error', 'Buku sudah dikembalikan.');
    }

    $photos = [];

    if ($request->hasFile('return_photos')) {

        foreach ($request->file('return_photos') as $photo) {

            $path = $photo->store('return_photos', 'public');

            $photos[] = $path;
        }
    }

    $borrowing->update([
        'status' => 'pending',
        'return_photos' => $photos,
        'return_date' => now(),
    ]);

    Mail::to($borrowing->user->email)
        ->send(new ReturnConfirmationMail($borrowing));

    return redirect()
        ->route('borrowings.index')
        ->with('success', 'Bukti pengembalian berhasil dikirim dan menunggu approval admin.');
}

    public function showReturnForm($id)
    {
        $borrowing = Borrowing::with('book')->findOrFail($id);
        return view('borrowings.return', compact('borrowing'));
    }

}
