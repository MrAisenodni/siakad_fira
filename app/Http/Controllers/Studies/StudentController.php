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
use App\Models\Studies\{
    Student,
    ParentModel,
};
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/siswa';
        $this->menus = new Menu();
        $this->students = new Student();
        $this->parents = new ParentModel();
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
            'blood_types'       => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'extracurriculars'  => $this->extracurriculars->select('id', 'name')->where('disabled', 0)->get(),
            'families'          => $this->families->select('id', 'name')->where('disabled', 0)->get(),
            'languages'         => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'occupations'       => $this->occupations->select('id', 'name')->where('disabled', 0)->get(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('studies.student.create', $data);
    }

    public function store(Request $request)
    {
        $father_died = $request->father_died;
        $mother_died = $request->mother_died;
        $guardian_died = $request->guardian_died;
        $input = $request->all();
        $check = $this->students
                        ->where('nik', $input['nik'])
                        ->where('nis', $input['nis'])
                        ->where('nisn', $input['nisn'])
                        ->where('disabled', 1)
                        ->first();
        // dd($input, $guardian_died, $father_died, $mother_died);

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
            'sttb_no'           => 'required|unique:mst_student,sttb_no,1,disabled',
            'first_study'       => 'required',
            'from_study_date'   => 'required|date_format:d/m/Y',
            'to_study_date'     => 'required|date_format:d/m/Y',

            // Validasi Ayah
            'father_name'           => 'required',
            'father_birth_place'    => 'required',
            'father_birth_date'     => 'required|date_format:d/m/Y',
            'father_citizen'        => 'required',
            'father_address'        => 'required',
            'father_phone_number'   => 'required|numeric|digits_between:1,25',
            'father_home_number'    => 'numeric|digits_between:1,25',
            'father_last_study'     => 'required',
            'father_occupation'     => 'required',
            'father_revenue'        => 'required|numeric',

            // Validasi Ibu
            'mother_name'           => 'required',
            'mother_birth_place'    => 'required',
            'mother_birth_date'     => 'required|date_format:d/m/Y',
            'mother_citizen'        => 'required',
            'mother_address'        => 'required',
            'mother_phone_number'   => 'required|numeric|digits_between:1,25',
            'mother_home_number'    => 'numeric|digits_between:1,25',
            'mother_last_study'     => 'required',
            'mother_occupation'     => 'required',
            'mother_revenue'        => 'required|numeric',
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
            'distance'              => $input['distance'],
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

        $father = [
            'full_name'         => $input['father_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['father_birth_date']))),
            'birth_place'       => $input['father_birth_place'],
            'gender'            => 'l',
            'citizen'           => $input['father_citizen'],
            'address'           => $input['father_address'],
            'phone_number'      => $input['father_phone_number'],
            'home_number'       => $input['father_home_number'],
            'last_study'        => $input['father_last_study'],
            'occupation_id'     => $input['father_occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['father_revenue'])),
            'revenue_type'      => $input['father_revenue_type'],
            'created_at'        => now(),
            'created_by'        => 'Developer',
        ];

        $mother = [
            'full_name'         => $input['mother_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['mother_birth_date']))),
            'birth_place'       => $input['mother_birth_place'],
            'gender'            => 'p',
            'citizen'           => $input['mother_citizen'],
            'address'           => $input['mother_address'],
            'phone_number'      => $input['mother_phone_number'],
            'home_number'       => $input['mother_home_number'],
            'last_study'        => $input['mother_last_study'],
            'occupation_id'     => $input['mother_occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['mother_revenue'])),
            'revenue_type'      => $input['mother_revenue_type'],
            'created_at'        => now(),
            'created_by'        => 'Developer',
        ];

        if ($input['guardian']) 
            $validated = $request->validate([        
                // Validasi Wali
                'guardian_name'           => 'required',
                'guardian_birth_place'    => 'required',
                'guardian_birth_date'     => 'required|date_format:d/m/Y',
                'guardian_citizen'        => 'required',
                'guardian_address'        => 'required',
                'guardian_phone_number'   => 'required|numeric|digits_between:1,25',
                'guardian_home_number'    => 'numeric|digits_between:1,25',
                'guardian_last_study'     => 'required',
                'guardian_occupation'     => 'required',
                'guardian_revenue'        => 'required|numeric',
            ]);
        ($father_died) ? $father['died'] = $father_died : $father['died'] = 0;
        ($mother_died) ? $mother['died'] = $mother_died : $mother['died'] = 0;

        $guardian = [
            'full_name'         => $input['guardian_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['guardian_birth_date']))),
            'birth_place'       => $input['guardian_birth_place'],
            'gender'            => $input['guardian_gender'],
            'citizen'           => $input['guardian_citizen'],
            'address'           => $input['guardian_address'],
            'phone_number'      => $input['guardian_phone_number'],
            'home_number'       => $input['guardian_home_number'],
            'last_study'        => $input['guardian_last_study'],
            'occupation_id'     => $input['guardian_occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['guardian_revenue'])),
            'revenue_type'      => $input['guardian_revenue_type'],
            'parent'            => 0,
            'created_at'        => now(),
            'created_by'        => 'Developer',
        ];
        ($guardian_died) ? $guardian['died'] = $guardian_died : $guardian['died'] = 0;

        if ($check) {
            $this->students->where('id', $check['id'])->update($data);

            $c_father = $this->parents->where('student_id', $check['id'])->where('parent', 1)->where('gender', 'l')->first();
            $c_mother = $this->parents->where('student_id', $check['id'])->where('parent', 1)->where('gender', 'p')->first();
            $c_guardian = $this->parents->where('student_id', $check['id'])->where('parent', 0)->first();

            // update parents
            $this->parents->where('id', $c_father['id'])->update($father);
            $this->parents->where('id', $c_mother['id'])->update($mother);
            if ($c_guardian) { 
                $this->parents->where('id', $c_guardian['id'])->update($guardian);
            } else {
                $guardian['student_id'] = $check['id'];

                $this->parents->insert($guardian);
            };
        } else {
            $id = $this->students->insertGetId($data);

            $father['student_id'] = $id;
            $mother['student_id'] = $id;
            $guardian['student_id'] = $id;

            // insert parents
            $this->parents->insert($father);
            $this->parents->insert($mother);
            $this->parents->insert($guardian);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'blood_types'       => $this->blood_types->select('id', 'name')->where('disabled', 0)->get(),
            'extracurriculars'  => $this->extracurriculars->select('id', 'name')->where('disabled', 0)->get(),
            'families'          => $this->families->select('id', 'name')->where('disabled', 0)->get(),
            'languages'         => $this->languages->select('id', 'name')->where('disabled', 0)->get(),
            'occupations'       => $this->occupations->select('id', 'name')->where('disabled', 0)->get(),
            'religions'         => $this->religions->select('id', 'name')->where('disabled', 0)->get(),
            'studies'           => $this->studies->select('id', 'name')->where('disabled', 0)->get(),
            'student'           => $this->students->where('id', $id)->first(),
            'father'            => $this->parents->where('student_id', $id)->where('gender', 'l')->where('parent', 1)->where('disabled', 0)->first(),
            'mother'            => $this->parents->where('student_id', $id)->where('gender', 'p')->where('parent', 1)->where('disabled', 0)->first(),
            'guardian'          => $this->parents->where('student_id', $id)->where('parent', 0)->where('disabled', 0)->first(),
        ];
        
        return view('studies.student.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $father_died = $request->father_died;
        $mother_died = $request->mother_died;
        $guardian_died = $request->guardian_died;
        $input = $request->all();
        $check = $this->students
                        ->where('nik', $input['nik'])
                        ->where('nis', $input['nis'])
                        ->where('nisn', $input['nisn'])
                        ->where('disabled', 1)
                        ->first();
        // dd($input, $guardian_died, $father_died, $mother_died);

        $validated = $request->validate([
            'nik'           => 'required|numeric|unique:mst_student,nik,'.$id.',id,disabled,0|digits_between:1,16',
            'nis'           => 'required|numeric|unique:mst_student,nis,'.$id.',id,disabled,0|digits_between:1,20',
            'nisn'          => 'required|numeric|unique:mst_student,nisn,'.$id.',id,disabled,0|digits_between:1,20',
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
            'sttb_no'           => 'required|unique:mst_student,sttb_no,'.$id.',id,disabled,0',
            'first_study'       => 'required',
            'from_study_date'   => 'required|date_format:d/m/Y',
            'to_study_date'     => 'required|date_format:d/m/Y',

            // Validasi Ayah
            'father_name'           => 'required',
            'father_birth_place'    => 'required',
            'father_birth_date'     => 'required|date_format:d/m/Y',
            'father_citizen'        => 'required',
            'father_address'        => 'required',
            'father_phone_number'   => 'required|numeric|digits_between:1,25',
            'father_home_number'    => 'numeric|digits_between:1,25',
            'father_last_study'     => 'required',
            'father_occupation'     => 'required',
            'father_revenue'        => 'required',

            // Validasi Ibu
            'mother_name'           => 'required',
            'mother_birth_place'    => 'required',
            'mother_birth_date'     => 'required|date_format:d/m/Y',
            'mother_citizen'        => 'required',
            'mother_address'        => 'required',
            'mother_phone_number'   => 'required|numeric|digits_between:1,25',
            'mother_home_number'    => 'numeric|digits_between:1,25',
            'mother_last_study'     => 'required',
            'mother_occupation'     => 'required',
            'mother_revenue'        => 'required',
        ]);

        if ($input['child_to'] >= $input['child_count']) return redirect($this->url.'/'.$id.'/edit')->with('status', 'Anak Dari tidak boleh lebih besar dari Jumlah Saudara.')->withInput();
        if ($input['from_study_date'] > $input['to_study_date']) return redirect($this->url.'/'.$id.'/edit')->with('status', 'Tanggal Dari tidak boleh lebih besar dari Tanggal Sampai.')->withInput();

        $data = [
            'nik'                   => $input['nik'],
            'nis'                   => $input['nis'],
            'nisn'                  => $input['nisn'],
            'full_name'             => $input['full_name'],
            'birth_date'            => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'           => $input['birth_place'],
            'gender'                => $input['gender'],
            'distance'              => $input['distance'],
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
            'updated_by'            => 'Developer',
            'updated_at'            => now(),
        ];

        $father = [
            'full_name'         => $input['father_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['father_birth_date']))),
            'birth_place'       => $input['father_birth_place'],
            'gender'            => 'l',
            'citizen'           => $input['father_citizen'],
            'address'           => $input['father_address'],
            'phone_number'      => $input['father_phone_number'],
            'home_number'       => $input['father_home_number'],
            'last_study'        => $input['father_last_study'],
            'occupation_id'     => $input['father_occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['father_revenue'])),
            'revenue_type'      => $input['father_revenue_type'],
            'updated_at'        => now(),
            'updated_by'        => 'Developer',
        ];

        $mother = [
            'full_name'         => $input['mother_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['mother_birth_date']))),
            'birth_place'       => $input['mother_birth_place'],
            'gender'            => 'p',
            'citizen'           => $input['mother_citizen'],
            'address'           => $input['mother_address'],
            'phone_number'      => $input['mother_phone_number'],
            'home_number'       => $input['mother_home_number'],
            'last_study'        => $input['mother_last_study'],
            'occupation_id'     => $input['mother_occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['mother_revenue'])),
            'revenue_type'      => $input['mother_revenue_type'],
            'updated_at'        => now(),
            'updated_by'        => 'Developer',
        ];

        if ($input['guardian']) 
            $validated = $request->validate([        
                // Validasi Wali
                'guardian_name'           => 'required',
                'guardian_birth_place'    => 'required',
                'guardian_birth_date'     => 'required|date_format:d/m/Y',
                'guardian_citizen'        => 'required',
                'guardian_address'        => 'required',
                'guardian_phone_number'   => 'required|numeric|digits_between:1,25',
                'guardian_home_number'    => 'numeric|digits_between:1,25',
                'guardian_last_study'     => 'required',
                'guardian_occupation'     => 'required',
                'guardian_revenue'        => 'required',
            ]);
        ($father_died) ? $father['died'] = $father_died : $father['died'] = 0;
        ($mother_died) ? $mother['died'] = $mother_died : $mother['died'] = 0;

        $guardian = [
            'full_name'         => $input['guardian_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['guardian_birth_date']))),
            'birth_place'       => $input['guardian_birth_place'],
            'gender'            => $input['guardian_gender'],
            'citizen'           => $input['guardian_citizen'],
            'address'           => $input['guardian_address'],
            'phone_number'      => $input['guardian_phone_number'],
            'home_number'       => $input['guardian_home_number'],
            'last_study'        => $input['guardian_last_study'],
            'occupation_id'     => $input['guardian_occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['guardian_revenue'])),
            'revenue_type'      => $input['guardian_revenue_type'],
            'parent'            => 0,
        ];
        ($guardian_died) ? $guardian['died'] = $guardian_died : $guardian['died'] = 0;
        // dd($guardian, $mother);

        if ($check) $this->students->where('id', $check['id'])->delete();

        $this->students->where('id', $id)->update($data);

        $c_father = $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'l')->first();
        $c_mother = $this->parents->where('student_id', $id)->where('parent', 1)->where('gender', 'p')->first();
        $c_guardian = $this->parents->where('student_id', $id)->where('parent', 0)->first();

        // update parents
        $this->parents->where('id', $c_father['id'])->update($father);
        $this->parents->where('id', $c_mother['id'])->update($mother);
        if($c_guardian) { 
            $guardian += [
                'updated_at'        => now(),
                'updated_by'        => 'Developer',
            ];

            $this->parents->where('id', $c_guardian['id'])->update($guardian);
        } else {
            $guardian += [
                'student_id'        => $id,
                'created_at'        => now(),
                'created_by'        => 'Developer',
            ];

            $this->parents->insert($guardian);
        }

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
