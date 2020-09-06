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

        $user = $request->user();

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

        $description = $programtraining->name ?? 'test';

        $url = 'https://api.paybox.money/payment.php';

        $data = [
           'extra_user_id' => $user->id,
           'pg_merchant_id' => config('epay.merchant_id'),//our id in Paybox, will be gived on contract
           'pg_amount' => $total, //amount of payment
           'pg_salt' => 'some string', //random string, required
           'pg_order_id' => $purchase->id, //id of purchase, strictly unique
           'pg_description' => $description, //will be shown to client in process of payment, required
           'pg_result_url' => route('payment-result'),//route('payment-result')
           'pg_user_phone' => $user->phone_number ?? '',
           'pg_user_contact_email' => $user->email ?? '',
           'pg_testing_mode' => 1,
           'pg_success_url' => route('home'),
        ];

        ksort($data);
        array_unshift($data, 'payment.php');
        array_push($data, config('epay.secret'));

        $data['pg_sig'] = md5(implode(';', $data));

        unset($data[0], $data[1]);

        $query = http_build_query($data);
        $arr = [$url, $query];
        header('Location:https://api.paybox.money/payment.php?'.$query);



        return view('buy', compact('items', 'total'));
    }

    public function successCheckout(Request $request)
    {
        $purchase_id = $request->pg_order_id;
        $purchase = Purchase::findOrFail($purchase_id);

        if ($request->pg_result) {
            return $this->successPurchase($purchase);
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
            $user->addUserProgram($programtraining);
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
