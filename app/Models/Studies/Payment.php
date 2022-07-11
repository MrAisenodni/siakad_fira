<?php

namespace App\Models\Studies;

use App\Models\Studies\{
    Student,
};
use App\Models\Masters\{
    ClassModel as MstClass,
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

    public function class()
    {
        return $this->belongsTo(MstClass::class)->select('id', 'name')->where('disabled', 0);
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

    public function print()
    {
        return DB::table('std_payment AS a')->select('a.due_date', 'b.full_name', 'a.student_id', 'd.name AS class_name', 'a.month', 'e.full_name AS teacher_name', 'a.amount', 'a.year', 'a.payment_id')
            ->join('mst_student AS b', 'a.student_id', '=', 'b.id')->join('std_class AS c', 'c.student_id', '=', 'b.id')->join('mst_class AS d', 'd.id', '=', 'c.class_id')->join('mst_teacher AS e', 'e.id', '=', 'c.teacher_id')
            // ->whereRaw(`a.disabled = 0 AND b.disabled = 0 c.disabled = 0 AND c.class_id LIKE '%`.$clazz.`%' AND a.year LIKE '%`.$year.`%'`)
            ->get();
    }

    public function print_filter($year, $clazz)
    {
        return DB::table('std_payment AS a')->select('a.due_date', 'b.full_name', 'a.student_id', 'd.name AS class_name', 'a.month', 'e.full_name AS teacher_name', 'a.amount', 'a.year', 'a.payment_id')
            ->join('mst_student AS b', 'a.student_id', '=', 'b.id')->join('std_class AS c', 'c.student_id', '=', 'b.id')->join('mst_class AS d', 'd.id', '=', 'c.class_id')->join('mst_teacher AS e', 'e.id', '=', 'c.teacher_id')
            ->where('a.disabled', 0)->where('b.disabled', 0)->where('c.disabled', 0)->where('c.class_id', $clazz)->where('a.year', $year)
            ->orderBy('b.full_name')->get();
    }
}