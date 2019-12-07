<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Pivots\SubscriptionUser;

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

        $lastSubscription = $user->subscriptions()
                                 ->whereRaw("DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY) >= CURDATE()")
                                 ->latest()
                                 ->first();

        $nextDate = \DB::raw('NOW()');
        if($lastSubscription) {
            $nextDate = \DB::raw("DATE_ADD(\"{$lastSubscription->pivot->created_at}\", INTERVAL {$lastSubscription->days} DAY)");
        }

        $subscriptionUser = SubscriptionUser::create([
            'subscription_id' => $request->subscription_id,
            'user_id' => $user->id,
            'created_at' => $nextDate,
        ]);

        return redirect(route('programs'));
    }

}
