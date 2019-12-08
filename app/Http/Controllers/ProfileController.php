<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Date\Date;

class ProfileController extends Controller
{


    public function profile(Request $request)
    {
        $user = $request->user();

        $date_activation = Date::parse($user->subscriptions->first()->pivot->created_at)->format('d F Y');
        $date_finish = Date::parse($user->subscriptions->first()->expires)->format('d F Y');
        $dates = array($date_activation, $date_finish);

        return view('profile', ['user' => $user, 'dates' => $dates]);
    }

    public function imageUpload(Request $request)
    {
        dd($request);
    }
}
