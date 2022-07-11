<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class MasterLessonSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/mst_lesson.csv';
        $this->tablename = 'mst_lesson';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'code', 'name', 'kkm'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
