<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenuSeeder::class,
            MasterSeeder::class,
            MasterClassSeeder::class,
            MasterLessonSeeder::class,
            StudentSeeder::class,
            ParentSeeder::class,
            TeacherSeeder::class,
            StdClassSeeder::class,
            StdLessonSeeder::class,
            UserSeeder::class,
            // StudySeeder::class,
        ]);
    }
}
