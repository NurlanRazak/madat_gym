<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Models\Programtraining;
use App\Models\Purchase;
use App\Models\Pivots\SubscriptionUser;
use App\Notifications\PaymentNotify;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $subscription_id = $request->session()->get('subscription_id');
        $programtraining_id = $request->session()->get('programtraining_id');
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
        if ($programtraining_id) {
            $programtraining = Programtraining::findOrFail($programtraining_id);
            $total += (int)$programtraining->price;

            $items[] = [
                'name' => $programtraining->name,
                'price' => $programtraining->price,
                'cnt' => 1,
                'total' => $programtraining->price,
            ];
        }

        return view('buy', compact('items', 'total'));
    }

    public function checkout(Request $request) {
        $programtraining_id = $request->session()->get('programtraining_id');
        $subscription_id = $request->session()->get('subscription_id');
        $user = $request->user();

        $total = 0;
        if ($subscription_id) {
            $subscription = Subscription::findOrFail($subscription_id);
            $total += $subscription->price;
        }
        if ($programtraining_id) {
            $programtraining = Programtraining::findOrFail($programtraining_id);
            $total += (int)$programtraining->price;
        }
        $purchase = '';
        if($programtraining_id) {
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'status' => Purchase::NOTPAID,
                'programtraining_id' => $programtraining->id,
                'currency' => $programtraining->getCurrencyKey(),
            ]);
        } else {
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'status' => Purchase::NOTPAID,
                'subscription_id' => $subscription->id,
                'currency' => $subscription->getCurrencyKey(),
            ]);
        }

        $data = [
            'CardCryptogramPacket' => $request->code,
            'Amount' => $total,
            'Currency' => $purchase->currency ?? 'USD',
            'IpAddress' => config('services.payment.ip_address'),
            'Name' => $request->name,
            'Email' => $user->email,
            'AccountId' => $user->id,
            'InvoiceId' => $purchase->id,
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
        $result = json_decode($result);

        if ($result->Success) {
            $request->session()->forget('subscription_id');
            $request->session()->forget('programtraining_id');
	    return $this->successPurchase($purchase);
        }

        if ($result->Model && isset($result->Model->AcsUrl) && isset($result->Model->PaReq)) {
            $request->session()->forget('subscription_id');
            $request->session()->forget('programtraining_id');
            return view('success_payment', compact('result', 'purchase'));
        }

        if ($result->Model && isset($result->Model->CardHolderMessage)) {
            // Back with message
            return redirect()->back()->with(['message' => $result->Model->CardHolderMessage, 'type' => 'error']);
        }
        return redirect()->back()->with(['message' => 'Упс... Что то пошло не так :(', 'type' => 'error']);
    }

    public function successCheckout(Request $request)
    {
        if(!$request->MD || !$request->PaRes) {
            return redirect()->to('/')->with(['message' => 'Упс... Что то пошло не так :(', 'type' => 'error']);
        }
        $purchase_id = $request->purchase_id;
        $purchase = Purchase::findOrFail($purchase_id);

        $data = [
            'TransactionId' => $request->MD,
            'PaRes' => $request->PaRes,
        ];
        $data_string = json_encode($data);

        $ch = curl_init('https://api.cloudpayments.ru/payments/cards/post3ds');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_USERPWD, config('services.payment.public_id').":".config('services.payment.api_key'));

        $result = curl_exec($ch);
        $result = json_decode($result);

        if ($result->Success) {
            return $this->successPurchase($purchase);
        }

        if ($result->Model && isset($result->Model->CardHolderMessage)) {
            // Back with message
            return redirect()->back()->with(['message' => $result->Model->CardHolderMessage, 'type' => 'error']);
        }

        return redirect()->to('/')->with(['message' => 'Упс... Что то пошло не так :(', 'type' => 'error']);
    }

    private function successPurchase(Purchase $purchase)
    {
        if ($purchase->status == Purchase::PAID) {
            abort(400, "Вы оплатили за абонемент");
        }
        $purchase->status = Purchase::PAID;
        $purchase->save();

        $user = request()->user();
        $subscription = $purchase->subscription;
        $programtraining = $purchase->programtraing;
        if ($programtraining) {
            $user->update([
                'programtraining_id' => $programtraining->id,
                'programtraining_start' => \DB::raw('NOW()'),
            ]);
            // $user->doneExersices()->delete();
            return redirect(route('home'));
        }


        $lastSubscription = $user->subscriptions()
                                 ->whereRaw("DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY) >= NOW()")
                                 ->orderBy('pivot_created_at', 'desc')
                                 ->first();

        $nextDate = \DB::raw('NOW()');
        if($lastSubscription) {
            $nextDate = \DB::raw("DATE_ADD(\"{$lastSubscription->pivot->created_at}\", INTERVAL {$lastSubscription->days} DAY)");
        }

        $subscriptionUser = SubscriptionUser::create([
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'created_at' => $nextDate,
        ]);
        $new_subscription = SubscriptionUser::find($subscriptionUser->id);
        // TODO: Send email
        $date_start = \Carbon\Carbon::parse($new_subscription->created_at);
        $date_finish = \Carbon\Carbon::parse($new_subscription->created_at)->addDays($new_subscription->subscription->days);

        $message = [$subscription->name, $date_start, $date_finish];
        $user->notify(new PaymentNotify($message));

        return redirect()->to('/')->with(['message' => 'Оплата прошла успешно!', 'type' => 'success']);
    }

}
