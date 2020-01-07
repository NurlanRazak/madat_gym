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
            'IpAddress' => '185.98.7.185',
            'Name' => 'qwe',
        ];
        $data_string = json_encode($data);

        $ch = curl_init('https://api.cloudpayments.ru/payments/cards/charge');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_USERPWD, "pk_95513bc124ddb9539e435ccde251c:68cdb270b9629d8707694c12b022a390");

        $result = curl_exec($ch);
        return $result;
    }
}
