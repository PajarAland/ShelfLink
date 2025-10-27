<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

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
    public function update($id)
    {
        $borrowing = Borrowing::with('book')->findOrFail($id);

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

        // Hitung keterlambatan (jika ada)
        $lateDays = 0;
        $fine = 0;

        if ($borrowing->return_deadline && $returnDate->gt($borrowing->return_deadline)) {
            $lateDays = $borrowing->return_deadline->diffInDays($returnDate);
            $fine = $lateDays * 1000; // contoh: denda Rp1000/hari
        }

        $message = 'Buku berhasil dikembalikan dan stok diperbarui.';
        if ($lateDays > 0) {
            $message .= " Terlambat {$lateDays} hari. Denda: Rp" . number_format($fine, 0, ',', '.');
        }

        return redirect()->back()->with('success', $message);
    }

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
