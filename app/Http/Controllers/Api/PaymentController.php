<?php

namespace App\Http\Controllers\Api;

use App\Models\Masters\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function __construct() {
        $this->payments     = new Payment();
        $this->title        = 'Pembayaran SPP';
    }

    public function show($id)
    {
        $response   = [
            'message'   => 'Detail '.$this->title,
            'data'      => [
                'payment'   => $this->payments->select('id', 'year', 'amount')->where('id', $id)->first(),
            ],
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
