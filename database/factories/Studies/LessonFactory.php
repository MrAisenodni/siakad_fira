<?php

namespace Database\Factories\Studies;

use App\Models\Studies\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;
    
    public function definition()
    {
        return [
            'teacher_id'        => $this->faker->numberBetween(1, 25),
            'lesson_id'         => $this->faker->numberBetween(1, 18),
            'class_id'          => $this->faker->numberBetween(1, 9),
            'study_year_id'     => $this->faker->numberBetween(1, 4),
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
