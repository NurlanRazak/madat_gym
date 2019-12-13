<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Jenssegers\Date\Date;

use App\DoneExersice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function home(Request $request)
    {
        //TODO crop day name by first слог var week and date
        $first_day = Date::parse('monday this week')->format('d F');
        $last_day = Date::parse('sunday this week')->format('d F Y');
        $week = $first_day." - ".$last_day;

        $today = Date::today()->dayOfWeek;
        if($today == 0) {
            $today = 7;
        }

        $user = Auth::user();
        Date::setlocale(config('app.locale'));
        $time = Date::parse(Carbon::now())->format('l d F Yг.');
        $fc = mb_strtoupper(mb_substr($time, 0, 1));
        $time = $fc.mb_substr($time, 1);



        $passed = (strtotime(Carbon::now()->format('Y-m-d')) - strtotime(Carbon::parse($user->programtraining_start)->format('Y-m-d')))/60/60/24;

        $relaxtrainings_data = [];
        $relaxtrainings = $user->getRelaxtrainings();
        foreach($relaxtrainings as $item) {
            if (!isset($relaxtrainings_data[$item->number_day])) {
                $relaxtrainings_data[$item->number_day] = [];
            }
            $relaxtrainings_data[$item->number_day][] = $item;
        }

        $trainings_data = [];
        $trainings = $user->getTrainings();

        foreach($trainings as $item) {
            if (!isset($trainings_data[$item->day_number])) {
                $trainings_data[$item->day_number] = [];
            }
            $trainings_data[$item->day_number][] = $item;
        }

        $equipments_data = [];
        $equipments = $user->getEquipments();

        foreach($equipments as $item) {
            if (!isset($equipments_data[$item->notify_day])) {
                $equipments_data[$item->notify_day - $passed + $today - 1] = [];
            }
            $equipments_data[$item->notify_day - $passed + $today - 1][] = $item;
        }

        $groceries = $user->getGroceries();
        $planeats_data = [];
        $planeats = $user->getPlaneats();

        foreach($planeats as $item) {
            if (!isset($planeats_data[$item->days - $passed + $today - 1])) {
                $planeats_data[$item->days - $passed + $today - 1] = [];
            }
            $planeats_data[$item->days - $passed + $today - 1][] = $item;
        }

        if ($today == 5 && (!$request->session()->has('friday_notification')) || $passed != $request->session()->get('friday_notification')) {
            $nextGroceries = $user->getGroceries(true);
            $nextEquipments = $user->getEquipments(true);
            $request->session()->put('friday_notification', $passed);
        } else {
            $nextGroceries = collect();
            $nextEquipments = collect();
        }

        return view('dashboard.dashboardv1', [
            'user' => $user,
            'time' => $time,
            'week' => $week,
            'today' => $today,
            'user' => $user,
            'planeats' => $planeats_data,
            'equipments' => $equipments_data,
            'groceries' => $groceries,
            'all_equipments' => $equipments,
            'trainings' => $trainings_data,
            'relaxprogram' => $user->programtraining ? $user->programtraining->relaxprogram : null,
            'relaxtrainings' => $relaxtrainings_data,
            'nextGroceries' => $nextGroceries,
            'nextEquipments' => $nextEquipments,
        ]);
    }

    public function toggleUserExercise(Request $request)
    {
        $user = $request->user();
        $passed = (strtotime(Carbon::now()->format('Y-m-d')) - strtotime(Carbon::parse($user->programtraining_start)->format('Y-m-d')))/60/60/24;
        $doneExersice = $user->doneExersices()->where('key', $request->key)->where('day_number', $passed)->first();
        $today = \Date::today()->dayOfWeek;

        if (!$doneExersice) {
            $doneExersice = DoneExersice::create([
                'user_id' => $user->id,
                'key' => $request->key,
                'day_number' => $passed + $today - $request->day,
            ]);
        } else {
            $doneExersice->delete();
        }
    }

}
