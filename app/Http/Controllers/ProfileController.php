<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userparameter;
use Jenssegers\Date\Date;
use App\User;
use App\Models\Programtraining;
use Hash;
use Auth;

class ProfileController extends Controller
{


    public function profile(Request $request)
    {
        $user = $request->user();

        $date_activation = Date::parse($user->subscriptions->first()->pivot->created_at)->format('d F Y');
        $date_finish = Date::parse($user->subscriptions->first()->expires)->format('d F Y');
        $dates = array($date_activation, $date_finish);

        $userparameters = Userparameter::where('user_id', $user->id)->get();

        $programs = Programtraining::whereHas('activeprograms', function($query) {
            $query->where('date_start', '<=', \DB::raw('NOW()'))
                  ->where('date_finish', '>=', \DB::raw('NOW()'));
        })->get();

        return view('profile', ['user' => $user, 'dates' => $dates, 'userparameters' => $userparameters, 'programs' => $programs]);
    }

    public function imageUpload(Request $request)
    {
        $user = $request->user();
        $user->image = $request->image;
        $user->save();
        return redirect()->back();
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

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $password = bcrypt($request->password);
        $user->password = $password;
        $user->save();
        return redirect()->back();
    }

    public function userParameterDelete(Request $request, $id)
    {
        Userparameter::find($id)->delete();

        return redirect()->back();
    }

    public function uploadImage(Request $request)
    {
        $userparameter = Userparameter::find($request->userparameter_id);
        $userparameter->images = $request->images;
        $userparameter->save();
        return redirect()->back();
    }

    public function updateProgram(Request $request)
    {
        $user = $request->user();
        $user->update([
            'programtraining_id' => $request->programtraining_id,
            'programtraining_start' => \DB::raw('NOW()'),
        ]);

        return redirect()->back();
    }

    public function userUpdate(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        $data= $request->toArray();
        unset($data['_token']);
        unset($data['password']);

        $user->update($data);
        return response()->json([
            'message' => 'ok'
        ]);
    }
}
