<?php

namespace Database\Factories\Settings;

use App\Models\Settings\Login;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LoginFactory extends Factory
{
    protected $model = Login::class;
    
    public function definition()
    {
        return [
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'created_by'        => 'Migrasi',
        ];
    }
}
