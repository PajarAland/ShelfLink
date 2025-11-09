<?php

namespace Database\Factories;

use App\Models\ReviewVote;
use App\Models\BookReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewVoteFactory extends Factory
{
    protected $model = ReviewVote::class;

    public function definition()
    {
        return [
            'review_id' => BookReview::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['upvote', 'downvote']),
        ];
    }
}
