<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class StdLessonSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/std_lesson.csv';
        $this->tablename = 'std_lesson';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'lesson_id', 'teacher_id', 'class_id', 'study_year_id'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
