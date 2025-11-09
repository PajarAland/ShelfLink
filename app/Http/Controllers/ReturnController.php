<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReturnReceiptMail;

class ReturnController extends Controller
{
    /**
     * Menampilkan semua data peminjaman untuk admin.
     */
    public function index()
    {
        // Tandai otomatis peminjaman yang sudah lewat deadline tapi belum dikembalikan
        Borrowing::where('status', 'borrowed')
            ->where('return_deadline', '<', now())
            ->update(['status' => 'overdue']);

        $borrowings = Borrowing::with(['user', 'book'])
            ->orderByDesc('id')
            ->get();

        return view('admin.returns.index', compact('borrowings'));
    }

    /**
     * Update status peminjaman menjadi returned.
     */
    public function update(Request $request, $id)
    {
        $borrowing = Borrowing::with(['book', 'user'])->findOrFail($id);

    if ($borrowing->status === 'returned') {
        return redirect()->back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
    }

    $returnDate = now();
    $borrowing->update([
        'status' => 'returned',
        'return_date' => $returnDate,
    ]);

    // Tambahkan stok buku kembali
    $borrowing->book->increment('stock');

    // Hitung keterlambatan
    $lateDays = 0;
    $lateFine = 0;
    if ($borrowing->return_deadline && $returnDate->gt($borrowing->return_deadline)) {
        $lateDays = $borrowing->return_deadline->diffInDays($returnDate);
        $lateFine = $lateDays * 1000;
    }

    // Ambil denda dari input
    $damageFine = (int) $request->fine;
    $totalFine = $lateFine + $damageFine;

    try {
        Mail::to($borrowing->user->email)->send(
            new ReturnReceiptMail($borrowing, $lateDays, $lateFine, $damageFine, $totalFine)
        );
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Buku dikembalikan, tapi gagal mengirim email: '.$e->getMessage());
    }

    $message = 'Buku berhasil dikembalikan dan stok diperbarui.';
    if ($totalFine > 0) {
        $message .= " Total Denda: Rp" . number_format($totalFine, 0, ',', '.');
    }

    return redirect()->back()->with('success', $message);
    }

    /**
     * Membatalkan status pengembalian buku.
     */
    public function revert($id)
    {
        $borrowing = Borrowing::with('book')->findOrFail($id);

        if ($borrowing->status !== 'returned') {
            return redirect()->back()->with('error', 'Data bukan status returned.');
        }

        $status = now()->gt($borrowing->return_deadline)
            ? 'overdue'
            : 'borrowed';

        $borrowing->update([
            'status' => $status,
            'return_date' => null,
        ]);

        // Kurangi stok buku
        if ($borrowing->book->stock > 0) {
            $borrowing->book->decrement('stock');
        }

        return redirect()->route('admin.returns.index')
            ->with('success', 'Pengembalian dibatalkan dan status dikembalikan ke "' . $status . '".');
    }
}
