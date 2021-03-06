<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Extracurricular;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/ekstrakurikuler';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->extracurriculars = new Extracurricular();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'              => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'extracurriculars'  => $this->extracurriculars->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.extracurricular.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.extracurricular.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required',
        ]);

        $data = [
            'name'          => $input['name'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->extracurriculars->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'             => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'              => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'extracurricular'   => $this->extracurriculars->select('id', 'name')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.extracurricular.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required',
        ]);

        $data = [
            'name'          => $input['name'],
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->extracurriculars->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->extracurriculars->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
