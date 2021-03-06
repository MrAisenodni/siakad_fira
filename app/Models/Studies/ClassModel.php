<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    ClassModel as MstClass,
    StudyYear,
};
use App\Models\Studies\{
    Student,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'std_class';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->select('id', 'full_name', 'nip')->where('disabled', 0)->orderBy('nip');
    }
    
    public function study_year()
    {
        return $this->belongsTo(StudyYear::class)->select('id', 'name', 'semester')->where('disabled', 0);
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->select('nisn', 'nis', 'id', 'full_name', 'gender', 'phone_number', 'home_number', 'religion_id', 'address')->where('disabled', 0)->orderBy('nis');
    }

    public function class()
    {
        return $this->belongsTo(MstClass::class)->select('id', 'name')->where('disabled', 0);
    }

    public function get_present($class_id, $study_year_id)
    {
        return DB::table('std_present AS a')->selectRaw('c.full_name, b.class_id, b.study_year_id, SUM(a.present) AS present, SUM(a.sick) AS sick, SUM(a.permit) AS permit, SUM(a.absent) AS absent')
            ->rightJoin('std_class AS b', 'b.id', '=', 'a.class_id', 'a.disabled = 0')
            ->join('mst_student AS c', 'c.id', '=', 'b.student_id')
            ->where('b.disabled', 0)->where('b.class_id', $class_id)->where('b.study_year_id', $study_year_id)
            ->groupByRaw('c.full_name, b.class_id, b.study_year_id')->orderBy('c.full_name')->get();
    }

    public function filter_present($class_id, $study_year_id, $month, $year)
    {
        return DB::table('std_present AS a')->selectRaw('c.full_name, b.class_id, b.study_year_id, SUM(a.present) AS present, SUM(a.sick) AS sick, SUM(a.permit) AS permit, SUM(a.absent) AS absent')
            ->rightJoin('std_class AS b', 'b.id', '=', 'a.class_id', 'a.disabled = 0')
            ->join('mst_student AS c', 'c.id', '=', 'b.student_id')
            ->where('b.disabled', 0)->where('b.class_id', $class_id)->where('b.study_year_id', $study_year_id)
            ->where('a.study_date', 'LIKE', $year.'-%'.$month.'-%')
            ->groupByRaw('c.full_name, b.class_id, b.study_year_id')->orderBy('c.full_name')->get();
    }

    public function print($class_id, $study_year_id, $teacher_id)
    {
        return DB::table('std_class AS a')->selectRaw('b.nis, b.nisn, b.full_name, b.gender, c.name AS class, d.name AS study_year, e.full_name AS teacher')
            ->join('mst_student AS b', 'b.id', '=', 'a.student_id')
            ->join('mst_class AS c', 'c.id', '=', 'a.class_id')
            ->join('mst_study_year AS d', 'd.id', '=', 'a.study_year_id')
            ->join('mst_teacher AS e', 'e.id', '=', 'a.teacher_id')
            ->where('a.disabled', 0)->where('b.disabled', 0)->where('c.disabled', 0)->where('d.disabled', 0)
            ->where('e.disabled', 0)->where('a.class_id', $class_id)->where('a.study_year_id', $study_year_id)
            ->where('a.teacher_id', $teacher_id)->orderByRaw('nis ASC')->get();
    }
}