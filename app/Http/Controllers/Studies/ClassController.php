<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    ClassModel as MstClass,
    StudyYear,
};
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Student,
    Teacher,
};
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/kelas';
        $this->menus = new Menu();
        $this->classes = new ClassModel();
        $this->mst_classes = new MstClass();
        $this->students = new Student();
        $this->studies = new StudyYear();
        $this->teachers = new Teacher();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'       => $this->classes->select('id', 'student_id', 'teacher_id', 'class_id', 'study_year_id')->where('disabled', 0)->get(),
        ];

        return view('studies.class.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_classes'       => $this->mst_classes->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('studies.class.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = $this->classes
                        ->where('class_id', $input['class'])
                        ->where('teacher_id', $input['teacher'])
                        ->where('student_id', $input['student'])
                        ->where('study_year_id', $input['study'])
                        ->where('disabled', 1)
                        ->first();

        $validated = $request->validate([
            'class'     => 'required',
            'student'   => 'required',
            'study'     => 'required',
            'teacher'   => 'required',
        ]);

        if ($check) {
            $data = [
                'teacher_id'    => $check['teacher'],
                'student_id'    => $check['student'],
                'class_id'      => $check['class'],
                'study_year_id' => $check['study'],
                'disabled'      => 0,
            ];
        } else {
            $data = [
                'teacher_id'    => $input['teacher'],
                'student_id'    => $input['student'],
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

            $this->classes->where('id', $check['id'])->update($data);
        } else {
            $id = $this->classes->insert($data);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_classes'       => $this->mst_classes->select('id', 'name')->where('disabled', 0)->get(),
            'class'             => $this->classes->where('id', $id)->first(),
        ];
        
        return view('studies.class.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'class'     => 'required',
            'student'   => 'required',
            'study'     => 'required',
            'teacher'   => 'required',
        ]);

        $data = [
            'teacher_id'    => $input['teacher'],
            'student_id'    => $input['student'],
            'class_id'      => $input['class'],
            'study_year_id' => $input['study'],
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->classes->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->classes->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
