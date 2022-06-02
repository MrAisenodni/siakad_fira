<?php

namespace App\Models\Settings;

use App\Models\Studies\{
    Student,
    Teacher,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    protected $table = 'stg_login';

    public function student() 
    {
        return $this->belongsTo(Student::class, 'user_id', 'id')->where('disabled', 0);
    }

    public function teacher() 
    {
        return $this->belongsTo(Teacher::class, 'user_id', 'id')->where('disabled', 0);
    }
}
