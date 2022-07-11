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

        if (session()->get('srole') == 'admin') return view('studies.teacher.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'blood_types'       => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'languages'         => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.teacher.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'nip'           => 'required|numeric|unique:mst_teacher,nip,1,disabled|digits_between:1,25',
            'full_name'     => 'required',
            'photo'         => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
        ]);

        $data = [
            'nip'                   => $input['nip'],
            'full_name'             => $input['full_name'],
            'birth_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'           => $input['birth_place'],
            'gender'                => $input['gender'],
            'phone_number'          => $input['phone_number'],
            'address'               => $input['address'],
            'last_study'            => $input['last_study'],
            'religion_id'           => $input['religion'],
            'role'                  => 'teacher',
            'role_admin'            => $input['role_admin'],
            'field_study'           => $input['field_study'],
            'created_by'            => session()->get('sname'),
            'created_at'            => now(),
        ];

        if ($request->curriculum_assist) $data['curriculum_assist'] = $request->curriculum_assist;
        if ($request->student_assist) $data['student_assist'] = $request->student_assist;
        if ($request->facilities_assist) $data['facilities_assist'] = $request->facilities_assist;
        if ($request->emissary_assist) $data['emissary_assist'] = $request->emissary_assist;

        if ($request->photo) {
            $file = $request->file('photo');
            $extension = $request->photo->getClientOriginalExtension();  //Get Image Extension
            $fileName =  strtotime(now()).'_'.$request->nis.'_'.$request->full_name.'.'.$extension;  //Concatenate both to get FileName (eg: file.jpg)
            $file->move(public_path().'/images/teachers/', $fileName);  
            $data1 = $fileName;  

            $data['picture'] = '/images/teachers/'.$fileName; 
        }
        
        $this->teachers->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'teacher'           => $this->teachers->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.teacher.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $old_photo = $request->old_photo;

        $validated = $request->validate([
            'nip'           => 'required|numeric|unique:mst_teacher,nip,'.$id.',id,disabled,0|digits_between:1,25',
            'full_name'     => 'required',
            'photo'         => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
        ]);

        $data = [
            'full_name'             => $input['full_name'],
            'birth_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'           => $input['birth_place'],
            'gender'                => $input['gender'],
            'phone_number'          => $input['phone_number'],
            'address'               => $input['address'],
            'last_study'            => $input['last_study'],
            'religion_id'           => $input['religion'],
            'role'                  => 'teacher',
            'role_admin'            => $input['role_admin'],
            'field_study'           => $input['field_study'],
            'curriculum_assist'     => 0,
            'student_assist'        => 0,
            'facilities_assist'     => 0,
            'emissary_assist'       => 0,
            'picture'               => $old_photo,
            'updated_by'            => session()->get('sname'),
            'updated_at'            => now(),
        ];

        if ($request->curriculum_assist) $data['curriculum_assist'] = $request->curriculum_assist;
        if ($request->student_assist) $data['student_assist'] = $request->student_assist;
        if ($request->facilities_assist) $data['facilities_assist'] = $request->facilities_assist;
        if ($request->emissary_assist) $data['emissary_assist'] = $request->emissary_assist;

        if ($request->photo) {
            if ($request->old_photo) File::delete(public_path().$request->old_photo);
            $file = $request->file('photo');
            $extension = $request->photo->getClientOriginalExtension();  //Get Image Extension
            $fileName =  strtotime(now()).'_'.$request->nis.'_'.$request->full_name.'.'.$extension;  //Concatenate both to get FileName (eg: file.jpg)
            $file->move(public_path().'/images/teachers/', $fileName);  
            $data1 = $fileName;  

            $data['picture'] = '/images/teachers/'.$fileName; 
        }

        $this->teachers->where('id', $id)->update($data);

        return redirect(url()->previous())->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->teachers->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
