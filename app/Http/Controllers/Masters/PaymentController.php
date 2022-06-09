<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Payment;
use App\Models\Settings\{
    Menu,
    SubMenu,
};
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->url = '/master/spp';
        $this->menus = new Menu();
        $this->sub_menus = new SubMenu();
        $this->payments = new Payment();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'payments'      => $this->payments->select('id', 'year', 'amount')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.payment.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.payment.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'year'           => 'required|numeric|digits:4|unique:mst_payment,year,1,disabled',
            'amount'          => 'required',
        ]);

        $data = [
            'year'          => $input['year'],
            'amount'         => str_replace(',', '.',str_replace('.', '', trim($input['amount'], 'Rp'))),
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->payments->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->sub_menus->select('title', 'url')->where('url', $this->url)->first(),
            'payment'       => $this->payments->select('id', 'year', 'amount')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('masters.payment.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'year'           => 'required|numeric|digits:4|unique:mst_payment,year,'.$id.',id,disabled,0',
            'amount'          => 'required',
        ]);

        $data = [
            'year'          => $input['year'],
            'amount'         => str_replace(',', '.',str_replace('.', '', trim($input['amount'], 'Rp'))),
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->payments->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->payments->where('id', $id)->update($data);

        return redirect($this->url)->with('status', 'Data berhasil dihapus.');
    }
}
