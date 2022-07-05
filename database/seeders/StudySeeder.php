<?php

namespace Database\Seeders;

use App\Models\Studies\{
    ClassModel,
    Lesson,
    Schedule,
    ReportScore,
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
        Schedule::truncate();
        ReportScore::truncate();
        Schema::enableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        // Kelas
        for ($i=1; $i<9; $i++) {
            $a = ($i-1)*25;

            ClassModel::factory()->count(25)->sequence(fn ($sequence) => 
                [
                    'student_id'    => $a+($sequence->index+1),
                    'teacher_id'    => $i*3,
                    'class_id'      => $i,
                ])->create();
        }

        // Mata Pelajaran
        for ($i=1; $i<9; $i++) {
            Lesson::factory()->count(18)->sequence(fn ($sequence) =>
            [
                'lesson_id'         => $sequence->index+1,
                'class_id'          => $i,
            ])->create();
        }

        // Jadwal Pelajaran
        for ($i=1; $i<6; $i++) {
            $a = 18;

            Schedule::factory()->count($a)->sequence(fn ($sequence) =>
            [
                'day'               => $i,
                'clock_in'          => date('H:i', strtotime('07:00')),
                'clock_out'         => date('H:i', strtotime('09:00')),
            ])->create();

            Schedule::factory()->count($a)->sequence(fn ($sequence) =>
            [
                'day'               => $i,
                'clock_in'          => date('H:i', strtotime('09:00')),
                'clock_out'         => date('H:i', strtotime('11:00')),
            ])->create();

            Schedule::factory()->count($a)->sequence(fn ($sequence) =>
            [
                'day'               => $i,
                'clock_in'          => date('H:i', strtotime('12:30')),
                'clock_out'         => date('H:i', strtotime('14:30')),
            ])->create();
        }

        // Nilai Siswa
        // ReportScore::factory()->count(450)->create();
    }
}
