<?php

namespace Database\Factories\Studies;

use App\Models\Studies\ClassModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClassModelFactory extends Factory
{
    protected $model = ClassModel::class;
    
    public function definition()
    {
        return [
            'student_id'        => $this->faker->numberBetween(1, 200),
            'teacher_id'        => $this->faker->numberBetween(1, 25),
            'class_id'          => $this->faker->numberBetween(1, 9),
            'study_year_id'     => $this->faker->numberBetween(1, 4),
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
