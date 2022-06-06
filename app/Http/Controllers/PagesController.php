<?php

namespace App\Http\Controllers;

use App\Models\Settings\{
    Login,
    Menu,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{ Auth, Hash };

class PagesController extends Controller
{
    public function __construct()
    {
        $this->login = new Login();
        $this->menus = new Menu();
    }

    public function dashboard()
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title')->where('url', '/')->first(),
        ];

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
