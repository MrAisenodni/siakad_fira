<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Lesson;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/mata-pelajaran';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->lessons = new Lesson();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'       => $this->lessons->select('id', 'code', 'name', 'kkm')->where('disabled', 0)->get(),
        ];

        return view('masters.lesson.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        return view('masters.lesson.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = $this->lessons->select('id', 'disabled', 'code')->where('code', $input['code'])->first();

        $validated = $request->validate([
            'code'          => 'required|unique:mst_lesson,code,1,disabled',
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
            $this->lessons->where('id', $check['id'])->update($data);
        } else {
            $this->lessons->insert($data);
        }

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'lesson'        => $this->lessons->select('id', 'code', 'name', 'kkm')->where('id', $id)->first(),
        ];

        return view('masters.lesson.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $check = $this->lessons->select('id', 'disabled', 'code')->where('code', $input['code'])->first();

        $validated = $request->validate([
            'code'          => 'required|unique:mst_lesson,code,'.$id.',id,disabled,0',
            'name'          => 'required',
            'kkm'           => 'required|numeric|digits_between:1,5',
        ]);

        if ($check) $this->lessons->where('disabled', $check['disabled'])->where('id', $check['id'])->delete();

        $data = [
            'code'          => $input['code'],
            'name'          => $input['name'],
            'kkm'           => $input['kkm'],
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => 'Developer',
            'updated_at'    => now(),
        ];

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
