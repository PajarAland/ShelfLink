<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $activeBorrowings = Borrowing::where('status', 'borrowed')->count();
        $returnedBorrowings = Borrowing::where('status', 'returned')->count();

        $borrowChart = Borrowing::selectRaw('MONTH(borrow_date) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('statistics.index', compact(
            'totalBooks',
            'totalUsers',
            'activeBorrowings',
            'returnedBorrowings',
            'borrowChart'
        ));
    }
}
