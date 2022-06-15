<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Category;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/kategori';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->categories = new Category();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'categories'     => $this->categories->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.category.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.category.create', $data);
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

        $this->categories->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'category'      => $this->categories->select('id', 'name')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.category.edit', $data);
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

        $this->categories->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->categories->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
