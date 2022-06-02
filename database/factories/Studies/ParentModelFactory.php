<?php

namespace Database\Factories\Studies;

use App\Models\Studies\ParentModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ParentModelFactory extends Factory
{
    protected $model = ParentModel::class;
    
    public function definition()
    {
        return [
            // 'student_id'        => $this->faker->numberBetween(1, 200),
            'full_name'         => $this->faker->name(),
            'birth_place'       => $this->faker->city(),
            'birth_date'        => $this->faker->date(),
            // 'gender'            => 'l',
            'citizen'           => 'wni',
            'address'           => $this->faker->address(),
            'phone_number'      => $this->faker->phoneNumber(),
            'last_study'        => $this->faker->randomElement(['Doktor', 'Sarjana', 'Magister', 'SMA', 'SMP', 'SD']),
            'occupation_id'     => $this->faker->randomNumber(1, true),
            'revenue'           => $this->faker->randomFloat(0, 3000000, 15000000),
            'revenue_type'      => 'month',
            'died'              => $this->faker->numberBetween(1, 2),
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
