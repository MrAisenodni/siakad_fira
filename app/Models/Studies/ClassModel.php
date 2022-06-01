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

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'std_class';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->select('id', 'full_name', 'nip')->where('disabled', 0);
    }
    
    public function study_year()
    {
        return $this->belongsTo(StudyYear::class)->select('id', 'name', 'semester')->where('disabled', 0);
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->select('nisn', 'nis', 'id', 'full_name')->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(MstClass::class)->select('id', 'name')->where('disabled', 0);
    }
}