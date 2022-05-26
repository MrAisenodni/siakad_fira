<?php

namespace App\Http\Controllers;

use App\Models\Settings\Menu;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->menus = new Menu();
    }

    public function dashboard()
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id')->where('disabled', 0)->get(),
            'menu'          => $this->menus->select('title')->where('url', '/')->first(),
        ];

        return view('index', $data);
    }
}
