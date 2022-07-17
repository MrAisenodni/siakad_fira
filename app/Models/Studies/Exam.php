<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    Lesson,
    ClassModel,
};
use App\Models\Studies\{
    ExamDetail,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'std_exam_schedule';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id')->select('id', 'full_name', 'nip')->where('disabled', 0);
    }
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->select('id', 'name')->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class)->select('id', 'name')->where('disabled', 0);
    }

    public function exam_detail()
    {
        return $this->hasMany(ExamDetail::class, 'header_id', 'id')->select('id', 'header_id', 'student_id')->where('disabled', 0);
    }

    public function get_uts($student, $role)
    {
        if ($role == 'teacher') {
            return DB::table('std_exam_schedule AS a')->select('a.id', 'c.name AS lesson_name', 'd.name AS class_name', 'a.date', 'a.clock_in', 'a.clock_out')
                ->join('mst_lesson AS c', 'c.id', '=', 'a.lesson_id')
                ->join('mst_class AS d', 'd.id', '=', 'a.class_id')
                ->join('mst_teacher AS e', 'e.id', '=', 'a.teacher_id')
                ->where('a.disabled', 0)->where('a.teacher_id', $student)->where('a.type', 'uts')->get();
        } else {
            return DB::table('std_exam_schedule AS a')->select('a.id', 'c.name AS lesson_name', 'd.name AS class_name', 'e.full_name AS teacher_name', 'a.date', 'a.clock_in', 'a.clock_out')
                ->join('std_exam_detail AS b', 'a.id', '=', 'b.header_id')
                ->join('mst_lesson AS c', 'c.id', '=', 'a.lesson_id')
                ->join('mst_class AS d', 'd.id', '=', 'a.class_id')
                ->join('mst_teacher AS e', 'e.id', '=', 'a.teacher_id')
                ->where('a.disabled', 0)->where('b.disabled', 0)->where('b.student_id', $student)->where('a.type', 'uts')->get();
        }
    }

    public function get_uas($student, $role)
    {
        if ($role == 'teacher') {
            return DB::table('std_exam_schedule AS a')->select('a.id', 'c.name AS lesson_name', 'd.name AS class_name', 'a.date', 'a.clock_in', 'a.clock_out')
                ->join('mst_lesson AS c', 'c.id', '=', 'a.lesson_id')
                ->join('mst_class AS d', 'd.id', '=', 'a.class_id')
                ->join('mst_teacher AS e', 'e.id', '=', 'a.teacher_id')
                ->where('a.disabled', 0)->where('a.teacher_id', $student)->where('a.type', 'uas')->get();
        } else {
            return DB::table('std_exam_schedule AS a')->select('a.id', 'c.name AS lesson_name', 'd.name AS class_name', 'e.full_name AS teacher_name', 'a.date', 'a.clock_in', 'a.clock_out')
                ->join('std_exam_detail AS b', 'a.id', '=', 'b.header_id')
                ->join('mst_lesson AS c', 'c.id', '=', 'a.lesson_id')
                ->join('mst_class AS d', 'd.id', '=', 'a.class_id')
                ->join('mst_teacher AS e', 'e.id', '=', 'a.teacher_id')
                ->where('a.disabled', 0)->where('b.disabled', 0)->where('b.student_id', $student)->where('a.type', 'uas')->get();
        }
    }

    public function check_uts($day, $clazz, $clock_in, $clock_out, $id = 0)
    {
        return DB::table('std_exam_schedule AS a')->select('a.id', 'c.id', 'a.date', 'a.clock_in', 'a.clock_out', 'c.name AS clazz', 'd.name AS lesson')
            ->join('mst_class AS c', 'a.class_id', '=', 'c.id')
            ->join('mst_lesson AS d', 'a.lesson_id', '=', 'd.id')
            ->whereRaw("a.id <> ".$id." AND a.type = 'uts' AND a.disabled = 0 AND c.disabled = 0 AND d.disabled = 0 AND a.date LIKE '%".date('Y-m-d', strtotime(str_replace('/', '-', $day)))."%' AND a.class_id = ".$clazz." AND (".$clock_in." BETWEEN TIME_TO_SEC(a.clock_in) AND TIME_TO_SEC(a.clock_out) OR ".$clock_out." BETWEEN TIME_TO_SEC(a.clock_in) AND TIME_TO_SEC(a.clock_out))")
            // ->whereRaw('a.disabled = 0 AND b.disabled = 0 AND c.disabled = 0 AND d.disabled = 0 AND a.day ='.$day.' AND b.class_id = '.$clazz.' AND '.$clock_in.' >= TIME_TO_SEC(a.clock_in) AND '.$clock_out.' <= TIME_TO_SEC(a.clock_out)')
            ->first();
    }

    public function check_uas($day, $clazz, $clock_in, $clock_out, $id = 0)
    {
        return DB::table('std_exam_schedule AS a')->select('a.id', 'c.id', 'a.date', 'a.clock_in', 'a.clock_out', 'c.name AS clazz', 'd.name AS lesson')
            ->join('mst_class AS c', 'a.class_id', '=', 'c.id')
            ->join('mst_lesson AS d', 'a.lesson_id', '=', 'd.id')
            ->whereRaw("a.id <> ".$id." AND a.type = 'uas' AND a.disabled = 0 AND c.disabled = 0 AND d.disabled = 0 AND a.date LIKE '%".date('Y-m-d', strtotime(str_replace('/', '-', $day)))."%' AND a.class_id = ".$clazz." AND (".$clock_in." BETWEEN TIME_TO_SEC(a.clock_in) AND TIME_TO_SEC(a.clock_out) OR ".$clock_out." BETWEEN TIME_TO_SEC(a.clock_in) AND TIME_TO_SEC(a.clock_out))")
            // ->whereRaw('a.disabled = 0 AND b.disabled = 0 AND c.disabled = 0 AND d.disabled = 0 AND a.day ='.$day.' AND b.class_id = '.$clazz.' AND '.$clock_in.' >= TIME_TO_SEC(a.clock_in) AND '.$clock_out.' <= TIME_TO_SEC(a.clock_out)')
            ->first();
    }
}