<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

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

        $averageBorrowDuration = Borrowing::whereNotNull('return_date')
            ->select(DB::raw('AVG(DATEDIFF(return_date, borrow_date)) as avg_duration'))
            ->value('avg_duration') ?? 0;

        $leaderboard = Borrowing::select('user_id', DB::raw('COUNT(*) as total_borrowed'))
            ->groupBy('user_id')
            ->orderByDesc('total_borrowed')
            ->with('user:id,name')
            ->take(5)
            ->get()
            ->map(fn($b) => (object)[
                'name' => $b->user->name ?? 'Unknown',
                'total_borrowed' => $b->total_borrowed,
            ]);

        $borrowChart = collect(range(1, 12))
            ->mapWithKeys(fn($m) => [$m => $borrowChart[$m] ?? 0]);

        return view('statistics.index', compact(
            'totalBooks',
            'totalUsers',
            'activeBorrowings',
            'returnedBorrowings',
            'averageBorrowDuration',
            'leaderboard',
            'borrowChart',
        ));
    }
}
