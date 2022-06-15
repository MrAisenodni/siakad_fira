<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    Category,
    Tag,
};
use App\Models\Settings\Menu;
use App\Models\Studies\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/pengumuman';
        $this->menus = new Menu();
        $this->articles = new Article();
        $this->categories = new Category();
        $this->tags = new Tag();
    }

    public function index()
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'articles'      => $this->articles->select('id', 'title', 'category_id', 'status')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.article.index', $data);
        if (session()->get('srole') == 'teacher') return view('teachers.article.index', $data);
        return view('students.article.index', $data);
    }

    public function create()
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'categories'    => $this->categories->select('id', 'name')->where('disabled', 0)->get(),
            'tags'          => $this->tags->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.article.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'title'         => 'required',
            'category'      => 'required',
            'description'   => 'required',
            'photo'         => 'required|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:10000',
            'author'        => 'required',
        ]);

        $photo_path = $request->photo->storeAs('pengumuman', strtotime(now()).'_'.$request->title.'_'.$request->author.'.png', 'public');

        $data = [
            'title'         => $input['title'],
            'category_id'   => $input['category'],
            'tag_id'        => $input['tag'],
            'description'   => $input['description'],
            'photo'         => $photo_path,
            'status'        => $input['status'],
            'author'        => $input['author'],
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->articles->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'article'       => $this->articles->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.article.show', $data);
        if (session()->get('srole') == 'teacher') return view('teachers.article.show', $data);
        return view('students.article.show', $data);
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'article'       => $this->articles->where('id', $id)->first(),
            'categories'    => $this->categories->select('id', 'name')->where('disabled', 0)->get(),
            'tags'          => $this->tags->select('id', 'name')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.article.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $photo_path = $request->old_photo;

        $validated = $request->validate([
            'title'         => 'required',
            'category'      => 'required',
            'description'   => 'required',
            'photo'         => 'mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:10000',
            'author'        => 'required',
        ]);

        if ($request->photo) {
            if ($request->old_photo) File::delete(public_path().'/storage/'.$request->old_photo);
            $photo_path = $request->photo->storeAs('pengumuman', strtotime(now()).'_'.$request->title.'_'.$request->author.'.png', 'public');
        }

        $data = [
            'title'         => $input['title'],
            'category_id'   => $input['category'],
            'tag_id'        => $input['tag'],
            'description'   => $input['description'],
            'photo'         => $photo_path,
            'status'        => $input['status'],
            'author'        => $input['author'],
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->articles->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy(Request $request, $id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];
        
        if ($request->photo) File::delete(public_path().'/storage/'.$request->photo);

        $this->articles->where('id', $id)->update($data);
        
        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }

    public function download(Request $request)
    {
        return response()->file(public_path().'/pengumuman/'.$request->file);
    }
}
