<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userparameter;
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

    public function userParameters(Request $request)
    {
        $user = $request->user();
        $userparameter = Userparameter::insert([
        ['user_id' => $user->id,
            'date_measure' => $request['date_measure'],
            'weight' => floatval($request['weight']),
            'waist' => floatval($request['waist']),
            'leg_volume' => floatval($request['leg_volume']),
            'arm_volume' => floatval($request['arm_volume']),
        ],
        ]);

    }
}
