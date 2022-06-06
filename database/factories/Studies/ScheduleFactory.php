<?php

namespace Database\Factories\Studies;

use App\Models\Studies\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;
    
    public function definition()
    {
        return [
            'type'              => 'std',
            'lesson_id'         => $this->faker->numberBetween(1, 144),
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
