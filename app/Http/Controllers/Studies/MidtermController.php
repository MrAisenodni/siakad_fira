<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Lesson,
    Midterm,
    Student,
    Teacher,
};
use Illuminate\Http\Request;

class MidtermController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/jadwal-uts';
        $this->menus = new Menu();
        $this->classes = new ClassModel();
        $this->lessons = new Lesson();
        $this->midterms = new Midterm();
        $this->students = new Student();
        $this->teachers = new Teacher();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') {
            $data['midterms'] = $this->midterms->select('id', 'date', 'clock_in', 'clock_out', 'teacher_id', 'lesson_id')->where('disabled', 0)->orderByRaw('date, clock_in ASC')->get();

            return view('studies.midterm.index', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $data['midterms'] = $this->midterms->select('id', 'date', 'clock_in', 'clock_out', 'lesson_id')->where('teacher_id', session()->get('suser_id'))->where('disabled', 0)->orderByRaw('date, clock_in ASC')->get();
            
            return view('teachers.midterm.index', $data);
        } else {
            $class = $this->classes->select('id')->where('student_id', session()->get('suser_id'))->where('disabled', 0)->first();
            $lesson_id = $this->lessons->select('id')->where('class_id', $class->id)->where('disabled', 0)->get();

            $data['midterms'] = $this->midterms->select('id', 'date', 'clock_in', 'clock_out', 'teacher_id', 'lesson_id')->whereIn('lesson_id', $lesson_id)->where('disabled', 0)->orderByRaw('date, clock_in ASC')->get();

            return view('students.midterm.index', $data);
        }
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'teacher_id', 'class_id', 'study_year_id', 'lesson_id')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.midterm.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'teacher'   => 'required',
            'lesson'    => 'required',
        ]);

        $data = [
            'date'              => date('Y-m-d', strtotime(str_replace('/', '-', $input['date']))),
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'teacher_id'        => $input['teacher'],
            'lesson_id'         => $input['lesson'],
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        $this->midterms->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'midterm'          => $this->midterms->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') {
            return view('studies.midterm.show', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $lesson = $this->lessons->select('class_id')->where('id', $data['midterm']->lesson_id)->where('disabled', 0)->first();
            $student_id = $this->classes->select('student_id')->where('disabled', 0)->where('class_id', $lesson->class_id)->get();
            $data['students'] = $this->students->select('id', 'nis', 'nisn', 'full_name', 'phone_number', 'home_number')->whereIn('id', $student_id)->where('disabled', 0)->get();

            return view('teachers.midterm.show', $data);
        } else {
            return view('students.midterm.show', $data);
        }
    }

    public function edit($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'teacher_id', 'class_id', 'study_year_id', 'lesson_id')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'midterm'           => $this->midterms->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') return view('studies.midterm.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'teacher'   => 'required',
            'lesson'    => 'required',
        ]);

        $data = [
            'date'              => date('Y-m-d', strtotime(str_replace('/', '-', $input['date']))),
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'teacher_id'        => $input['teacher'],
            'lesson_id'         => $input['lesson'],
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        $this->midterms->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->midterms->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
