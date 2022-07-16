<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    ClassModel as MstClass,
    Lesson,
};
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Exam,
    ExamDetail,
    Student,
    Teacher,
};
use Illuminate\Http\Request;

class FinalExamController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/jadwal-uas';
        $this->menus = new Menu();
        $this->classes = new ClassModel();
        $this->mst_classes = new MstClass();
        $this->lessons = new Lesson();
        $this->exam_details = new ExamDetail();
        $this->exams = new Exam();
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
            $data['exams'] = $this->exams->select('id', 'date', 'clock_in', 'clock_out', 'teacher_id', 'lesson_id', 'class_id')->where('disabled', 0)->where('type', 'uas')->orderByRaw('date, clock_in ASC')->get();

            return view('studies.final.index', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $data['exams'] = $this->exams->get_uas(session()->get('suser_id'), session()->get('srole'));
            
            return view('teachers.final.index', $data);
        } else {
            $data['exams'] = $this->exams->get_uas(session()->get('suser_id'), session()->get('srole'));

            return view('students.final.index', $data);
        }
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'classes'           => $this->mst_classes->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.final.create', $data);
        abort(403);
    }

    public function store_student(Request $request)
    {
        $input = $request->all();
        $check = $this->exam_details->select('student_id')->where('disabled', 0)->where('header_id', $input['id'])->get();

        $validated = $request->validate([
            'student'     => 'required',
        ]);

        for ($i = 0; $i < $check->count(); $i++) {
            if ($check[$i]->student_id == $input['student']) return redirect(url()->previous())->with('error', 'Siswa sudah terdaftar.');
        }

        $data = [
            'header_id'     => $input['id'],
            'student_id'    => $input['student'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->exam_details->insert($data);

        return redirect(url()->previous())->with('status', 'Data siswa berhasil ditambahkan');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'date'      => 'required',
            'clock_in'  => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'teacher'   => 'required',
            'lesson'    => 'required',
            'clazz'     => 'required',
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
        $check = $this->exams->whereRaw("date LIKE '%".date('Y-m-d', strtotime(str_replace('/', '-', $input['date'])))."%' AND disabled = 0 AND lesson_id = ".$input['lesson']." AND type = 'uas' AND class_id = ".$input['clazz']." AND ".$clock_in." BETWEEN TIME_TO_SEC(clock_in) AND TIME_TO_SEC(clock_out)")->first();
        // dd($check, $clock_in, $clock_out);
        if ($check) return redirect(url()->previous())->with('error', 'Mata Pelajaran '.$check->lesson->name.' dengan Pengawas ['.$check->teacher->full_name.'] sudah terdaftar pada hari '.date('Y-m-d', strtotime(str_replace('/', '-', $input['date']))).' pukul '.date('H:i', strtotime($check->clock_in)).'-'.date('H:i', strtotime($check->clock_out)))->withInput();

        $data = [
            'date'              => date('Y-m-d', strtotime(str_replace('/', '-', $input['date']))),
            'clock_in'          => $input['clock_in'],
            'clock_out'         => $input['clock_out'],
            'teacher_id'        => $input['teacher'],
            'lesson_id'         => $input['lesson'],
            'class_id'          => $input['clazz'],
            'type'              => 'uas',
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        $id = $this->exams->insertGetId($data);

        $c_class = $this->mst_classes->where('disabled', 0)->count();
        $c_student = $this->students->where('disabled', 0)->count();
        $ex_student = $this->exam_details->select('student_id')->where('disabled', 0)->get();
        $student = $this->classes->select('id', 'student_id')->whereIn('student_id', $ex_student)->where('disabled', 0)->orderBy('id')->get();
        
        if ($c_student && $c_class) {
            for ($i = 0; $i <= round($c_student/$c_class); $i++) {
                $data = [
                    'header_id'         => $id,
                    'student_id'        => $student[$i]->student_id,
                    'class_id'          => $student[$i]->id,
                    'created_by'        => session()->get('sname'),
                    'created_at'        => now(),
                ];
    
                $this->exam_details->insert($data);
            }
        }

        return redirect($this->url.'/'.$id.'/edit')->with('status', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'final'          => $this->finals->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') {
            return view('studies.final.show', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $lesson = $this->lessons->select('class_id')->where('id', $data['final']->lesson_id)->where('disabled', 0)->first();
            $student_id = $this->classes->select('student_id')->where('disabled', 0)->where('class_id', $lesson->class_id)->get();
            $data['students'] = $this->students->select('id', 'nis', 'nisn', 'full_name', 'phone_number', 'home_number')->whereIn('id', $student_id)->where('disabled', 0)->get();

            return view('teachers.final.show', $data);
        } else {
            return view('students.final.show', $data);
        }
    }

    public function edit($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
            'classes'           => $this->mst_classes->select('id', 'name')->where('disabled', 0)->get(),
            'exam'              => $this->exams->where('id', $id)->first(),
        ];
        
        // dd($data['exam']->exam_detail);
        if (session()->get('srole') == 'admin') return view('studies.final.edit', $data);
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

        $this->exams->where('id', $id)->update($data);

        return redirect(url()->previous())->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->exams->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }

    public function destroy_student($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->exam_details->where('id', $id)->update($data);

        return redirect(url()->previous())->with('status', 'Data siswa berhasil dihapus.');
    }
}
