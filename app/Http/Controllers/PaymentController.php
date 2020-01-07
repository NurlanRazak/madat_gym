<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function checkout(Request $request) {
        $data = [
            'CardCryptogramPacket' => $request->code,
            'Amount' => '10',
            'Currency' => 'KZT',
            'IpAddress' => config('services.payment.ip_address'),
            'Name' => $request->name,
        ];
        $data_string = json_encode($data);

        $ch = curl_init('https://api.cloudpayments.ru/payments/cards/charge');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_USERPWD, config('services.payment.public_id').":".config('services.payment.api_key'));

        $result = curl_exec($ch);
        return $result;
    }
}
