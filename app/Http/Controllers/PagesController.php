<?php

namespace App\Http\Controllers;

use App\Models\Settings\{
    Login,
    Menu,
};
use App\Models\Studies\{
    Payment,
    Student,
    Teacher,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{ Auth, Hash };

class PagesController extends Controller
{
    public function __construct()
    {
        $this->login = new Login();
        $this->menus = new Menu();
        $this->students = new Student();
        $this->teachers = new Teacher();
        $this->payments = new Payment();
    }

    public function dashboard()
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title')->where('url', '/')->first(),
            'cf_student'    => $this->students->select('id')->where('gender', 'p')->where('disabled', 0)->count(),
            'cm_student'    => $this->students->select('id')->where('gender', 'l')->where('disabled', 0)->count(),
            'c_student'     => $this->students->select('id')->where('disabled', 0)->count(),
            'cf_teacher'    => $this->teachers->select('id')->where('gender', 'p')->where('disabled', 0)->count(),
            'cm_teacher'    => $this->teachers->select('id')->where('gender', 'l')->where('disabled', 0)->count(),
            'c_teacher'     => $this->teachers->select('id')->where('disabled', 0)->count(),
        ];

        if (session()->get('srole') == 'student' || session()->get('srole') == 'parent') {
            $data += [
                'c_blunas'      => $this->payments->select('id')->where('status', 'belum')->where('student_id', session()->get('suser_id'))->where('disabled', 0)->count(),
                'c_lunas'       => $this->payments->select('id')->where('status', 'lunas')->where('student_id', session()->get('suser_id'))->where('disabled', 0)->count(),
                'c_payment'     => $this->payments->select('id')->where('student_id', session()->get('suser_id'))->where('disabled', 0)->count(),
                's_lunas'       => $this->payments->selectRaw('SUM(amount) AS total')->where('student_id', session()->get('suser_id'))->where('disabled', 0)->where('status', 'belum')->first(),
            ];
        } else {
            $data += [
                'c_blunas'      => $this->payments->select('id')->where('status', 'belum')->where('disabled', 0)->count(),
                'c_lunas'       => $this->payments->select('id')->where('status', 'lunas')->where('disabled', 0)->count(),
                'c_payment'     => $this->payments->select('id')->where('disabled', 0)->count(),
                's_lunas'       => $this->payments->selectRaw('SUM(amount) AS total')->where('disabled', 0)->where('status', 'lunas')->first(),
            ];
        }

        return view('index', $data);
    }

    public function form_login()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'username'              => 'required',
            'password'              => 'required',
        ]);

        $check = $this->login->where('username', $request->username)->first();
        
        if(!$check) {
            return back()->withErrors([
                'username'  => 'Nama Pengguna yang Anda masukkan salah.',
            ]);
        } else {
            // Mengecek password
            if(Hash::check($request->password, $check->password)) {
                $request->session()->put('sid', $check->id);
                $request->session()->put('suser_id', $check->user_id);
                $request->session()->put('susername', $check->username);
                $request->session()->put('spassword', $check->password);
                $request->session()->put('srole', $check->role);
                $request->session()->put('sremember_token', $check->remember_token);
                
                if ($check->role == 'teacher') $request->session()->put('sname', $check->teacher->full_name);
                if ($check->role == 'student' || 'parent' && $check->role != 'admin') $request->session()->put('sname', $check->student->full_name);
                if ($check->role == 'admin') $request->session()->put('sname', 'Administrator');

                return redirect()->intended('/');
            } else {
                return back()->withErrors([
                    'password'  => 'Kata sandi yang Anda masukkan salah.',
                ])->withInput();
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda berhasil keluar.');
    }
}
