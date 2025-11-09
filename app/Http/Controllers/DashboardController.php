<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bookCount = Book::count();
        $readerCount = User::where('role', 'user')->count();
        $borrowed = Borrowing::where('status', 'borrowed')->count();
        $overdue = Borrowing::where('status', 'overdue')->count();

        // Progress Calculation
        $borrowedPercentage = $bookCount > 0 ? ($borrowed / $bookCount) * 100 : 0;
        $overduePercentage = $borrowed > 0 ? ($overdue / $borrowed) * 100 : 0;
        $readerPercentage = User::count() > 0 ? ($readerCount / User::count()) * 100 : 0; // ← ini yang ditambahkan

        return view('dashboard', [
            'bookCount' => $bookCount,
            'readerCount' => $readerCount,
            'featuredBook' => Book::inRandomOrder()->first(),

            'borrowed' => $borrowed,
            'overdue' => $overdue,
            'borrowedPercentage' => $borrowedPercentage,
            'overduePercentage' => $overduePercentage,
            'readerPercentage' => $readerPercentage, // ← kirim ke view

            'activities' => collect()
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
                ->take(6)
        ]);
    }
}
