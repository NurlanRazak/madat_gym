<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Jenssegers\Date\Date;

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


    public function home()
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



        $passed = strtotime(Carbon::parse($user->programtraining_start)->format('Y-m-d')) - strtotime('today');

        $relaxtrainings_data = [];
        $relaxtrainings = $user->programtraining
                               ->relaxprogram
                               ->relaxtrainings()
                               ->whereHas('users', function($query) use($user) {
                                   $query->where('id', $user->id);
                               })
                               ->where('number_day', '>=', $passed - $today + 2)
                               ->where('number_day', '<=', $passed - $today + 8)
                               ->active()
                               ->get();

        foreach($relaxtrainings as $item) {
            if (!isset($relaxtrainings_data[$item->number_day - $passed+ $today - 1])) {
                $relaxtrainings_data[$item->number_day - $passed+ $today - 1] = [];
            }
            $relaxtrainings_data[$item->number_day - $passed+ $today - 1][] = $item;
        }

        $trainings_data = [];
        $trainings = $user->programtraining
                          ->trainings()
                          ->where('day_number', '>=', $passed - $today + 2)
                          ->where('day_number', '<=', $passed - $today + 8)
                          ->active()
                          ->get();

        foreach($trainings as $item) {
            if (!isset($trainings_data[$item->day_number - $passed+ $today - 1])) {
                $trainings_data[$item->day_number - $passed+ $today - 1] = [];
            }
            $trainings_data[$item->day_number - $passed+ $today - 1][] = $item;
        }

        $equipments_data = [];
        $equipments = $user->programtraining
                           ->equipments()
                           ->where('notify_day', '>=', $passed - $today + 2)
                           ->where('notify_day', '<=', $passed - $today + 8)
                           ->active()
                           ->get();

        foreach($equipments as $item) {
            if (!isset($equipments_data[$item->days - $passed+ $today - 1])) {
                $equipments_data[$item->days - $passed+ $today - 1] = [];
            }
            $equipments_data[$item->days - $passed+ $today - 1][] = $item;
        }

        $planeats_data = [];
        $planeats = $user->programtraining
                         ->foodprogram
                         ->planeats()
                         ->where('days', '>=', $passed - $today + 2)
                         ->where('days', '<=', $passed - $today + 8)
                         ->active()
                         ->get();

        foreach($planeats as $item) {
            if (!isset($planeats_data[$item->days - $passed+ $today - 1])) {
                $planeats_data[$item->days - $passed+ $today - 1] = [];
            }
            $planeats_data[$item->days - $passed+ $today - 1][] = $item;
        }


        return view('dashboard.dashboardv1', [
            'user' => $user,
            'time' => $time,
            'week' => $week,
            'today' => $today,
            'planeats' => $planeats_data,
            'equipments' => $equipments_data,
            'trainings' => $trainings_data,
            'relaxtrainings' => $relaxtrainings_data,
        ]);
    }

}
