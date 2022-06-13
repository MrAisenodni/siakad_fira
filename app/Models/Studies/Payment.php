<?php

namespace App\Models\Studies;

use App\Models\Studies\Student;
use App\Models\Masters\Payment as MstPayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'std_payment';

    public function student()
    {
        return $this->belongsTo(Student::class)->select('id', 'full_name', 'nis', 'phone_number')->where('disabled', 0);
    }

    public function payment()
    {
        return $this->belongsTo(MstPayment::class)->select('id', 'year', 'amount')->where('disabled', 0);
    }
}