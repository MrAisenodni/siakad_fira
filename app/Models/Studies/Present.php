<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    ClassModel,
    Month
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Present extends Model
{
    use HasFactory;

    protected $table = 'std_present';

    public function get_print($study_year, $class)
    {
        return DB::table('std_present AS a')->select('e.full_name', 'SUM(a.present) AS present')
            ->join('std_class AS b', 'b.id', '=', 'a.class_id')
            ->join('mst_study_year AS c', 'c.id', '=', 'b.study_year_id')
            ->join('mst_class AS e', 'd.id', '=', 'b.class_id')
            ->join('mst_student AS e', 'e.id', '=', 'a.student_id')
            ->where('a.disabled', 0)->where('b.disabled', 0)->where('c.disabled', 0)->where('d.disabled', 0)->where('e.disabled', 0)
            ->where('b.study_year_id', $study_year)->where('b.class_id', $class)
            ->groupByRaw('e.full_name')
            ->orderBy('e.full_name')->get();
    }
}