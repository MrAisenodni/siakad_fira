<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Lesson,
    Schedule,
    Student,
    Teacher,
};
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/jadwal-pembelajaran';
        $this->menus = new Menu();
        $this->classes = new ClassModel();
        $this->lessons = new Lesson();
        $this->schedules = new Schedule();
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
            $data['schedules'] = $this->schedules->select('id', 'day', 'clock_in', 'clock_out', 'lesson_id')->where('disabled', 0)->orderBy('day')->orderBy('clock_in')->get();

            return view('studies.schedule.index', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $lesson_id = $this->lessons->select('id')->where('teacher_id', session()->get('suser_id'))->where('disabled', 0)->get();
            
            $data['schedules'] = $this->schedules->select('id', 'day', 'clock_in', 'clock_out', 'lesson_id')->whereIn('lesson_id', $lesson_id)->where('disabled', 0)->orderBy('day')->get();
            
            return view('teachers.schedule.index', $data);
        } else {
            $data['schedules'] = $this->schedules->get_schedule(session()->get('suser_id'));

            return view('students.schedule.index', $data);
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

        if (session()->get('srole') == 'admin') return view('studies.schedule.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'lesson'    => 'required',
        ]);

        // Uncomment this validation if you need
        // $check = $this->lessons->where('lesson_id', $input['lesson'])->where('clock_in', $input['clock_in'])->where('clock_out', $input['clock_out'])->where('day', $input['day'])->first();
        // if ($check) return redirect(url()->previous())->with('error', 'Mata Pelajaran '.$check->lesson->name.' sudah terdaftar pada hari '.$check->days->name.' pukul '.$check->clock_in.'-'.$check->clock_out);

        $data = [
            'day'               => $input['day'],
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'lesson_id'         => $input['lesson'],
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        $this->schedules->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'schedule'          => $this->schedules->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') {
            return view('studies.schedule.show', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $lesson = $this->lessons->select('class_id')->where('id', $data['schedule']->lesson_id)->where('disabled', 0)->first();
            $student_id = $this->classes->select('student_id')->where('disabled', 0)->where('class_id', $lesson->class_id)->get();
            $data['students'] = $this->students->select('id', 'nis', 'nisn', 'full_name', 'phone_number', 'home_number')->whereIn('id', $student_id)->where('disabled', 0)->get();

            return view('teachers.schedule.show', $data);
        } else {
            return view('students.schedule.show', $data);
        }
    }

    public function edit($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'teacher_id', 'class_id', 'study_year_id', 'lesson_id')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'schedule'          => $this->schedules->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') return view('studies.schedule.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'lesson'    => 'required',
        ]);

        $data = [
            'day'               => $input['day'],
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'lesson_id'         => $input['lesson'],
            'updated_by'        => session()->get('sname'),
            'updated_at'        => now(),
        ];

        $this->schedules->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->schedules->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
