<?php

namespace App\Exports;

use App\Models\Settings\Provider;
use App\Models\Studies\ReportScore;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class ReportScoreExport implements FromView
{
    use Exportable;

    public function __construct(int $id, int $ids) 
    {
        $this->class_id = $id;
        $this->lesson_id = $ids;
    }

    public function view() : View 
    {
        return view('studies.report.excel', [
            'provider'      => Provider::all(),
            'reports'       => DB::table('std_score AS a')->select('b.nis', 'b.full_name', 'a.*')
                ->join('mst_student AS b', 'a.student_id', '=', 'b.id')
                ->where('a.class_id', $this->class_id)->where('a.lesson_id', $this->lesson_id)->where('a.disabled', 0)->get(),
        ]);
    }
}
