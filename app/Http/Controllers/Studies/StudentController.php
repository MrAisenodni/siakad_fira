<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    BloodType,
    FamilyStatus,
    Language,
    Religion,
    StudyYear,
};
use App\Models\Settings\Menu;
use App\Models\Studies\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/siswa';
        $this->menus = new Menu();
        $this->students = new Student();
        $this->religions = new Religion();
        $this->blood_types = new BloodType();
        $this->languages = new Language();
        $this->families = new FamilyStatus();
        $this->studies = new StudyYear();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'students'      => $this->students->where('disabled', 0)->get(),
        ];

        return view('studies.student.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'families'      => $this->families->select('id', 'name')->where('disabled', 0)->get(),
            'religions'     => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'       => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'languages'     => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'blood_types'   => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('studies.student.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = $this->students->select('id', 'disabled', 'code')->where('code', $input['code'])->first();

        $validated = $request->validate([
            'code'          => 'required|unique:mst_student,code,1,disabled',
            'name'          => 'required',
            'kkm'           => 'required|numeric|digits_between:1,5',
        ]);

        if ($check) {
            $data = [
                'code'      => $check['code'],
                'disabled'  => 0,
            ];
        } else {
            $data['code'] = $input['code'];
        }

        $data += [
            'name'          => $input['name'],
            'kkm'           => $input['kkm'],
            'created_by'    => 'Developer',
            'created_at'    => now(),
        ];

        if ($check) {
            $this->students->where('id', $check['id'])->update($data);
        } else {
            $this->students->insert($data);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'families'      => $this->families->select('id', 'name')->where('disabled', 0)->get(),
            'religions'     => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'       => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'languages'     => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'blood_types'   => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'student'       => $this->students->where('id', $id)->first(),
        ];

        return view('studies.student.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $check = $this->students->select('id', 'disabled', 'code')->where('code', $input['code'])->first();

        $validated = $request->validate([
            'code'          => 'required|unique:mst_student,code,'.$id.',id,disabled,0',
            'name'          => 'required',
            'kkm'           => 'required|numeric|digits_between:1,5',
        ]);

        if ($check) $this->students->where('disabled', $check['disabled'])->where('id', $check['id'])->delete();

        $data = [
            'code'          => $input['code'],
            'name'          => $input['name'],
            'kkm'           => $input['kkm'],
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->students->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->students->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
