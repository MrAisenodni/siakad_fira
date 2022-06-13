<?php

namespace Database\Factories\Studies;

use App\Models\Studies\ReportScore;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReportScoreFactory extends Factory
{
    protected $model = ReportScore::class;
    
    public function definition()
    {
        return [
            'student_id'        => $this->faker->numberBetween(1, 200),
            'class_id'          => $this->faker->numberBetween(1, 9),
            'lesson_id'         => $this->faker->numberBetween(1, 18),
            'score_1'           => $this->faker->numberBetween(65, 98),
            'score_2'           => $this->faker->numberBetween(65, 98),
            'score_3'           => $this->faker->numberBetween(65, 98),
            'score_4'           => $this->faker->numberBetween(65, 98),
            'score_uts'         => $this->faker->numberBetween(65, 98),
            'score_uas'         => $this->faker->numberBetween(65, 98),
            'score_na'          => $this->faker->numberBetween(65, 98),
            'score_avg'         => $this->faker->numberBetween(65, 98),
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
