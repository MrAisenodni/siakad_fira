<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    ClassModel,
    Lesson,
};
use App\Models\Studies\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportScore extends Model
{
    use HasFactory;

    protected $table = 'std_score';

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class)->where('disabled', 0);
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->where('disabled', 0)->orderBy('full_name');
    }

    public function get_report($id, $ids)
    {
        return $this->where('disabled', 0)->where('class_id', $id)->where('lesson_id', $ids)->with(['student' => function ($query) {
            $query->where('disabled', 0)->orderBy('full_name');
        }])->get();
    }

    public function get_excel()
    {
        DB::table('std_score AS a')->select('b.full_name', 'c.name', 'd.name')
            ->join('mst_student AS b', 'b.id', '=', 'a.student_id')
            ->join('mst_class AS c', 'c.id', '=', 'a.class_id')
            ->join('mst_lesson AS d', 'd.id', '=', 'a.lesson_id')
            // ->where('a.class_id', $id)
            ->where('a.disabled', 0);
    }
}