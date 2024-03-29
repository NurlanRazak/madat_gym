<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Pivots\SubscriptionUser;
use App\Notifications\PaymentNotify;

class SubscriptionController extends Controller
{

    public function subscription(Request $request)
    {
        $user = $request->user();
        $subscriptions = Subscription::all();
        return view('subscription', ['subscriptions' => $subscriptions]);
    }

    public function postSubscription(Request $request)
    {
        $user = $request->user();
        $subscription = Subscription::findOrFail($request->subscription_id);
        if ($subscription->price == 0) {
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

            return redirect()->to('/');
        }

        $request->session()->put('subscription_id', $subscription->id);

        // if ($user->programtraining) {
        //     $cnt = $user->programtraining->activeprograms()
        //     ->where('date_start', '<=', \DB::raw('NOW()'))
        //     ->where('date_finish', '>=', \DB::raw('NOW()'))
        //     ->count();
        //
        //     if($cnt > 0) {
        //         return redirect(route('profile'));
        //     }
        // }
        return redirect()->to('/buy');
    }

}
