<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    Lesson as MstLesson,
};
use App\Models\Settings\{
    Login,
    Menu,
};
use App\Models\Studies\{
    ClassModel,
    Lesson,
    ReportScore,
    ReportScoreDetail,
    ParentModel,
    Student,
};
use Illuminate\Http\Request;

class ReportScoreController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/nilai-siswa';
        $this->classes = new ClassModel();
        $this->logins = new Login();
        $this->lessons = new Lesson();
        $this->menus = new Menu();
        $this->mst_lessons = new MstLesson();
        $this->parents = new ParentModel();
        $this->reports = new ReportScore();
        $this->report_details = new ReportScoreDetail();
        $this->students = new Student();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'       => $this->classes->selectRaw('MAX(id) AS id, teacher_id, class_id, study_year_id')->where('disabled', 0)->groupByRaw('teacher_id, class_id, study_year_id')->get(),
        ];
        
        if (session()->get('srole') == 'admin') {
            return view('studies.report.index', $data);
        } elseif (session()->get('srole') == 'teacher') {
            return view('teachers.report.index', $data);
        } else {
            $data['classes'] = $this->classes->select('id', 'student_id', 'class_id')->where('student_id', session()->get('suser_id'))->get();

            return view('students.report.index', $data);
        }
    }

    public function create($id)
    {
        $class = $this->classes->select('class_id AS id', 'student_id')->where('student_id', $id)->first();
        $lesson = $this->lessons->select('lesson_id')->where('class_id', $class->id)->where('disabled', 0)->get();

        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'class'             => $class->id,
            'id'                => $class->student_id,
            'reports'           => $this->reports->where('student_id', $id)->where('class_id', $class->id)->get(),
            'lessons'           => $this->mst_lessons->whereIn('id', $lesson)->where('disabled', 0)->get(),
            'student'           => $this->students->select('id', 'nis', 'nisn', 'full_name')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') {
            return view('studies.report.create', $data);
        } elseif (session()->get('srole') == 'teacher') {
            return view('teachers.report.create', $data);
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'lesson'        => 'required',
            'score'         => 'required|numeric',
        ]);

        $check = $this->reports->select('id')->where('student_id', $input['id'])->where('class_id', $input['class'])->where('lesson_id', $input['lesson'])->where('disabled', 0)->first();

        if (!$check) {
            $data = [
                'student_id'    => $input['id'],
                'lesson_id'     => $input['lesson'],
                'class_id'      => $input['class'],
                'created_by'    => session()->get('sname'),
                'created_at'    => now(),
            ];
    
            $id = $this->reports->insertGetId($data);
        }

        $data = [
            'score'         => $input['score'],
            'type'          => $input['type'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $check ? $data['score_id'] = $check->id : $data['score_id'] = $id;

        $this->report_details->insert($data);

        $data = [
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $check ? $rdetail = $this->report_details->where('score_id', $check->id)->where('type', $input['type'])->where('disabled', 0)->get()
            : $rdetail = $this->report_details->where('score_id', $id)->where('type', $input['type'])->where('disabled', 0)->get();

        if ($input['type'] == 'uh1') $rdetail->sum('score') != 0 ? $data['score_1'] = $rdetail->sum('score')/$rdetail->count() : $data['score_1'] = 0;
        if ($input['type'] == 'uh2') $rdetail->sum('score') != 0 ? $data['score_2'] = $rdetail->sum('score')/$rdetail->count() : $data['score_2'] = 0;
        if ($input['type'] == 'uh3') $rdetail->sum('score') != 0 ? $data['score_3'] = $rdetail->sum('score')/$rdetail->count() : $data['score_3'] = 0;
        if ($input['type'] == 'uh4') $rdetail->sum('score') != 0 ? $data['score_4'] = $rdetail->sum('score')/$rdetail->count() : $data['score_4'] = 0;
        if ($input['type'] == 'uts') $rdetail->sum('score') != 0 ? $data['score_uts'] = $rdetail->sum('score')/$rdetail->count() : $data['score_uts'] = 0;
        if ($input['type'] == 'uas') $rdetail->sum('score') != 0 ? $data['score_uas'] = $rdetail->sum('score')/$rdetail->count() : $data['score_uas'] = 0;

        $check ? $rdetail = $this->report_details->where('score_id', $check->id)->where('disabled', 0)->get()
            : $rdetail = $this->report_details->where('score_id', $id)->where('disabled', 0)->get();
        $data += [
            'score_na'      => $rdetail->sum('score')/$rdetail->count(),
            'score_avg'     => $rdetail->sum('score')/$rdetail->count(),
        ];

        $check ? $this->reports->where('id', $check->id)->update($data) : $this->reports->where('id', $id)->update($data);

        return redirect($this->url.'/'.$input['id'])->with('status', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $clazz = $this->classes->select('id', 'teacher_id', 'class_id', 'study_year_id')->where('id', $id)->first();
        $classes = $this->classes->select('id', 'student_id')->where('class_id', $clazz->class_id)->where('teacher_id', $clazz->teacher_id)->where('study_year_id', $clazz->study_year_id)->where('disabled', 0)->get();

        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->get_lesson($clazz->class_id, $clazz->study_year_id),
            'clazz'             => $clazz,
            'classes'           => $classes,
        ];

        if (session()->get('srole') == 'admin') {
            return view('studies.report.show', $data);
        } elseif (session()->get('srole') == 'teacher') {
            return view('teachers.report.show', $data);
        } else {
            abort(403);
        }
    }

    public function edit($id, $ids)
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

        if (session()->get('srole') == 'admin') {
            return view('studies.report.edit', $data);
        } elseif (session()->get('srole') == 'teacher') {
            return view('teachers.report.edit', $data);
        } else {
            abort(403);
        }
    }

    public function update(Request $request, $id, $ids)
    {
        $input = $request->all();

        $validated = $request->validate([
            'score'         => 'required|numeric',
        ]);

        $data = [
            'score_id'      => $ids,
            'score'         => $input['score'],
            'type'          => $input['type'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->report_details->insert($data);

        $data = [
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $check = $this->reports->where('id', $ids)->where('disabled', 0)->first();
        $rdetail = $this->report_details->where('score_id', $ids)->where('type', $input['type'])->where('disabled', 0)->get();

        if ($input['type'] == 'uh1') $rdetail->sum('score') != 0 ? $data['score_1'] = $rdetail->sum('score')/$rdetail->count() : $data['score_1'] = 0;
        if ($input['type'] == 'uh2') $rdetail->sum('score') != 0 ? $data['score_2'] = $rdetail->sum('score')/$rdetail->count() : $data['score_2'] = 0;
        if ($input['type'] == 'uh3') $rdetail->sum('score') != 0 ? $data['score_3'] = $rdetail->sum('score')/$rdetail->count() : $data['score_3'] = 0;
        if ($input['type'] == 'uh4') $rdetail->sum('score') != 0 ? $data['score_4'] = $rdetail->sum('score')/$rdetail->count() : $data['score_4'] = 0;
        if ($input['type'] == 'uts') $rdetail->sum('score') != 0 ? $data['score_uts'] = $rdetail->sum('score')/$rdetail->count() : $data['score_uts'] = 0;
        if ($input['type'] == 'uas') $rdetail->sum('score') != 0 ? $data['score_uas'] = $rdetail->sum('score')/$rdetail->count() : $data['score_uas'] = 0;

        $rdetail = $this->report_details->where('score_id', $ids)->where('disabled', 0)->get();
        $data += [
            'score_na'      => $rdetail->sum('score')/$rdetail->count(),
            'score_avg'     => $rdetail->sum('score')/$rdetail->count(),
        ];

        $this->reports->where('id', $ids)->update($data);

        return redirect($this->url.'/'.$id.'/'.$ids.'/edit')->with('status', 'Data berhasil diubah.');
    }

    public function destroy(Request $request, $id)
    {
        $input = $request->all();

        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->report_details->where('id', $id)->update($data);

        $data = [
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $rdetail = $this->report_details->where('score_id', $input['report'])->where('type', $input['type'])->where('disabled', 0)->get();

        if ($input['type'] == 'uh1') $rdetail->sum('score') != 0 ? $data['score_1'] = $rdetail->sum('score')/$rdetail->count() : $data['score_1'] = 0;
        if ($input['type'] == 'uh2') $rdetail->sum('score') != 0 ? $data['score_2'] = $rdetail->sum('score')/$rdetail->count() : $data['score_2'] = 0;
        if ($input['type'] == 'uh3') $rdetail->sum('score') != 0 ? $data['score_3'] = $rdetail->sum('score')/$rdetail->count() : $data['score_3'] = 0;
        if ($input['type'] == 'uh4') $rdetail->sum('score') != 0 ? $data['score_4'] = $rdetail->sum('score')/$rdetail->count() : $data['score_4'] = 0;
        if ($input['type'] == 'uts') $rdetail->sum('score') != 0 ? $data['score_uts'] = $rdetail->sum('score')/$rdetail->count() : $data['score_uts'] = 0;
        if ($input['type'] == 'uas') $rdetail->sum('score') != 0 ? $data['score_uas'] = $rdetail->sum('score')/$rdetail->count() : $data['score_uas'] = 0;

        $rdetail = $this->report_details->where('score_id', $input['report'])->where('disabled', 0)->get();
        $data += [
            'score_na'      => $rdetail->sum('score')/$rdetail->count(),
            'score_avg'     => $rdetail->sum('score')/$rdetail->count(),
        ];

        $this->reports->where('id', $input['report'])->update($data);

        return redirect($this->url.'/'.$input['student'].'/'.$input['report'].'/edit')->with('status', 'Data berhasil dihapus.');
    }
}
