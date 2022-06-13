<?php

namespace App\Models\Studies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportScoreDetail extends Model
{
    use HasFactory;

    protected $table = 'std_score_detail';

    public function std_score()
    {
        return belongsTo(ReportScore::class)->where('disabled', 0);
    }
}