<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'user_id',
        'title',
        'cover',
        'author',
        'category',
        'description',
        'published_year',
        'stock',
    ];

    public function reviews()
    {
        return $this->hasMany(\App\Models\BookReview::class);
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover
            ? asset('storage/' . $this->cover)
            : asset('images/default-book.png');
    }

}
