<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Lesson,
    Schedule,
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
        $this->teachers = new Teacher();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') {
            $data['schedules'] = $this->schedules->select('id', 'day', 'clock_in', 'clock_out', 'spv_teacher_id', 'type', 'lesson_id')->where('disabled', 0)->orderBy('day')->orderBy('clock_in')->get();

            return view('studies.schedule.index', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $lesson_id = $this->lessons->select('id')->where('teacher_id', session()->get('suser_id'))->where('disabled', 0)->get();
            dd($lesson_id);
            $data['schedules'] = $this->schedules->select('id', 'day', 'clock_in', 'clock_out', 'spv_teacher_id', 'type', 'lesson_id')->where('lesson_id', $lesson_id)->where('disabled', 0)->orderBy('day')->get();
            
            return view('teachers.schedule.index', $data);
        } else {
            $class = $this->classes->select('id')->where('student_id', session()->get('suser_id'))->where('disabled', 0)->first();
            $lesson = $this->lessons->select('id')->where('class_id', $class->id)->where('disabled', 0)->get();

            $data['schedules'] = $this->schedules->select('id', 'day', 'clock_in', 'clock_out', 'spv_teacher_id', 'type', 'lesson_id')->whereIn('lesson_id', $lesson)->where('disabled', 0)->orderBy('day')->get();

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

        return view('studies.schedule.create', $data);
    }

    public function store(Request $request)
    {
        $teacher = $request->spv_teacher;
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
            'spv_teacher_id'    => $teacher,
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        $this->schedules->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'teacher_id', 'class_id', 'study_year_id', 'lesson_id')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'schedule'          => $this->schedules->where('id', $id)->first(),
        ];
        
        return view('studies.schedule.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $teacher = $request->spv_teacher;
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
            'spv_teacher_id'    => $teacher,
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
