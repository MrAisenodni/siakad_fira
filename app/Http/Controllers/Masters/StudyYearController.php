<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\StudyYear;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class StudyYearController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/tahun-pelajaran';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->studies = new StudyYear();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'studies'       => $this->studies->select('id', 'name', 'semester')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.study_year.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.study_year.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required',
            'semester'      => 'required',
        ]);

        $data = [
            'name'          => $input['name'],
            'semester'      => $input['semester'],
            'created_by'    => 'Developer',
            'created_at'    => now(),
        ];

        $this->studies->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'study'         => $this->studies->select('id', 'name', 'semester')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.study_year.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required',
            'semester'      => 'required',
        ]);

        $data = [
            'name'          => $input['name'],
            'semester'      => $input['semester'],
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->studies->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->studies->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
