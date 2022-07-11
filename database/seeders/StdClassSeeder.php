<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class StdClassSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/std_class.csv';
        $this->tablename = 'std_class';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'student_id', 'teacher_id', 'class_id', 'study_year_id'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
