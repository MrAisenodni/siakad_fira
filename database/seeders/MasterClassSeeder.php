<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JeroenZwart\CsvSeeder\CsvSeeder;

class MasterClassSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->file = '/database/csv/mst_class.csv';
        $this->tablename = 'mst_class';
        $this->defaults = [
            'created_by'    => 'Migrasi'
        ];
        $this->mapping = ['id', 'name'];
        $this->header = false;
    }

    public function run()
    {
        parent::run();
    }
}
