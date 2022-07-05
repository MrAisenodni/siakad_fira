<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    ClassModel,
    Lesson as MstLesson,
    StudyYear,
};
use App\Models\Studies\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'std_lesson';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->select('id', 'full_name', 'nip')->where('disabled', 0);
    }
    
    public function study_year()
    {
        return $this->belongsTo(StudyYear::class)->select('id', 'name', 'semester')->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class)->select('id', 'name')->where('disabled', 0);
    }

    public function lesson()
    {
        return $this->belongsTo(MstLesson::class)->select('id', 'name', 'kkm')->where('disabled', 0);
    }

    public function score()
    {
        return $this->belongsTo(ReportScore::class, 'lesson_id', 'lesson_id')->where('disabled', 0);
    }

    public function get_lesson($class_id, $study_year_id)
    {
        return DB::table('std_lesson AS a')->selectRaw('b.id, b.name, c.full_name, b.kkm')->join('mst_lesson AS b', 'a.lesson_id', '=', 'b.id')
            ->join('mst_teacher AS c', 'a.teacher_id', '=', 'c.id')->where('c.disabled', 0)->where('a.disabled', 0)->where('b.disabled', 0)
            ->where('a.class_id', $class_id)->where('study_year_id', $study_year_id)->get();
    }
}