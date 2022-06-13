<?php

namespace App\Models\Masters;

use App\Models\Studies\ReportScore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'mst_lesson';

    public function score()
    {
        return $this->hasMany(ReportScore::class, 'id', 'lesson_id')->where('disabled', 0);
    }
}