<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\Payment as MstPayment;
use App\Models\Settings\Menu;
use App\Models\Studies\{
    Student,
    Payment,
};
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->url = '/studi/spp';
        $this->menus = new Menu();
        $this->mst_payments = new MstPayment();
        $this->students = new Student();
        $this->payments = new Payment();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'payments'      => $this->payments->select('id', 'student_id', 'status')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.payment.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'payments'      => $this->mst_payments->select('id', 'year', 'amount')->where('disabled', 0)->get(),
            'students'      => $this->students->select('id', 'full_name', 'nis')->where('disabled', 0)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.payment.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'student'       => 'required',
            'payment'       => 'required',
            'month'         => 'required',
            'amount'        => 'required',
        ]);

        $data = [
            'year'          => $input['year'],
            'month'         => (string) $input['month'],
            'student_id'    => $input['student'],
            'payment_id'    => $input['payment'],
            'amount'        => str_replace(',', '.',str_replace('.', '', trim($input['amount'], 'Rp'))),
            'status'        => 'lunas',
            'created_by'    => session()->get('sname'),
            'created_at'    => now(),
        ];

        $this->payments->insert($data);

        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $payment = $this->payments->select('student_id')->where('id', $id)->first();
        
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'payments'      => $this->mst_payments->select('id', 'year', 'amount')->where('disabled', 0)->get(),
            'students'      => $this->students->select('id', 'full_name', 'nis')->where('disabled', 0)->get(),
            'paystuds'      => $this->payments->select('id', 'year', 'amount', 'month', 'student_id', 'payment_id')->where('student_id', $payment->student_id)->where('disabled', 0)->get(),
            'payment'       => $this->payments->select('id', 'student_id', 'payment_id')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.payment.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validated = $request->validate([
            'student'       => 'required',
            'payment'       => 'required',
            'month'         => 'required',
            'amount'        => 'required',
        ]);

        $data = [
            'year'          => $input['year'],
            'month'         => $input['month'],
            'student_id'    => $input['student'],
            'payment_id'    => $input['payment'],
            'amount'        => str_replace(',', '.',str_replace('.', '', trim($input['amount'], 'Rp'))),
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

    public function test(Request $request)
    {
        $phone = $request->phone_number;

        $this->whatsappNotification($phone);

        return redirect($this->url)->with('status', 'Notifikasi Terkirim.');
    }

    private function whatsappNotification(string $recipient)
    {
        $sid = getenv("TWILIO_AUTH_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $wa_from = getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token);

        $body = "Sisa tagihanmu tinggal Rp 150.000";

        return $twilio->messages->create("whatsapp:$recipient", [
            "from"      => "whatsapp:$wa_from",
            "body"      => $body,
        ]);
    }
}
