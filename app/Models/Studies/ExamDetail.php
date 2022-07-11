<?php

namespace App\Models\Studies;

use App\Models\Studies\{
    ClassModel,
    Exam,
    Student,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDetail extends Model
{
    use HasFactory;

    protected $table = 'std_exam_detail';

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id')->select('id', 'full_name', 'nis')->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'id')->select('id', 'class_id')->where('disabled', 0);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'header_id', 'id')->where('disabled', 0);
    }
}