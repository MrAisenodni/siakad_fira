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
        $this->days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
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
        $custom = explode('|', $request->lesson);

        $validated = $request->validate([
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'lesson'    => 'required',
        ]);

        $str_time = $input['clock_in'].":00";
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $clock_in = $hours * 3600 + $minutes * 60 + $seconds;
        $str_time = $input['clock_out'].":00";
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $clock_out = $hours * 3600 + $minutes * 60 + $seconds;
        
        // Uncomment this validation if you need
        $check = $this->schedules->check_available($input['day'], $custom[1], $clock_in, $clock_out);
        $check_lesson = $this->schedules->select('lesson_id', 'day', 'clock_in', 'clock_out')->where('disabled', 0)->where('lesson_id', $custom[0])->where('day', $input['day'])->first();
        // dd($check, $check_lesson, $clock_in, $clock_out);
        if ($check) return redirect(url()->previous())->with('error', 'kelas')
            ->with('err_day', $this->days[$check->day-1])
            ->with('err_ci', date('H:i', strtotime($check->clock_in)))
            ->with('err_co', date('H:i', strtotime($check->clock_out)))
            ->with('err_clazz', $check->clazz)->withInput();

        if ($check_lesson) return redirect(url()->previous())->with('error', 'mapel')
            ->with('err_day', $this->days[$check_lesson->day-1])
            ->with('err_ci', date('H:i', strtotime($check_lesson->clock_in)))
            ->with('err_co', date('H:i', strtotime($check_lesson->clock_out)))
            ->with('err_lesson', $check_lesson->lesson->lesson->name)->withInput();

        $data = [
            'day'               => $input['day'],
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'lesson_id'         => $custom[0],
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
        $custom = explode('|', $request->lesson);

        $validated = $request->validate([
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'lesson'    => 'required',
        ]);

        $str_time = $input['clock_in'].":00";
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $clock_in = $hours * 3600 + $minutes * 60 + $seconds;
        $str_time = $input['clock_out'].":00";
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $clock_out = $hours * 3600 + $minutes * 60 + $seconds;
        
        // Uncomment this validation if you need
        $check = $this->schedules->check_available($input['day'], $custom[1], $clock_in, $clock_out, $id);
        $check_lesson = $this->schedules->select('lesson_id', 'day', 'clock_in', 'clock_out')->where('disabled', 0)->where('lesson_id', $custom[0])->where('day', $input['day'])->where('id', '<>', $id)->first();
        // dd($check, $check_lesson, $clock_in, $clock_out);
        if ($check) return redirect(url()->previous())->with('error', 'kelas')
            ->with('err_day', $this->days[$check->day-1])
            ->with('err_ci', date('H:i', strtotime($check->clock_in)))
            ->with('err_co', date('H:i', strtotime($check->clock_out)))
            ->with('err_clazz', $check->clazz)->withInput();

        if ($check_lesson) return redirect(url()->previous())->with('error', 'mapel')
            ->with('err_day', $this->days[$check_lesson->day-1])
            ->with('err_ci', date('H:i', strtotime($check_lesson->clock_in)))
            ->with('err_co', date('H:i', strtotime($check_lesson->clock_out)))
            ->with('err_lesson', $check_lesson->lesson->lesson->name)->withInput();

        $data = [
            'day'               => $input['day'],
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'lesson_id'         => $custom[0],
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
