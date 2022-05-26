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
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'lessons'       => $this->lessons->select('id', 'name')->where('disabled', 0)->get(),
        ];

        return view('masters.lesson.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        return view('masters.lesson.create', $data);
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

        $this->lessons->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'lesson'    => $this->lessons->select('id', 'name')->where('id', $id)->first(),
        ];

        return view('masters.lesson.edit', $data);
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

        return redirect($this->url)->with('status', 'Data berhasil dihapus');
    }
}
