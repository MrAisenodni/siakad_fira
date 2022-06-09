<?php

namespace App\Http\Controllers\Api;

use App\Models\Studies\{
    ClassModel,
    Student,
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function __construct() {
        $this->classes      = new ClassModel();
        $this->students     = new Student();
        $this->title        = 'Siswa';
    }

    public function show($id)
    {
        $response   = [
            'message'   => 'Daftar '.$this->title,
            'data'      => [
                'student'   => $this->students->select('id', 'nis', 'full_name')->where('id', $id)->first(),
                'claz'      => $this->classes->select('std_class.id', 'class_id', 'name')->join('mst_class', 'std_class.class_id', '=', 'mst_class.id')->where('student_id', $id)->first(),
            ],
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
