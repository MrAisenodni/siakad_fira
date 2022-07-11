<?php

namespace App\Http\Controllers\Studies;

use App\Models\Masters\Month;
use App\Models\Studies\{
    ClassModel,
    ParentModel,
    Present,
    Payment,
    Student,
    Teacher,
};
use App\Models\Settings\Provider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->months = new Month();
        $this->students = new Student();
        $this->parents = new ParentModel();
        $this->payments = new Payment();
        $this->presents = new Present();
        $this->teachers = new Teacher();
        $this->classes = new ClassModel();
        $this->provider = new Provider();
    }

    public function print_class($id)
    {
        $clazz = $this->classes->select('class_id', 'teacher_id', 'study_year_id', 'student_id')->where('id', $id)->first();

        $data = [
            'admin'     => session()->get('sname'),
            'provider'  => $this->provider->where('disabled', 0)->first(),
            'classes'   => $this->classes->print($clazz->class_id, $clazz->study_year_id, $clazz->teacher_id),
        ];

        $pdf = PDF::loadView('studies.class.print', $data);
        return $pdf->stream(now().'_Kelas_'.$clazz->class->name.'.pdf');
    }

    public function print_present(Request $request, $id)
    {
        $check = $this->classes->select('id', 'class_id', 'teacher_id', 'study_year_id')->where('id', $id)->first();

        $data = [
            'provider'      => $this->provider->where('disabled', 0)->first(),
            'classes'       => $this->classes->get_present($check->class_id, $check->study_year_id),
            'clazz'         => $check,
        ];
        // dd($check->study_year['semester']);

        // if ($check->studey_year['semester'] == 'genap') {
        //     $data['months'] = $this->months->select('name')->where('disabled', 0)->whereIn('id', [1,2,3,4,5,6])->get();
        // } else {
        //     $data['months'] = $this->months->select('name')->where('disabled', 0)->whereIn('id', [7,8,9,10,11,12])->get();
        // }

        $pdf = PDF::loadView('studies.present.print', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('Daftar Presensi Siswa.pdf');
        return view('studies.present.print', $data);
    }

    public function print_payment(Request $request)
    {
        $year = $request->year;
        $clazz = $request->clazz;

        $data = [
            'provider'      => $this->provider->where('disabled', 0)->first(),
            'months'        => $this->months->where('disabled', 0)->get(),
            'payments'      => $this->payments->print(),
        ];

        if ($year && $clazz) $data['payments'] = $this->payments->print_filter($year, $clazz);

        $pdf = PDF::loadView('studies.payment.print', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('Histori Pelunasan SPP.pdf');
        return view('studies.payment.print', $data);
    }

    public function print_student($id)
    {
        $data = [
            'provider'      => $this->provider->where('disabled', 0)->first(),
            'student'       => $this->students->where('id', $id)->first(),
            'father'        => $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'l')->where('disabled', 0)->first(),
            'mother'        => $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'p')->where('disabled', 0)->first(),
            'guardian'      => $this->parents->where('student_id', $id)->where('parent', 0)->where('disabled', 0)->first(),
        ];

        $pdf = PDF::loadView('studies.student.print', $data);
        return $pdf->stream($data['student']->nis.'_Lembar Induk Siswa_'.$data['student']->full_name.'.pdf');
        return view('studies.student.print', $data);
    }

    public function print_all_student()
    {
        $data = [
            'provider'  => $this->provider->where('disabled', 0)->first(),
            'students'       => $this->students->where('disabled', 0)->get(),
        ];

        $pdf = PDF::loadView('studies.student.print_all', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('Lembar Induk Siswa.pdf');
        return view('studies.student.print_all', $data);
    }
    
    public function print_all_teacher()
    {
        $data = [
            'provider'  => $this->provider->where('disabled', 0)->first(),
            'teachers'  => $this->teachers->where('disabled', 0)->get(),
        ];

        $pdf = PDF::loadView('studies.teacher.print_all', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('Lembar Induk Siswa.pdf');
        return view('studies.teacher.print_all', $data);
    }

    public function word_student($id)
    {
        $file = public_path('/document/Format_Lembar-Induk-Siswa.rtf');

        $data = [
            'provider'  => $this->provider->where('disabled', 0)->first(),
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
