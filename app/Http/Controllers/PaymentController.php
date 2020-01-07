<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $subscription_id = $request->session()->get('subscription_id');
        $items = [];
        $total = 0;

        if ($subscription_id) {
            $subscription = Subscription::findOrFail($subscription_id);

            $total += $subscription->price;

            $items[] = [
                'name' => $subscription->name,
                'price' => $subscription->price,
                'cnt' => 1,
                'total' => $subscription->price,
            ];
        }

        return view('buy', compact('items', 'total'));
    }

    public function checkout(Request $request) {
        $subscription_id = $request->session()->get('subscription_id');
        $total = 0;
        if ($subscription_id) {
            $subscription = Subscription::findOrFail($subscription_id);
            $total += $subscription->price;
        }


        $data = [
            'CardCryptogramPacket' => $request->code,
            'Amount' => $total,
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

        $request->session()->forget('subscription_id');
    }
}
