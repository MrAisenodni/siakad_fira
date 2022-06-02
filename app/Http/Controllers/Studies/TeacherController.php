<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    BloodType,
    Language,
    Occupation,
    Religion,
    StudyYear,
};
use App\Models\Settings\Menu;
use App\Models\Studies\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/guru';
        $this->menus = new Menu();
        $this->teachers = new Teacher();
        $this->religions = new Religion();
        $this->blood_types = new BloodType();
        $this->languages = new Language();
        $this->studies = new StudyYear();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'teachers'      => $this->teachers->select('id', 'nip', 'full_name', 'phone_number', 'role')->where('disabled', 0)->get(),
        ];

        return view('studies.teacher.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'blood_types'       => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'languages'         => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('studies.teacher.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = $this->teachers
                        ->where('nip', $input['nip'])
                        ->where('email', $input['email'])
                        ->where('disabled', 1)
                        ->first();

        $validated = $request->validate([
            'nip'           => 'required|numeric|unique:mst_teacher,nip,1,disabled|digits_between:1,25',
            'full_name'     => 'required',
            'birth_place'   => 'required',
            'birth_date'    => 'required|date_format:d/m/Y',
            'religion'      => 'required',
            'picture'       => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
            'email'         => 'required|email|unique:mst_teacher,email,1,disabled',
            'phone_number'  => 'required|numeric|digits_between:1,25',
            'last_study'    => 'required',
        ]);

        if ($check) {
            $data = [
                'nip'       => $check['nip'],
                'email'     => $check['email'],
                'disabled'  => 0,
            ];
        } else {
            $data = [
                'nip'       => $input['nip'],
                'email'     => $input['email'],
            ];
        }

        $data += [
            'full_name'             => $input['full_name'],
            'birth_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'           => $input['birth_place'],
            'gender'                => $input['gender'],
            'phone_number'          => $input['phone_number'],
            'last_study'            => $input['last_study'],
            'religion_id'           => $input['religion'],
            'role'                  => $input['role'],
            'created_by'            => 'Developer',
            'created_at'            => now(),
        ];

        if ($check) {
            $this->teachers->where('id', $check['id'])->update($data);
        } else {
            $id = $this->teachers->insert($data);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'teacher'           => $this->teachers->where('id', $id)->first(),
        ];
        
        return view('studies.teacher.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $check = $this->teachers
                        ->where('nip', $input['nip'])
                        ->where('email', $input['email'])
                        ->where('disabled', 1)
                        ->first();

        $validated = $request->validate([
            'nip'           => 'required|numeric|unique:mst_teacher,nip,'.$id.',id,disabled,0|digits_between:1,25',
            'full_name'     => 'required',
            'birth_place'   => 'required',
            'birth_date'    => 'required|date_format:d/m/Y',
            'religion'      => 'required',
            'picture'       => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
            'email'         => 'required|email|unique:mst_teacher,email,'.$id.',id,disabled,0',
            'phone_number'  => 'required|numeric|digits_between:1,25',
            'last_study'    => 'required',
        ]);

        if ($check) $this->teachers->where('id', $check['id'])->delete();

        $data = [
            'nip'                   => $input['nip'],
            'email'                 => $input['email'],
            'full_name'             => $input['full_name'],
            'birth_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'           => $input['birth_place'],
            'gender'                => $input['gender'],
            'phone_number'          => $input['phone_number'],
            'last_study'            => $input['last_study'],
            'religion_id'           => $input['religion'],
            'role'                  => $input['role'],
            'updated_by'            => 'Developer',
            'updated_at'            => now(),
        ];

        $this->teachers->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->teachers->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
