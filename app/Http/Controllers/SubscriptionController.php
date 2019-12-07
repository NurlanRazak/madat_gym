<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

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
        return redirect(route('programs'));
    }

}
