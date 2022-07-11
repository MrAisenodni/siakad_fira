<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class ParentSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/mst_parent.csv';
        $this->tablename = 'mst_parent';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'student_id', 'full_name', 'birth_date', 'birth_place', 'gender', 'citizen', 'religion_id', 'address', 'phone_number', 'parent', 'last_study', 'occupation_id', 'revenue', 'revenue_type', 'died'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
