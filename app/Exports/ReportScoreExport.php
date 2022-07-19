<?php

namespace App\Exports;

use App\Models\Settings\Provider;
use App\Models\Studies\ReportScore;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportScoreExport implements FromView
{
    public function view() : View 
    {
        return view('studies.report.excel', [
            'provider'      => Provider::all(),
            'reports'       => ReportScore::query()->where('disabled', 0),
        ]);
    }
}
