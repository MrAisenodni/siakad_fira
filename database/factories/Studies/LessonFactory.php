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
            'study_year_id'     => 1,
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
