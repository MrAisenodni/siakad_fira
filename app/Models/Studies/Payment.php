<?php

namespace App\Models\Studies;

use App\Models\Studies\Student;
use App\Models\Masters\{
    Month,
    Payment as MstPayment,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function mst_month()
    {
        return $this->belongsTo(Month::class, 'month', 'id')->select('id', 'name')->where('disabled', 0);
    }

    public function total_payment()
    {
        return DB::table('std_payment AS a')->selectRaw('b.id, b.nis, b.full_name, YEAR(b.start_date) AS start_year, b.phone_number, a.status, a.year, COUNT(a.id) AS total')
            ->rightJoin('mst_student AS b', 'a.student_id', '=', 'b.id', 'a.disabled', 0)
            ->where('b.disabled', 0)->groupByRaw('b.id, b.nis, b.full_name, b.start_date, b.phone_number, a.status, a.year')
            ->get();
    }
}