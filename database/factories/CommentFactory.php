<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;

class CommentFactory extends Factory
{

    protected $model= Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating'=> $this->faker->numberBetween(0,5),
            'teaching'=>$this->faker->text,
            'grading'=>$this->faker->text,
            'assignment'=>$this->faker->text,
            'comment'=>$this->faker->text,
            'user_id'=> User::all()->random()->id,
            'course_id'=>Course::all()->random()->id,
            'isPublish'=>$this->faker->boolean(),
        ];
    }
}
