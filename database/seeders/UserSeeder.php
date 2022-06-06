<?php

namespace Database\Seeders;

use App\Models\Settings\Login;
use App\Models\Studies\{
    ParentModel,
    Student,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{
    Hash,
    Schema
};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate All Table User
        Schema::disableForeignKeyConstraints();
        Login::truncate();
        ParentModel::truncate();
        Student::truncate();
        Teacher::truncate();
        Schema::enableForeignKeyConstraints();

        Student::factory()->count(200)->create();
        ParentModel::factory()->count(200)->sequence(fn ($sequence) => 
            [
                'student_id'    => $sequence->index+1,
                'gender'        => 'l',
            ])->create();
        ParentModel::factory()->count(200)->sequence(fn ($sequence) => 
            [
                'student_id'    => $sequence->index+1,
                'gender'        => 'p',
            ])->create();
        Teacher::factory()->count(25)->create();
        Login::factory()->count(200)->sequence(fn ($sequence) => 
            [
                'user_id'       => $sequence->index+1,
                'username'      => 'siswa'.strval($sequence->index+1),
                'password'      => Hash::make('S15wa!@#'),
                'role'          => 'student',
            ])->create();
        Login::factory()->count(200)->sequence(fn ($sequence) => 
            [
                'user_id'       => $sequence->index+1,
                'username'      => 'orangtua'.strval($sequence->index+1),
                'password'      => Hash::make('P4rent!@#'),
                'role'          => 'parent',
            ])->create();
        Login::factory()->count(25)->sequence(fn ($sequence) => 
            [
                'user_id'       => $sequence->index+1,
                'username'      => 'guru'.strval($sequence->index+1),
                'password'      => Hash::make('T34cher!@#'),
                'role'          => 'teacher',
            ])->create();
        Login::factory()->count(1)->sequence(fn ($sequence) => 
            [
                'user_id'       => $sequence->index,
                'username'      => 'administrator',
                'password'      => Hash::make('Adm1n!@#'),
                'role'          => 'admin',
            ])->create();
    }
}
