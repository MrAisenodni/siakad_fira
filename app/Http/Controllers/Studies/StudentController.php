<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    BloodType,
    Extracurricular,
    FamilyStatus,
    Language,
    Occupation,
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
        $this->occupations = new Occupation();
        $this->extracurriculars = new Extracurricular();
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
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'families'          => $this->families->select('id', 'name')->where('disabled', 0)->get(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'languages'         => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'blood_types'       => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'occupations'       => $this->occupations->select('id', 'name')->where('disabled', 0)->get(),
            'extracurriculars'  => $this->extracurriculars->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('studies.student.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $check = $this->students
                        ->where('nik', $input['nik'])
                        ->where('nis', $input['nis'])
                        ->where('nisn', $input['nisn'])
                        ->where('disabled', 1)
                        ->first();

        $validated = $request->validate([
            'nik'           => 'required|numeric|unique:mst_student,nik,1,disabled|digits_between:1,16',
            'nis'           => 'required|numeric|unique:mst_student,nis,1,disabled|digits_between:1,20',
            'nisn'          => 'required|numeric|unique:mst_student,nisn,1,disabled|digits_between:1,20',
            'full_name'     => 'required',
            'birth_place'   => 'required',
            'birth_date'    => 'required|date_format:d/m/Y',
            'religion'      => 'required',
            'language'      => 'required',
            'height'        => 'required|numeric',
            'weight'        => 'required|numeric',
            'picture'       => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2048',
            
            // Validasi Keluarga
            'family_status'     => 'required',
            'child_to'          => 'required|numeric|digits_between:1,2',
            'child_count'       => 'required|numeric|digits_between:1,2',
            'stepbrother_count' => 'numeric|digits_between:1,2',
            'stepsibling_count' => 'numeric|digits_between:1,2',
            'citizen'           => 'required',

            // Validasi Kontak
            'address'       => 'required',
            'distance'      => 'required|numeric|digits_between:1,7',
            'phone_number'  => 'required|numeric|digits_between:1,25',
            'home_number'   => 'numeric|digits_between:1,25',

            // Validasi Pendidikan
            'level'             => 'required',
            'group'             => 'required',
            'start_date'        => 'required|date_format:d/m/Y',
            'study_year'        => 'required',
            'sttb_no'           => 'required',
            'first_study'       => 'required',
            'from_study_date'   => 'required|date_format:d/m/Y',
            'to_study_date'     => 'required|date_format:d/m/Y',

            // Validasi Ayah
            // 'father_name'           => 'required',
            // 'father_birth_place'    => 'required',
            // 'father_birth_date'     => 'required|date_format:d/m/Y',
            // 'father_citizen'        => 'required',
            // 'father_address'        => 'required',
            // 'father_phone_number'   => 'required|numeric|digits_between:1,25',
            // 'father_home_number'    => 'numeric|digits_between:1,25',
            // 'father_last_study'     => 'required',
            // 'father_occupation'     => 'required',
            // 'father_revenue'        => 'required|numeric',

            // // Validasi Ibu
            // 'mother_name'           => 'required',
            // 'mother_birth_place'    => 'required',
            // 'mother_birth_date'     => 'required|date_format:d/m/Y',
            // 'mother_citizen'        => 'required',
            // 'mother_address'        => 'required',
            // 'mother_phone_number'   => 'required|numeric|digits_between:1,25',
            // 'mother_home_number'    => 'numeric|digits_between:1,25',
            // 'mother_last_study'     => 'required',
            // 'mother_occupation'     => 'required',
            // 'mother_revenue'        => 'required|numeric',

            // // Validasi Wali
            // 'guardian_name'         => 'required',
            // 'guardian_birth_place'  => 'required',
            // 'guardian_birth_date'   => 'required|date_format:d/m/Y',
            // 'guardian_citizen'      => 'required',
            // 'guardian_address'      => 'required',
            // 'guardian_phone_number' => 'required|numeric|digits_between:1,25',
            // 'guardian_home_number'  => 'numeric|digits_between:1,25',
            // 'guardian_last_study'   => 'required',
            // 'guardian_occupation'   => 'required',
            // 'guardian_revenue'      => 'required|numeric',
        ]);

        if ($input['child_to'] >= $input['child_count']) return redirect($this->url.'/create')->with('status', 'Anak Dari tidak boleh lebih besar dari Jumlah Saudara.')->withInput();
        if ($input['from_study_date'] > $input['to_study_date']) return redirect($this->url.'/create')->with('status', 'Tanggal Dari tidak boleh lebih besar dari Tanggal Sampai.')->withInput();

        if ($check) {
            $data = [
                'nik'       => $check['nik'],
                'nis'       => $check['nis'],
                'nisn'      => $check['nisn'],
                'disabled'  => 0,
            ];
        } else {
            $data = [
                'nik'       => $input['nik'],
                'nis'       => $input['nis'],
                'nisn'      => $input['nisn'],
            ];
        }

        $data += [
            'full_name'             => $input['full_name'],
            'birth_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'           => $input['birth_place'],
            'gender'                => $input['gender'],
            'religion_id'           => $input['religion'],
            'language_id'           => $input['language'],
            'blood_type_id'         => $input['blood_type'],
            // 'diagnose'     => $input['diagnose'],
            // 'physical_disorder'     => $input['physical_disorder'],
            'height'                => $input['height'],
            'weight'                => $input['weight'],
            // 'picture'     => $input['picture'],
            'family_status_id'      => $input['family_status'],
            'child_to'              => $input['child_to'],
            'child_count'           => $input['child_count'],
            'stepbrother_count'     => $input['stepbrother_count'],
            'stepsibling_count'     => $input['stepsibling_count'],
            'citizen'               => $input['citizen'],
            'address'               => $input['address'],
            'phone_number'          => $input['phone_number'],
            'home_number'           => $input['home_number'],
            'level'                 => $input['level'],
            'group'                 => $input['group'],
            'start_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['start_date']))),
            'extracurricular_id'    => $input['extracurricular'],
            'study_year_id'         => $input['study_year'],
            'sttb_no'               => $input['sttb_no'],
            'first_study'           => $input['first_study'],
            'major'                 => $input['major'],
            'from_study_date'       => date('Y-m-d', strtotime(str_replace('/', '-', $input['from_study_date']))),
            'to_study_date'         => date('Y-m-d', strtotime(str_replace('/', '-', $input['to_study_date']))),
            'move_from'             => $input['move_from'],
            'move_reason'           => $input['move_reason'],
            'created_by'            => 'Developer',
            'created_at'            => now(),
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
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'families'          => $this->families->select('id', 'name')->where('disabled', 0)->get(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'languages'         => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'blood_types'       => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'student'           => $this->students->where('id', $id)->first(),
            'occupations'       => $this->occupations->select('id', 'name')->where('disabled', 0)->get(),
            'extracurriculars'  => $this->extracurriculars->select('id', 'name')->where('disabled', 0)->get(),
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
            'kkm'           => 'required|numeric|digitss_between:1,5',
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
