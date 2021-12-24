<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{

    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_name' => $this->faker->company,
            'teacher' => $this->faker->name,
            'semester' => $this->faker->randomElement(['1081', '1082', '1091', '1101', '1092']),
            'department' => $this->faker->randomElement(['工程學院英語學士班', '應用外語學系', '資訊傳播學系', '資訊管理學系', '資訊工程學系']),
            'credit' => $this->faker->numberBetween(2, 3),
            'info' => $this->faker->text,

        ];
    }
}
