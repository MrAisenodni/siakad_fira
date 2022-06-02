<?php

namespace Database\Factories\Studies;

use App\Models\Studies\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;
    
    public function definition()
    {
        return [
            'nip'               => $this->faker->nik(),
            'full_name'         => $this->faker->name(),
            'birth_place'       => $this->faker->city(),
            'birth_date'        => $this->faker->date(),
            'gender'            => $this->faker->randomElement(['l', 'p']),
            'phone_number'      => $this->faker->phoneNumber(),
            'email'             => $this->faker->freeEmail(),
            'last_study'        => $this->faker->randomElement(['Doktor', 'Sarjana', 'Magister', 'SMA', 'SMP', 'SD']),
            'religion_id'       => $this->faker->randomNumber(1, true),
            'role'              => 'teacher',
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
