<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    BloodType,
    Extracurricular,
    Language,
    Religion,
    FamilyStatus,
    StudyYear,
};
use App\Models\Studies\{
    ClassModel,
    ParentModel,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'mst_student';

    public function religion()
    {
        return $this->belongsTo(Religion::class)->select('id', 'name')->where('disabled', 0);
    }

    public function family_status()
    {
        return $this->belongsTo(FamilyStatus::class)->select('id', 'name')->where('disabled', 0);
    }

    public function study_year()
    {
        return $this->belongsTo(StudyYear::class)->select('id', 'name', 'semester')->where('disabled', 0);
    }

    public function language()
    {
        return $this->belongsTo(Language::class)->select('id', 'name')->where('disabled', 0);
    }

    public function blood_type()
    {
        return $this->belongsTo(BloodType::class)->select('id', 'name')->where('disabled', 0);
    }

    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class)->select('id', 'name')->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'id', 'student_id')->select('id', 'student_id', 'class_id')->where('disabled', 0);
    }
}