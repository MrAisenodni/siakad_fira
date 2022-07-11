<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class TeacherSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/mst_teacher.csv';
        $this->tablename = 'mst_teacher';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'nip', 'full_name', 'field_study', 'birth_place', 'birth_date',  'gender', 'phone_number', 'last_study', 'religion_id', 'role'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
