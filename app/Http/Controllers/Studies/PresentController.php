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
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') {
            $data['presents'] = $this->presents->select('id', 'clock_in', 'clock_out', 'reason_id', 'reason', 'user_id', 'lesson_id', 'role')->where('disabled', 0)->get();

            return view('studies.present.index', $data);
        // } elseif (session()->get('srole') == 'teacher') {
        //     return view('teachers.present.index', $data);
        } else {
            abort(403);
        }
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'reasons'           => $this->reasons->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->get(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.present.create', $data);
        abort(403);
    }

    public function store(Request $request)
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
            'created_by'        => session()->get('sname'),
            'created_at'        => now(),
        ];

        if ($input['role'] == 'student') {
            $validated = $request->validate(['student' => 'required']);

            $data['user_id'] = $input['student'];
        } else { 
            $validated = $request->validate(['teacher' => 'required']);

            $data['user_id'] = $input['teacher'];
        }

        $this->presents->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'           => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
            'reasons'           => $this->reasons->select('id', 'name')->where('disabled', 0)->get(),
            'teachers'          => $this->teachers->select('id', 'nip', 'full_name')->where('disabled', 0)->get(),
            'students'          => $this->students->select('id', 'nis', 'full_name')->where('disabled', 0)->get(),
            'present'           => $this->presents->where('id', $id)->first(),
        ];
        
        return view('studies.present.edit', $data);
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
