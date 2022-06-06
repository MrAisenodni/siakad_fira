<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Settings\{
    Login,
    Menu,
    SubMenu,
};
use App\Models\Studies\{
    Teacher,
    Student,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/login';
        $this->logins = new Login();
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->teachers = new Teacher();
        $this->students = new Student();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'logins'        => $this->logins->select('id', 'user_id', 'username', 'role')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('auth.login.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'teachers'      => $this->teachers->select('id', 'full_name', 'nip')->where('disabled', 0)->get(),
            'students'      => $this->students->select('id', 'full_name', 'nis')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('auth.login.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'username'          => 'required',
            'password'          => 'required',
        ]);
        
        if ($request->role == 'teacher') {
            $validated = $request->validate([
                'teacher_name'  => 'required',
            ]);

            $data['user_id'] =$input['teacher_name'];
        } else {
            $validated = $request->validate([
                'student_name'  => 'required',
            ]);

            $data['user_id'] =$input['student_name'];
        }

        $data += [
            'username'      => $input['username'],
            'password'      => Hash::make($input['password']),
            'role'          => $input['role'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->logins->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'teachers'      => $this->teachers->select('id', 'full_name', 'nip')->where('disabled', 0)->get(),
            'students'      => $this->students->select('id', 'full_name', 'nis')->where('disabled', 0)->get(),
            'login'         => $this->logins->select('id', 'user_id', 'username', 'role')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('auth.login.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'username'          => 'required',
            'password'          => 'required',
        ]);
        
        if ($request->role == 'teacher') {
            $validated = $request->validate([
                'teacher_name'  => 'required',
            ]);

            $data['user_id'] =$input['teacher_name'];
        } else {
            $validated = $request->validate([
                'student_name'  => 'required',
            ]);

            $data['user_id'] =$input['student_name'];
        }

        $data += [
            'username'      => $input['username'],
            'password'      => Hash::make($input['password']),
            'role'          => $input['role'],
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->logins->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->logins->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
