<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\CommentMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentMessageFactory extends Factory
{
    protected $model=CommentMessage::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'message' => $this->faker->text,
            'user_id' => User::all()->random()->id,
            'comment_id' => Comment::all()->random()->id,
        ];
    }
}
