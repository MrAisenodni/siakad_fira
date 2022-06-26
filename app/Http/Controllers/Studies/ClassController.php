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
    ParentModel,
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
        $this->parents = new ParentModel();
        $this->students = new Student();
        $this->studies = new StudyYear();
        $this->teachers = new Teacher();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'       => $this->classes->selectRaw('MAX(id) AS id, teacher_id, class_id, study_year_id')->where('disabled', 0)->groupByRaw('teacher_id, class_id, study_year_id')->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.class.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_classes'       => $this->mst_classes->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.class.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $check = $this->classes
                        ->where('class_id', $input['class'])
                        ->where('teacher_id', $input['teacher'])
                        ->where('study_year_id', $input['study'])
                        ->where('disabled', 1)
                        ->first();
        $check1 = $this->classes
                        ->where('class_id', $input['class'])
                        ->where('study_year_id', $input['study'])
                        ->where('disabled', 0)
                        ->first();

        $validated = $request->validate([
            'class'     => 'required',
            'study'     => 'required',
            'teacher'   => 'required',
        ]);

        if ($check1) return redirect(url()->previous())->with('error', 'Data sudah terdaftar.')->withInput();

        if ($check) {
            $data = [
                'teacher_id'    => $check['teacher'],
                'class_id'      => $check['class'],
                'study_year_id' => $check['study'],
                'disabled'      => 0,
            ];
        } else {
            $data = [
                'teacher_id'    => $input['teacher'],
                'class_id'      => $input['class'],
                'study_year_id' => $input['study'],
            ];
        }

        $data += [
            'created_by'            => session()->get('sname'),
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

    public function edit($id)
    {
        $clazz = $this->classes->select('id', 'teacher_id', 'class_id', 'study_year_id')->where('id', $id)->first();
        $student_id = $this->classes->select('student_id')->where('class_id', $clazz->class_id)->where('teacher_id', $clazz->teacher_id)->where('study_year_id', $clazz->study_year_id)->where('disabled', 0)->get();
        $classes = $this->classes->select('id', 'student_id')->where('class_id', $clazz->class_id)->where('teacher_id', $clazz->teacher_id)->where('study_year_id', $clazz->study_year_id)->where('disabled', 0)->get();

        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->whereNotIn('id', $student_id)->get(),
            'clazz'             => $clazz,
            'classes'           => $classes,
        ];
        
        if (session()->get('srole') == 'admin') return view('studies.class.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'student'   => 'required',
        ]);

        $data = [
            'teacher_id'    => $input['teacher_id'],
            'student_id'    => $input['student'],
            'class_id'      => $input['class_id'],
            'study_year_id' => $input['study_year_id'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        // $this->classes->where('id', $id)->update($data);
        $this->classes->insert($data);

        return redirect(url()->previous())->with('status', 'Data berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->classes->where('id', $id)->update($data);

        return redirect(url()->previous())->with('status', 'Data berhasil dihapus.');
    }
}
