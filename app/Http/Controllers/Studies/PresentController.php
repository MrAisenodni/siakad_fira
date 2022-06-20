<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    Lesson,
    Month,
    Reason,
};
use App\Models\Settings\Menu;
use App\Models\Studies\{
    ClassModel,
    Present,
    Student,
    Teacher,
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
        $this->reasons = new Reason();
        $this->lessons = new Lesson();
        $this->students = new Student();
        $this->teachers = new Teacher();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'classes'       => $this->classes->selectRaw('MAX(id) AS id, class_id, study_year_id')->where('disabled', 0)->groupByRaw('class_id, study_year_id')->get(),
        ];

        if (session()->get('srole') == 'admin') {
            $data['presents'] = $this->presents->select('id', 'clock_in', 'clock_out', 'reason_id', 'reason', 'user_id', 'lesson_id', 'role')
                                    ->where('disabled', 0)->get();
            
            return view('studies.present.index', $data);
        } else {
            if (session()->get('srole') == 'teacher') return view('teachers.present.index', $data);
            if (session()->get('srole') == 'student') return view('students.present.index', $data);
        } 
        abort(403);
    }

    public function show($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'months'        => $this->months->select('id', 'name')->where('disabled', 0)->get(),
            'present'       => $this->classes->select('id', 'class_id', 'study_year_id')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.present.show', $data);
        if (session()->get('srole') == 'teacher') return view('teachers.present.show', $data);
        abort(403);
    }

    public function search(Request $request, $id)
    {
        $input = $request->all();
        $inp_month = $request->month;
        $student = $this->classes->select('student_id')->where('class_id', $input['clazz_id'])->where('study_year_id', $input['study_year_id'])->where('disabled', 0)->get();
        $month = $this->presents->where('month_id', $inp_month)->where('class_id', $id)->where('disabled', 0)->first();

        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'months'        => $this->months->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (!$month) {
            $data += [
                'inp_month'     => $inp_month, 
                'present'       => $this->classes->select('id', 'class_id', 'study_year_id')->where('id', $id)->first(),
            ];

        } else {
            $data['present'] = $month;
        }
        $data['students'] = $this->students->whereIn('id', $student)->where('disabled', 0)->get();
        // dd($data);
        
        return view('teachers.present.create', $data);
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'reasons'           => $this->reasons->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->get(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
            'present'           => $this->presents->where('id', $id)->first(),
        ];
        
        if (session()->get('srole') == 'admin') return view('studies.present.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $reason = $request->reason;
        $other_reason = $request->other_reason;
        $input = $request->all();

        $validated = $request->validate([
            'clock_in'  => 'required',
            'clock_out' => 'required|after:clock_in',
            'lesson'    => 'required',
        ]);

        $data = [
            'clock_in'          => date('Y-m-d H:i', strtotime($input['clock_in'])),
            'clock_out'         => date('Y-m-d H:i', strtotime($input['clock_out'])),
            'lesson_id'         => $input['lesson'],
            'reason_id'         => $input['reason'],
            'reason'            => $input['other_reason'],
            'role'              => $input['role'],
            'updated_by'        => session()->get('sname'),
            'updated_at'        => now(),
        ];

        if ($input['role'] == 'student') {
            $validated = $request->validate(['student' => 'required']);

            $data['user_id'] = $input['student'];
        } else { 
            $validated = $request->validate(['teacher' => 'required']);

            $data['user_id'] = $input['teacher'];
        }

        $this->presents->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
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
