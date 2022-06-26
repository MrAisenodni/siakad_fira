<?php

namespace App\Http\Controllers\Studies;

use App\Models\Studies\{
    ClassModel,
    ParentModel,
    Student,
    Teacher,
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->students = new Student();
        $this->parents = new ParentModel();
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
        return $pdf->stream(now().'_Kelas_'.$clazz->class->name.'.pdf');
    }

    public function print_student($id)
    {
        $data = [
            'student'       => $this->students->where('id', $id)->first(),
            'father'        => $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'l')->where('disabled', 0)->first(),
            'mother'        => $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'p')->where('disabled', 0)->first(),
            'guardian'      => $this->parents->where('student_id', $id)->where('parent', 0)->where('disabled', 0)->first(),
        ];

        $pdf = PDF::loadView('studies.student.print', $data);
        return $pdf->stream($data['student']->nis.'_Lembar Induk Siswa_'.$data['student']->full_name.'.pdf');
        return view('studies.student.print', $data);
    }

    public function word_student($id)
    {
        $file = public_path('/document/Format_Lembar-Induk-Siswa.rtf');

        $data = [
            'student'       => $this->students->where('id', $id)->first(),
            'father'        => $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'l')->where('disabled', 0)->first(),
            'mother'        => $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'p')->where('disabled', 0)->first(),
            'guardian'      => $this->parents->where('student_id', $id)->where('parent', 0)->where('disabled', 0)->first(),
        ];

        $array = array(
            '[NIS]'         => $data['student']->nis,
            '[NISN]'        => $data['student']->nisn,
        );
        $export = $data['student']->nis.'_Lembar Induk Siswa_'.$data['student']->full_name.'.docx';

        return \WordTemplate::export($file, $array, $export);
    }
}
