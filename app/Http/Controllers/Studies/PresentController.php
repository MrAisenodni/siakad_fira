<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\Month;
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Present,
};
use Illuminate\Http\Request;

class PresentController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/presensi';
        $this->menus = new Menu();
        $this->classes = new ClassModel();
        $this->months = new Month();
        $this->presents = new Present();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'months'        => $this->months->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'student' || session()->get('srole') == 'parent') {
            $month = $request->month;
            $year = $request->year;

            if ($month || $year) {
                $data += [
                    'c_present'     => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('present', '<>', 0)->where('study_date', 'LIKE', $year.'-%'.$month.'-%')->count(),
                    'c_sick'        => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('sick', '<>', 0)->where('study_date', 'LIKE', $year.'-%'.$month.'-%')->count(),
                    'c_permit'      => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('permit', '<>', 0)->where('study_date', 'LIKE', $year.'-%'.$month.'-%')->count(),
                    'c_absent'      => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('absent', '<>', 0)->where('study_date', 'LIKE', $year.'-%'.$month.'-%')->count(),
                    'presents'      => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('study_date', 'LIKE', $year.'-%'.$month.'-%')->get(),
                ];
            } else {
                $data += [
                    'presents'      => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->get(),
                    'c_present'     => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('present', '<>', 0)->count(),
                    'c_sick'        => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('sick', '<>', 0)->count(),
                    'c_permit'      => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('permit', '<>', 0)->count(),
                    'c_absent'      => $this->presents->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('absent', '<>', 0)->count(),
                ];
            }

            $data += [
                'inp_month'     => $month,
                'inp_year'      => $year,
            ];
            
            return view('students.present.index', $data);
        } else {
            if (session()->get('srole') == 'admin') {
                $data['classes'] = $this->classes->selectRaw('MAX(id) AS id, COUNT(student_id) AS student, class_id, study_year_id')->where('disabled', 0)->groupByRaw('class_id, study_year_id')->get();

                return view('studies.present.index', $data);
            } 

            if (session()->get('srole') == 'teacher') {
                $data['classes'] = $this->classes->selectRaw('MAX(id) AS id, COUNT(student_id) AS student, class_id, study_year_id')->where('disabled', 0)->where('teacher_id', session()->get('suser_id'))->groupByRaw('class_id, study_year_id')->get();

                return view('teachers.present.index', $data);
            }
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        
        $validated = $request->validate([
            'study_date'    => 'required',
        ]);

        $check = $this->classes->select('id', 'class_id', 'study_year_id')->where('id', $input['clazz_id'])->first();

        $data['classes'] = $this->classes->select('id', 'class_id', 'study_year_id', 'student_id')
                    ->where('class_id', $check->class_id)->where('study_year_id', $check->study_year_id)
                    ->where('disabled', 0)->orderBy('student_id')->get();

        $data += [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'clazz'         => $check,
            'study_date'    => $input['study_date'],
        ];

        if (session()->get('srole') == 'admin') return view('studies.present.create', $data);
        if (session()->get('srole') == 'teacher') return view('teachers.present.create', $data);
        abort(403);
    }

    public function show(Request $request, $id)
    {
        $month = $request->month;
        $year = $request->year;
        $check = $this->classes->select('id', 'class_id', 'teacher_id', 'study_year_id')->where('id', $id)->first();

        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'       => $this->classes->get_present($check->class_id, $check->study_year_id),
            'months'        => $this->months->select('id', 'name')->where('disabled', 0)->get(),
            'inp_month'     => $month,
            'inp_year'      => $year,
            'clazz'         => $check,
        ];

        if ($month || $year) $data['classes'] = $this->classes->filter_present($check->class_id, $check->study_year_id, $month, $year);
        // dd($data);

        if (session()->get('srole') == 'admin') return view('studies.present.show', $data);
        if (session()->get('srole') == 'teacher') {
            $check = $this->classes->select('id', 'class_id', 'teacher_id', 'study_year_id')->where('teacher_id', session()->get('suser_id'))->where('id', $id)->first();

            $data += [
                'classes'       => $this->classes->get_present($check->class_id, $check->study_year_id),
                'inp_month'     => $month,
                'inp_year'      => $year,
                'clazz'         => $check,
            ];

            return view('teachers.present.show', $data);
        }
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'study_date'    => 'required',
        ]);

        for ($i=1; $i <= $input['c_student']; $i++) { 
            $data = [
                'study_date'        => date('Y-m-d H:i', strtotime(str_replace('/', '-', $input['study_date']))),
                'student_id'        => $input['student'.$i.''],
                'present'           => 0,
                'sick'              => 0,
                'permit'            => 0,
                'absent'            => 0,
                'class_id'          => $input['clazz'.$i.''],
                'created_by'        => session()->get('sname'),
                'created_at'        => now(),
            ];

            if ($input['present'.$i.''] == 'present') $data['present'] = 1;
            if ($input['present'.$i.''] == 'sick') $data['sick'] = 1;
            if ($input['present'.$i.''] == 'permit') $data['permit'] = 1;
            if ($input['present'.$i.''] == 'absent') $data['absent'] = 1;

            $check = $this->presents->select('id')->where('disabled', 0)->where('study_date', date('Y-m-d H:i', strtotime(str_replace('/', '-', $input['study_date']))))
                        ->where('student_id', $input['student'.$i.''])->where('class_id', $input['clazz'.$i.''])->first();

            if ($check) {
                $this->presents->where('id', $check->id)->update($data);
            } else {
                $this->presents->insert($data);
            }
        }

        return redirect($this->url.'/'.$id)->with('status', 'Data berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->presents->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
