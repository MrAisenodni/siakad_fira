<?php

namespace Database\Seeders;

use App\Models\Studies\{
    ClassModel,
    Lesson,
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StudySeeder extends Seeder
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
        ClassModel::truncate();
        Lesson::truncate();
        Schema::enableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        ClassModel::factory()->count(100)->create();
        Lesson::factory()->count(100)->create();
    }
}
