<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Studies\Lesson as StdLesson;
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
        $this->std_lessons = new StdLesson();
        $this->lessons = new Lesson();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'       => $this->lessons->select('id', 'code', 'name', 'kkm')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.lesson.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.lesson.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $check = $this->lessons->select('id', 'disabled', 'code')->where('code', $input['code'])->first();

        $validated = $request->validate([
            'code'          => 'unique:mst_lesson,code,1,disabled',
            'name'          => 'required',
            'kkm'           => 'required|numeric',
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
            'created_by'    => session()->get('sname'),
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

        if (session()->get('srole') == 'admin') return view('masters.lesson.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'code'          => 'unique:mst_lesson,code,'.$id.',id,disabled,0',
            'name'          => 'required',
            'kkm'           => 'required|numeric',
        ]);

        $data = [
            'code'          => $input['code'],
            'name'          => $input['name'],
            'kkm'           => $input['kkm'],
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $lesson = $this->std_lessons->where('disabled', 0)->where('lesson_id', $id)->first();

        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        if ($lesson) return redirect(url()->previous())->with('errdel', 'Data gagal dihapus karena Mata Pelajaran masih aktif di Menu')->with('errurl', 'mata-pelajaran')->with('errtitle', 'Mata Pelajaran');

        $this->lessons->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
