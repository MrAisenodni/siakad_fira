<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    BloodType,
    Language,
    Religion,
    StudyYear,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'mst_teacher';

    public function religion()
    {
        return $this->belongsTo(Religion::class)->select('id', 'name')->where('disabled', 0);
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
}