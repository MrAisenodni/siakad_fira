<?php

namespace App\Http\Controllers\Studies;

use App\Http\Controllers\Controller;
use App\Models\Masters\{
    Month,
    Payment as MstPayment,
};
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
        $this->months = new Month();
        $this->mst_payments = new MstPayment();
        $this->students = new Student();
        $this->payments = new Payment();
    }
    
    public function index(Request $request)
    {
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'payments'      => $this->payments->selectRaw('MAX(id) AS id, student_id, status')->where('disabled', 0)->groupByRaw('student_id, status')->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.payment.index', $data);
        abort(403);
    }

    public function create(Request $request)
    {
        $student = $this->payments->select('student_id')->where('disabled', 0)->get();

        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'months'        => $this->months->select('id', 'name')->where('disabled', 0)->get(),
            'payments'      => $this->mst_payments->select('id', 'year', 'amount')->where('disabled', 0)->get(),
            'students'      => $this->students->select('id', 'full_name', 'nis')->where('disabled', 0)->whereNotIn('id', $student)->get(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.payment.create', $data);
        abort(403);
    }

    public function store(Request $request)
    {
        $modal = $request->mod_student;
        $input = $request->all();

        if ($modal) {
            $check = $this->payments->where('disabled', 0)->where('student_id', $input['mod_student'])->where('month', $input['mod_month'])->where('payment_id', $input['mod_payment'])->first();

            $validated = $request->validate([
                'mod_student'   => 'required',
                'mod_payment'   => 'required',
                'mod_month'     => 'required',
                'mod_amount'    => 'required',
            ]);

            $data = [
                'year'          => $input['mod_year'],
                'month'         => (string) $input['mod_month'],
                'student_id'    => $input['mod_student'],
                'payment_id'    => $input['mod_payment'],
                'amount'        => str_replace(',', '.',str_replace('.', '', trim($input['mod_amount'], 'Rp'))),
                'status'        => 'lunas',
                'created_by'    => session()->get('sname'),
                'created_at'    => now(),
            ];
        } else {
            $check = $this->payments->where('disabled', 0)->where('student_id', $input['student'])->where('month', $input['month'])->where('payment_id', $input['payment'])->first();

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
        }

        if ($check) return redirect(url()->previous())->with('error', 'Data sudah terdaftar.');

        $this->payments->insert($data);

        if ($modal) return redirect(url()->previous())->with('status', 'Data berhasil ditambahkan.');
        return redirect($this->url)->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $payment = $this->payments->select('student_id')->where('id', $id)->first();
        
        $data = [
            'menus'         => $this->menus->select('title', 'url', 'icon', 'parent', 'id', 'role')->where('disabled', 0)->where('role', 'like', '%'.session()->get('srole').'%')->get(),
            'menu'          => $this->menus->select('title', 'url')->where('url', $this->url)->first(),
            'months'        => $this->months->select('id', 'name')->where('disabled', 0)->get(),
            'payments'      => $this->mst_payments->select('id', 'year', 'amount')->where('disabled', 0)->get(),
            'students'      => $this->students->select('id', 'full_name', 'nis')->where('disabled', 0)->get(),
            'paystuds'      => $this->payments->select('id', 'year', 'amount', 'month', 'student_id', 'payment_id', 'status')->where('student_id', $payment->student_id)->where('disabled', 0)->orderByRaw('year, month')->get(),
            'payment'       => $this->payments->select('id', 'student_id', 'payment_id', 'month')->where('id', $id)->first(),
        ];

        if (session()->get('srole') == 'admin') return view('studies.payment.edit', $data);
        abort(403);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $check = $this->payments->where('disabled', 0)->where('student_id', $input['student'])->where('month', $input['month'])->where('payment_id', $input['payment'])->first();

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

        if ($check) return redirect(url()->previous())->with('error', 'Data sudah terdaftar.')->withInput();

        $this->payments->where('id', $id)->update($data);

        return redirect(url()->previous())->with('status', 'Data berhasil diubah.');
    }

    public function destroy(Request $request, $id)
    {
        $student = $this->payments->select('id')->where('student_id', $request->student)->where('id', '!=', $id)->where('disabled', 0)->first();
        $uid = '';
        
        if ($student) $uid = $student->id;

        $data = [
            'disabled'      => 1,
            'updated_by'    => session()->get('sname'),
            'updated_at'    => now(),
        ];

        $this->payments->where('id', $id)->update($data);

        if ($uid) return redirect($this->url.'/'.$uid.'/edit')->with('status', 'Data berhasil dihapus.');
        if ($student) return redirect(url()->previous())->with('status', 'Data berhasil dihapus.');
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
