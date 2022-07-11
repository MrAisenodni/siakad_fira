<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    Lesson as MstLesson,
    StudyYear,
};
use App\Models\Settings\{
    Login,
    Menu,
};
use App\Models\Studies\{
    ClassModel,
    Lesson,
    ReportScore,
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
        $this->students = new Student();
        $this->study_years = new StudyYear();
    }
    
    public function index(Request $request)
    {
        $inp_study_year = $request->study_year;

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
            $data += [
                'clazz'         => $this->classes->select('id', 'teacher_id', 'class_id', 'study_year_id')->where('student_id', session()->get('suser_id'))->first(),
                'study_years'   => $this->study_years->select('id', 'name', 'semester')->where('disabled', 0)->get(),
                'reports'       => $this->reports->where('disabled', 0)->where('student_id', session()->get('suser_id'))->get(),
            ];

            if ($inp_study_year) $data['inp_study_year'] = $inp_study_year;

            return view('students.report.index', $data);
        }
    }

    public function create()
    {
        // $class = $this->classes->select('class_id AS id', 'student_id')->where('student_id', $id)->first();
        // $lesson = $this->lessons->select('lesson_id')->where('class_id', $class->id)->where('disabled', 0)->get();

        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            // 'class'             => $class->id,
            // 'id'                => $class->student_id,
            // 'reports'           => $this->reports->where('student_id', $id)->where('class_id', $class->id)->get(),
            // 'lessons'           => $this->mst_lessons->whereIn('id', $lesson)->where('disabled', 0)->get(),
            // 'student'           => $this->students->select('id', 'nis', 'nisn', 'full_name')->where('id', $id)->first(),
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

        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lesson'            => $this->lessons->select('teacher_id', 'lesson_id')->where('id', $ids)->first(),
            'reports'           => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->whereIn('id', $student_id)->orderBy('full_name')->get(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->whereIn('id', $student_id)->orderBy('full_name')->get(),
            'clazz'             => $clazz,
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

        $clazz = $this->classes->select('id', 'teacher_id', 'class_id', 'study_year_id')->where('id', $id)->first();
        $student = $this->classes->select('student_id')->where('class_id', $clazz->class_id)->where('teacher_id', $clazz->teacher_id)->where('study_year_id', $clazz->study_year_id)->where('disabled', 0)->get();
        
        for ($i = 1; $i <= $input['count']; $i++) 
        {
            $data = [
                'student_id'    => $student[$i-1]->student_id,
                'class_id'      => $id,
                'lesson_id'     => $ids,
                'ph1'           => $input['ph1_'.$student[$i-1]->student_id],
                'ph2'           => $input['ph2_'.$student[$i-1]->student_id],
                'ph3'           => $input['ph3_'.$student[$i-1]->student_id],
                'ph4'           => $input['ph4_'.$student[$i-1]->student_id],
                'ph5'           => $input['ph5_'.$student[$i-1]->student_id],
                'r1'           => $input['r1_'.$student[$i-1]->student_id],
                'r2'           => $input['r2_'.$student[$i-1]->student_id],
                'r3'           => $input['r3_'.$student[$i-1]->student_id],
                'r4'           => $input['r4_'.$student[$i-1]->student_id],
                'r5'           => $input['r5_'.$student[$i-1]->student_id],
                'n1'           => $input['n1_'.$student[$i-1]->student_id],
                'n2'           => $input['n2_'.$student[$i-1]->student_id],
                'n3'           => $input['n3_'.$student[$i-1]->student_id],
                'n4'           => $input['n4_'.$student[$i-1]->student_id],
                'n5'           => $input['n5_'.$student[$i-1]->student_id],
                't1'           => $input['t1_'.$student[$i-1]->student_id],
                't2'           => $input['t2_'.$student[$i-1]->student_id],
                't3'           => $input['t3_'.$student[$i-1]->student_id],
                't4'           => $input['t4_'.$student[$i-1]->student_id],
                't5'           => $input['t5_'.$student[$i-1]->student_id],
                'k1'           => $input['k1_'.$student[$i-1]->student_id],
                'k2'           => $input['k2_'.$student[$i-1]->student_id],
                'k3'           => $input['k3_'.$student[$i-1]->student_id],
                'k4'           => $input['k4_'.$student[$i-1]->student_id],
                'k5'           => $input['k5_'.$student[$i-1]->student_id],
                'avg_ph'           => $input['avg_ph'.$student[$i-1]->student_id],
                'avg_t'           => $input['avg_t'.$student[$i-1]->student_id],
                'avg_k'           => $input['avg_k'.$student[$i-1]->student_id],
                'pts'           => $input['pts'.$student[$i-1]->student_id],
                'pas'           => $input['pas'.$student[$i-1]->student_id],
                'npa'           => $input['npa'.$student[$i-1]->student_id],
            ];

            $check = $this->reports->select('id')->where('student_id', $student[$i-1]->student_id)->where('class_id', $id)->where('lesson_id', $ids)->where('disabled', 0)->first();
            if ($check) {
                $data += [
                    'updated_by'        => session()->get('sname'),
                    'updated_at'        => now(),
                ];

                $this->reports->where('id', $check->id)->update($data);
            } else {
                $data += [
                    'created_by'        => session()->get('sname'),
                    'created_at'        => now(),
                ];

                $this->reports->insert($data);
            }

        }
        return redirect($this->url.'/'.$id.'/'.$ids.'/edit')->with('status', 'Nilai Siswa berhasil disimpan.');
    }

    public function destroy(Request $request, $id)
    {
    }
}
