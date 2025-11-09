<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewVote extends Model
{
    use HasFactory; // ✅ Tambahkan ini

    protected $fillable = [
        'review_id',
        'user_id',
        'type',
    ];

    public function review()
    {
        return $this->belongsTo(BookReview::class, 'review_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
