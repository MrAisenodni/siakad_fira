<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Tag;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/tag';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->tags = new Tag();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'tags'     => $this->tags->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.tag.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.tag.create', $data);
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

        $this->tags->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'tag'      => $this->tags->select('id', 'name')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.tag.edit', $data);
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

        $this->tags->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->tags->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
