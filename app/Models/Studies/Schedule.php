<?php

namespace App\Models\Studies;

use App\Models\Studies\{
    Lesson,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'std_study_schedule';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'spv_teacher_id', 'id')->select('id', 'full_name', 'nip')->where('disabled', 0);
    }
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->select('id', 'lesson_id', 'class_id', 'teacher_id')->where('disabled', 0);
    }

    public function get_schedule($student)
    {
        return DB::table('std_study_schedule AS a')->select('a.id', 'a.day', 'a.clock_in', 'a.clock_out', 'c.name AS lesson_name', 'f.full_name AS teacher_name', 'e.name AS class_name', 'g.full_name AS student_name')
            ->join('std_lesson AS b', 'a.lesson_id', '=', 'b.id')
            ->join('mst_lesson AS c', 'b.lesson_id', '=', 'c.id')
            ->join('std_class AS d', 'b.class_id', '=', 'd.class_id')
            ->join('mst_class AS e', 'd.class_id', '=', 'e.id')
            ->join('mst_teacher AS f', 'b.teacher_id', '=', 'f.id')
            ->join('mst_student AS g', 'd.student_id', '=', 'g.id')
            ->where('a.disabled', 0)->where('b.disabled', 0)->where('c.disabled', 0)->where('d.disabled', 0)->where('e.disabled', 0)
            ->where('f.disabled', 0)->where('g.disabled', 0)->where('d.student_id', $student)->get();
    }
}