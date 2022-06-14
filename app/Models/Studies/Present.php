<?php

namespace App\Models\Studies;

use App\Models\Masters\{
    Lesson,
    Reason, 
};
use App\Models\Studies\{
    Student,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Present extends Model
{
    use HasFactory;

    protected $table = 'std_present';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'user_id', 'id')->select('id', 'full_name', 'nip')->where('disabled', 0);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'id')->select('id', 'full_name', 'nis', 'nisn')->where('disabled', 0);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->select('id', 'name')->where('disabled', 0);
    }

    public function mst_reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id', 'id')->select('id', 'name')->where('disabled', 0);
    }
}