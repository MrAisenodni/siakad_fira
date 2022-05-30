<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\Occupation;
use App\Models\Settings\Menu;
use App\Models\Studies\ParentModel;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/orang-tua';
        $this->menus = new Menu();
        $this->parents = new ParentModel();
        $this->occupations = new Occupation();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'parents'       => $this->parents->select('id', 'full_name', 'parent', 'gender', 'died', 'student_id')->where('disabled', 0)->get(),
        ];

        return view('studies.parent.index', $data);
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

        return view('studies.parent.create', $data);
    }

    public function edit(Request $request, $id)
    {
        $parent = $this->parents->where('id', $id)->first();
        $status = '';

        if ($parent['gender'] == 'l' && $parent['parent'] == 1) {
            $status = 'Ayah';
        } else if ($parent['gender'] == 'p' && $parent['parent'] == 1) {
            $status = 'Ibu';
        } else {
            $status = 'Wali';
        }

        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'occupations'       => $this->occupations->select('id', 'name')->where('disabled', 0)->get(),
            'parent'            => $this->parents->where('id', $id)->first(),
            'status'            => $status,
        ];
        
        return view('studies.parent.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $died = $request->died;
        $input = $request->all();

        $validated = $request->validate([
            'full_name'     => 'required',
            'birth_place'   => 'required',
            'birth_date'    => 'required|date_format:d/m/Y',
            'citizen'       => 'required',
            'address'       => 'required',
            'phone_number'  => 'required|numeric|digits_between:1,25',
            'home_number'   => 'numeric|digits_between:1,25',
            'last_study'    => 'required',
            'occupation'    => 'required',
            'revenue'       => 'required',
        ]);

        if ($request->status == 'Ayah' && $request->gender != 'l') return redirect($this->url.'/'.$id.'/edit')->with('status', 'Jenis Kelamin Ayah harus laki-laki.')->withInput();
        if ($request->status == 'Ibu' && $request->gender != 'p') return redirect($this->url.'/'.$id.'/edit')->with('status', 'Jenis Kelamin Ibu harus Perempuan.')->withInput();

        $data = [
            'full_name'         => $input['full_name'],
            'birth_date'        => date('Y-m-d', strtotime(str_replace('/', '-', $input['birth_date']))),
            'birth_place'       => $input['birth_place'],
            'gender'            => $input['gender'],
            'citizen'           => $input['citizen'],
            'address'           => $input['address'],
            'phone_number'      => $input['phone_number'],
            'home_number'       => $input['home_number'],
            'last_study'        => $input['last_study'],
            'occupation_id'     => $input['occupation'],
            'revenue'           => str_replace(",", ".", str_replace(".", "", $input['revenue'])),
            'revenue_type'      => $input['revenue_type'],
            'died'              => $died,
            'updated_at'        => now(),
            'updated_by'        => 'Developer',
        ];

        $this->parents->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->parents->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
