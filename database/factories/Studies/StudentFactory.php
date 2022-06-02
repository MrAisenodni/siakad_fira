<?php

namespace Database\Factories\Studies;

use App\Models\Studies\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;
    
    public function definition()
    {
        return [
            'nik'               => $this->faker->nik(),
            'nis'               => $this->faker->numerify('##########'),
            'nisn'              => $this->faker->numerify('##########'),
            'full_name'         => $this->faker->name(),
            'birth_place'       => $this->faker->city(),
            'birth_date'        => $this->faker->date(),
            'gender'            => $this->faker->randomElement(['l', 'p']),
            'religion_id'       => $this->faker->numberBetween(1, 5),
            'language_id'       => $this->faker->numberBetween(1, 5),
            'blood_type_id'     => $this->faker->numberBetween(1, 5),
            'height'            => $this->faker->numberBetween(140, 200),
            'weight'            => $this->faker->numberBetween(45, 115),
            'distance'          => $this->faker->numberBetween(1, 25),
            'family_status_id'  => $this->faker->numberBetween(1, 5),
            'child_to'          => $this->faker->numberBetween(1, 5),
            'child_count'       => 5,
            'citizen'           => 'wni',
            'address'           => $this->faker->address(),
            'phone_number'      => $this->faker->phoneNumber(),
            'level'             => $this->faker->randomElement(['10', '11', '12']),
            'group'             => $this->faker->randomElement(['Unggulan', 'Biasa', 'Superior']),
            'start_date'        => $this->faker->date(),
            'extracurricular_id'=> $this->faker->numberBetween(1, 5),
            'study_year_id'     => $this->faker->numberBetween(1, 5),
            'sttb_no'           => $this->faker->numerify('############'),
            'first_study'       => $this->faker->company(),
            'major'             => $this->faker->randomElement(['IPA', 'IPS', 'IPC']),
            'start_date'        => $this->faker->dateTimeBetween('-6 years', '-3 years'),
            'start_date'        => $this->faker->dateTimeBetween('-6 years', '-3 years'),
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
