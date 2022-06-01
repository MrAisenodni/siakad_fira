<?php

namespace App\Models\Studies;

use App\Models\Studies\{
    Lesson,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}