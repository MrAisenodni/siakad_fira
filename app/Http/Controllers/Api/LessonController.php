<?php

namespace App\Http\Controllers\Api;

use App\Models\Studies\{
    Lesson,
    Teacher,
};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonController extends Controller
{
    public function __construct() {
        $this->lessons      = new Lesson();
        $this->teachers     = new Teacher();
        $this->title        = 'Mata Pelajaran';
    }

    public function show($id, $cid, $sid)
    {
        $tid = $this->lessons->select('teacher_id')->where('lesson_id', $id)->where('class_id', $cid)->where('study_year_id', $sid)->first();

        $response   = [
            'message'   => 'Guru',
            'data'      => [
                'teacher'   => $this->teachers->select('id', 'full_name')->where('id', $tid->teacher_id)->first(),
            ],
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
