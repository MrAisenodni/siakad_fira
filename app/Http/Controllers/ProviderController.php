<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Settings\{
    Menu,
    Provider
};
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->url = '/provider';
        $this->menus = new Menu();
        $this->provider = new Provider();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'provider'      => $this->provider->where('disabled', 0)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.provider', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'company_name'  => 'required',
        ]);

        $data = [
            'company_no'            => $input['company_no'],
            'company_name'          => $input['company_name'],
            'company_birth_date'    => date('Y-m-d', strtotime(str_replace('/', '-', $input['company_birth_date']))),
            'company_address'       => $input['company_address'],
            'company_phone_number'  => $input['company_phone_number'],
            'owner_nip'             => $input['owner_nip'],
            'owner_name'            => $input['owner_name'],
            'owner_birth_place'     => $input['owner_birth_place'],
            'owner_birth_date'      => date('Y-m-d', strtotime(str_replace('/', '-', $input['owner_birth_date']))),
            'owner_address'         => $input['owner_address'],
            'owner_phone_number'    => $input['owner_phone_number'],
            'updated_by'            => session()->get('sname'),
            'updated_at'            => now(),
        ];

        $this->provider->where('id', $input['id'])->update($data);

        return redirect($this->url)->with('status', 'Perubahan berhasil disimpan.');
    }
}
