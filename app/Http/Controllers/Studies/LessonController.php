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
    Exam,
    Schedule,
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
        $this->exams = new Exam();
        $this->schedules = new Schedule();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'       => $this->lessons->select('id', 'teacher_id', 'class_id', 'study_year_id', 'lesson_id')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.lesson.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'           => $this->classes->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_lessons'       => $this->mst_lessons->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.lesson.create', $data);
        abort(403);
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
            'created_by'            => session()->get('sname'),
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
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'           => $this->classes->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->where('role', 'teacher')->get(),
            'mst_lessons'       => $this->mst_lessons->select('id', 'name')->where('disabled', 0)->get(),
            'lesson'            => $this->lessons->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') return view('studies.lesson.edit', $data);
        abort(403);
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
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $schedule = $this->schedules->where('disabled', 0)->where('lesson_id', $id)->first();
        $uts = $this->exams->where('disabled', 0)->where('type', 'uts')->where('lesson_id', $id)->first();
        $uas = $this->exams->where('disabled', 0)->where('type', 'uas')->where('lesson_id', $id)->first();

        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];
        
        if ($schedule) return redirect(url()->previous())->with('errdel', 'Data gagal dihapus karena Mata Pelajaran masih aktif di Menu')->with('errurl', 'jadwal-pembelajaran')->with('errtitle', 'Jadwal Pelajaran');
        if ($uts) return redirect(url()->previous())->with('errdel', 'Data gagal dihapus karena Jadwal UTS masih aktif di Menu')->with('errurl', 'jadwal-uts')->with('errtitle', 'Jadwal UTS');
        if ($uas) return redirect(url()->previous())->with('errdel', 'Data gagal dihapus karena Jadwal UAS masih aktif di Menu')->with('errurl', 'jadwal-uas')->with('errtitle', 'Jadwal UAS');

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
