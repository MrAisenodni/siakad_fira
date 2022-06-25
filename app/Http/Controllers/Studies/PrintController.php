<?php

namespace App\Http\Controllers\Studies;

use App\Models\Studies\{
    ClassModel,
    Teacher,
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->teachers = new Teacher();
        $this->classes = new ClassModel();
    }

    public function print_class($id)
    {
        $clazz = $this->classes->select('class_id', 'teacher_id', 'study_year_id', 'student_id')->where('id', $id)->first();

        $data = [
            'admin'     => session()->get('sname'),
            'head'      => $this->teachers->select('full_name', 'nip')->where('disabled', 0)->where('role', 'head')->first(),
            'classes'   => $this->classes->print($clazz->class_id, $clazz->study_year_id, $clazz->teacher_id),
        ];

        $pdf = PDF::loadView('studies.class.print', $data);
        return $pdf->stream('test.pdf');
    }
}
