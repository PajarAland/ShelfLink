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
}
