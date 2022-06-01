<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    ClassModel,
    Lesson as MstLesson,
    StudyYear,
};
use App\Models\Settings\Menu;
use App\Models\Studies\{
    Lesson,
    Teacher,
};
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/mata-pelajaran';
        $this->menus = new Menu();
        $this->classes = new ClassModel();
        $this->lessons = new Lesson();
        $this->mst_lessons = new MstLesson();
        $this->studies = new StudyYear();
        $this->teachers = new Teacher();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'       => $this->lessons->select('id', 'teacher_id', 'class_id', 'study_year_id')->where('disabled', 0)->get(),
        ];

        return view('studies.lesson.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'           => $this->classes->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_lessons'       => $this->mst_lessons->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('studies.lesson.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = $this->lessons
                        ->where('class_id', $input['class'])
                        ->where('teacher_id', $input['teacher'])
                        ->where('lesson_id', $input['lesson'])
                        ->where('study_year_id', $input['study'])
                        ->where('disabled', 1)
                        ->first();

        $validated = $request->validate([
            'class'     => 'required',
            'lesson'   => 'required',
            'study'     => 'required',
            'teacher'   => 'required',
        ]);

        if ($check) {
            $data = [
                'teacher_id'    => $check['teacher'],
                'lesson_id'     => $check['lesson'],
                'class_id'      => $check['class'],
                'study_year_id' => $check['study'],
                'disabled'      => 0,
            ];
        } else {
            $data = [
                'teacher_id'    => $input['teacher'],
                'lesson_id'     => $input['lesson'],
                'class_id'      => $input['class'],
                'study_year_id' => $input['study'],
            ];
        }

        $data += [
            'created_by'            => 'Developer',
            'created_at'            => now(),
        ];

        if ($check) {
            $data += [
                'updated_by'    => null,
                'updated_at'    => null,
            ];

            $this->lessons->where('id', $check['id'])->update($data);
        } else {
            $id = $this->lessons->insert($data);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'           => $this->classes->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_lessons'       => $this->mst_lessons->select('id', 'name')->where('disabled', 0)->get(),
            'lesson'            => $this->lessons->where('id', $id)->first(),
        ];
        
        return view('studies.lesson.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'class'     => 'required',
            'lesson'    => 'required',
            'study'     => 'required',
            'teacher'   => 'required',
        ]);

        $data = [
            'teacher_id'    => $input['teacher'],
            'lesson_id'     => $input['lesson'],
            'class_id'      => $input['class'],
            'study_year_id' => $input['study'],
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
