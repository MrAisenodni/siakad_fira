<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\FamilyStatus;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class FamilyStatusController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/status-keluarga';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->families = new FamilyStatus();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'families'      => $this->families->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('masters.family_status.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        return view('masters.family_status.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required',
        ]);

        $data = [
            'name'          => $input['name'],
            'created_by'    => 'Developer',
            'created_at'    => now(),
        ];

        $this->families->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'family'        => $this->families->select('id', 'name')->where('id', $id)->first(),
        ];

        return view('masters.family_status.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required',
        ]);

        $data = [
            'name'          => $input['name'],
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->families->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->families->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
