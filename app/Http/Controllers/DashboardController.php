<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $featuredBook = Book::inRandomOrder()->first();

        if ($user->role === 'admin') {
            $bookCount = Book::count();
            $readerCount = User::where('role', 'user')->count();
            $borrowed = Borrowing::where('status', 'borrowed')->count();
            $overdue = Borrowing::where('status', 'overdue')->count();

            // Progress Calculation
            $borrowedPercentage = $bookCount > 0 ? ($borrowed / $bookCount) * 100 : 0;
            $overduePercentage = $borrowed > 0 ? ($overdue / $borrowed) * 100 : 0;
            $readerPercentage = User::count() > 0 ? ($readerCount / User::count()) * 100 : 0;

            $activities = collect()
                ->merge(
                    Borrowing::latest()->take(4)->get()->map(function($b){
                        return [
                            'text' => $b->user->name . ' borrowed "' . $b->book->title . '"',
                            'time' => $b->created_at,
                            'type' => 'borrowed'
                        ];
                    })
                )
                ->merge(
                    User::latest()->take(4)->get()->map(function($u){
                        return [
                            'text' => 'New user registered: ' . $u->name,
                            'time' => $u->created_at,
                            'type' => 'user'
                        ];
                    })
                )
                ->sortByDesc('time')
                ->take(6);

            return view('dashboard', [
                'role' => 'admin',
                'bookCount' => $bookCount,
                'readerCount' => $readerCount,
                'featuredBook' => $featuredBook,
                'borrowed' => $borrowed,
                'overdue' => $overdue,
                'borrowedPercentage' => $borrowedPercentage,
                'overduePercentage' => $overduePercentage,
                'readerPercentage' => $readerPercentage,
                'activities' => $activities
            ]);
        } else {
            // Standard User Dashboard Data
            $myBorrowedCount = Borrowing::where('user_id', $user->id)->where('status', 'borrowed')->count();
            $myOverdueCount = Borrowing::where('user_id', $user->id)->where('status', 'overdue')->count();
            $myActiveBorrowings = Borrowing::where('user_id', $user->id)
                ->whereIn('status', ['borrowed', 'overdue'])
                ->with('book')
                ->latest()
                ->get();
            $totalAvailableBooks = Book::count();
            $myTotalFines = Borrowing::where('user_id', $user->id)->sum('total_fine');

            return view('dashboard', [
                'role' => 'user',
                'featuredBook' => $featuredBook,
                'myBorrowedCount' => $myBorrowedCount,
                'myOverdueCount' => $myOverdueCount,
                'myActiveBorrowings' => $myActiveBorrowings,
                'totalAvailableBooks' => $totalAvailableBooks,
                'myTotalFines' => $myTotalFines
            ]);
        }
    }
}
