<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    ClassModel,
    Lesson,
};
use App\Models\Studies\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportScore extends Model
{
    use HasFactory;

    protected $table = 'std_score';

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->where('disabled', 0);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class)->where('disabled', 0);
    }

    public function std_score_detail()
    {
        return $this->hasMany(ReportScoreDetail::class, 'id', 'score_id')->where('disabled', 0);
    }
}