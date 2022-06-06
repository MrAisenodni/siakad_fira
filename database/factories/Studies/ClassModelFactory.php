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
            'study_year_id'     => 1,
            'created_at'        => now(),
            'created_by'        => 'Migrasi',
        ];
    }
}
