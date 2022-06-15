<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    Lesson,
    Reason,
};
use App\Models\Settings\Menu;
use App\Models\Studies\{
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
            'checkin'       => $this->presents->select('id')->where('clock_in', 'LIKE', '%'.date('Y-m-d', strtotime(now())).'%')->where('user_id', session()->get('suser_id'))->where('role', session()->get('srole'))->first(),
            'checkout'      => $this->presents->select('id')->where('clock_out', 'LIKE', '%'.date('Y-m-d', strtotime(now())).'%')->where('user_id', session()->get('suser_id'))->where('role', session()->get('srole'))->first(),
            'checkabs'      => $this->presents->select('id')->whereNull('clock_out')->whereNotNull('reason_id')->where('user_id', session()->get('suser_id'))->where('role', session()->get('srole'))->first(),
        ];

        if (session()->get('srole') == 'admin') {
            $data['presents'] = $this->presents->select('id', 'clock_in', 'clock_out', 'reason_id', 'reason', 'user_id', 'lesson_id', 'role')
                                    ->where('disabled', 0)->get();
            
            return view('studies.present.index', $data);
        } else {
            $data['presents'] = $this->presents->select('id', 'clock_in', 'clock_out', 'reason_id', 'reason', 'user_id', 'lesson_id', 'role')
                                    ->where('role', session()->get('srole'))->where('user_id', session()->get('suser_id'))
                                    ->where('disabled', 0)->get();

            if (session()->get('srole') == 'teacher') return view('teachers.present.index', $data);
            if (session()->get('srole') == 'student') return view('students.present.index', $data);
        } 
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'reasons'           => $this->reasons->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') {
            $data += [
                'teachers'      => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->get(),
                'students'      => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
            ];

            return view('studies.present.create', $data);
        } elseif (session()->get('srole') == 'teacher') {
            $data += [
                'role'          => 'teacher',
                'user_id'       => session()->get('suser_id'),
            ];

            return view('teachers.present.create', $data);
        } else {
            $data += [
                'role'          => 'student',
                'user_id'       => session()->get('suser_id'),
            ];

            return view('students.present.create', $data);
        }
    }

    public function show($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'present'           => $this->presents->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'student' || session()->get('srole') == 'parent') return view('students.present.show', $data);
        if (session()->get('srole') == 'teacher') return view('teachers.present.show', $data);
        abort(403);
    }

    public function clockin(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'reasons'           => $this->reasons->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'teacher') {
            $data += [
                'role'      => 'teacher',
                'user_id'   => session()->get('suser_id'),
            ];

            return view('teachers.present.clockin', $data);
        } elseif (session()->get('srole') == 'student') {
            $data += [
                'role'      => 'student',
                'user_id'   => session()->get('suser_id'),
            ];

            return view('students.present.clockin', $data);
        } else {
            abort(403);
        }
    }

    public function clockout(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'LIKE', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'reasons'           => $this->reasons->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'teacher') {
            $data += [
                'role'      => 'teacher',
                'user_id'   => session()->get('suser_id'),
            ];

            return view('teachers.present.clockout', $data);
        } elseif (session()->get('srole') == 'student') {
            $data += [
                'role'      => 'student',
                'user_id'   => session()->get('suser_id'),
            ];

            return view('students.present.clockout', $data);
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $reason = $request->reason;
        $other_reason = $request->other_reason;
        $clock_in = $request->clock_in;
        $clock_out = $request->clock_out;
        $input = $request->all();
        $check = $this->presents->select('id')->where('clock_in', 'LIKE', '%'.date('Y-m-d', strtotime(now())).'%')
                    ->where('user_id', session()->get('suser_id'))->where('role', session()->get('srole'))->first();

        $validated = $request->validate([
            'lesson'    => 'required',
        ]);

        $data = [
            'role'              => $input['role'],
            'user_id'           => $input['user_id'],
            'lesson_id'         => $input['lesson'],
            'reason_id'         => $reason,
            'reason'            => $other_reason,
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        if (session()->get('srole') == 'admin') {
            if ($input['role'] == 'student') $data['user_id'] = $input['student'];
            if ($input['role'] == 'teacher') $data['user_id'] = $input['teacher'];

            $data += [
                'clock_in'          => date('Y-m-d H:i', strtotime($input['clock_in'])),
                'clock_out'         => date('Y-m-d H:i', strtotime($input['clock_out'])),
            ];
        } else {
            if ($clock_out) $data['clock_out'] = $input['date_in'].' '.$clock_out;
            if ($clock_in) {
                $data['clock_in'] = $input['date_in'].' '.$clock_in;
            } else {
                $data['clock_in'] = $input['date_in'];
            }  
        } 

        if ($clock_out) {
            $this->presents->where('id', $check->id)->update($data);
        } else {
            $this->presents->insert($data);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
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
