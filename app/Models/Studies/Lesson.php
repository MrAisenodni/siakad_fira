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
        return $this->belongsTo(MstLesson::class)->select('id', 'name')->where('disabled', 0);
    }
}