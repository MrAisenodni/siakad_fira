<?php

namespace App\Exports;

use App\Models\Studies\ReportScore;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportScoreExport implements FromCollection, ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ReportScore([
            'Kelas'      => $row['class_id'],
            'Mata Pelajaran'     => $row['lesson_id'],
            'Nama Siswa'    => $row['student_id'],
        ]);
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReportScore::all();
    }
}
