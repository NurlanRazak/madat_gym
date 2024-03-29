<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userparameter;
use Jenssegers\Date\Date;
use App\User;
use App\Models\Programtraining;
use App\Models\ProgramHistory;
use Hash;
use Auth;

class ProfileController extends Controller
{


    public function profile(Request $request)
    {
        $user = $request->user();

        $first_subscr = $user->subscriptions()
                            ->whereRaw("DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY) >= CURDATE()")
                            ->orderBy('pivot_created_at', 'asc')
                            ->get()
                            ->first();

        $last_subscr = $user->subscriptions()
                            ->whereRaw("DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY) >= CURDATE()")
                            ->orderBy('pivot_created_at', 'asc')
                            ->get()
                            ->last();

        $date_activation = Date::parse($first_subscr->pivot->created_at)->format('d F Y');
        $date_finish = Date::parse(strtotime("{$last_subscr->pivot->created_at} + {$last_subscr->days} days"))->format('d F Y');
        $dates = array($date_activation, $date_finish);

        $userparameters = Userparameter::where('user_id', $user->id)->get();

        $program_histories = Programtraining::whereHas('programHistories', function($query) use($user) {
            $query->where('user_id', $user->id);
        })->orWhereHas('allUsers', function($query) use($user) {
            $query->where('user_id', $user->id);
        })->get();


        $programs = Programtraining::whereHas('activeprograms', function($query) {
            $query->where('date_start', '<=', \DB::raw('NOW()'))
                  ->where('date_finish', '>=', \DB::raw('NOW()'));
        })->get();

        $today = \Date::today()->dayOfWeek;
        if($today == 0) {
            $today = 7;
        }

        $day = $user->getProgramtrainginDaysPassed() - $today;

        // SELECT 100 * (count(user_id) - sum(reverse)) / count(user_id) as rating, user_id
        // FROM `exercise_user`
        // WHERE 1
        // GROUP BY user_id
        // ORDER BY rating DESC
        // LIMIT 100;

        $rating = ($user->current_programtraining ?? $user->programtraining)
                    ->doneExersices()
                    ->groupBy('user_id')
                    ->selectRaw('100 * (count(user_id) - sum(reverse)) / count(user_id) as rating, user_id')
                    ->orderBy('rating', 'desc')
                    ->with(['user' => function($query) {
                        $query->select(['id', 'name']);
                    }])
                    // ->take(100)
                    ->get();

        $weekRating = ($user->current_programtraining ?? $user->programtraining)
                    ->doneExersices()
                    ->groupBy('user_id')
                    ->where('day_number', '>=', $day)
                    ->selectRaw('100 * (count(user_id) - sum(reverse)) / count(user_id) as rating, user_id')
                    ->orderBy('rating', 'desc')
                    ->with(['user' => function($query) {
                        $query->select(['id', 'name']);
                    }])
                    // ->take(100)
                    ->get();
        $statistics = $user->doneExersices()->where('programtraining_id', $user->programtraining_id)->get();
        $weekStatistics = $user->doneExersices()->where('day_number', '>=', $day)->where('programtraining_id', $user->programtraining_id)->get();

        return view('profile', [
            'user' => $user,
            'program_histories' => $program_histories,
            'dates' => $dates,
            'userparameters' => $userparameters,
            'programs' => $programs,
            'statistics' => $statistics,
            'weekStatistics' => $weekStatistics,
            'rating' => $rating,
            'weekRating' => $weekRating,
        ]);
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
        $program = Programtraining::where('id', $request->programtraining_id)->first();
        $updating = $user->setNextUserProgram($program);


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

    public function userAutoRenewalUpdate(Request $request)
    {
        $user = $request->user();
        $user->update(['is_auto_renewal' => $request->is_auto_renewal]);
    }

    public function userNotifiableUpdate(Request $request)
    {
        $user = $request->user();
        $user->update(['is_notifiable' => $request->is_notifiable]);
    }
}
