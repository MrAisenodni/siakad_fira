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
}