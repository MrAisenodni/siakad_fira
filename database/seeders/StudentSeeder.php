<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class StudentSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/mst_student.csv';
        $this->tablename = 'mst_student';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'nis', 'nik', 'nisn', 'full_name', 'birth_place', 'birth_date', 'gender', 'religion_id', 'language_id', 'blood_type_id', 'height', 'weight', 'family_status', 'child_to', 'child_count', 'citizen', 'address', 'level', 'extracurricular_id', 'study_year_id', 'sttb_no', 'first_study', 'from_study_date', 'to_study_date'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
