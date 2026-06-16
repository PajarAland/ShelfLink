<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'book_id',
    'borrow_date',
    'return_date',
    'return_deadline',
    'status',
    'return_photos',
    'ai_damage_detected',
    'ai_confidence',
    'ai_damage_details',
    'ai_suggested_fine',
    'late_fine',
    'damage_fine',
    'total_fine',
];

    protected $casts = [
    'borrow_date' => 'datetime',
    'return_date' => 'datetime',
    'return_deadline' => 'datetime',
    'return_photos' => 'array',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
