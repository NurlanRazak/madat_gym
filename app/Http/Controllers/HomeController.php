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



        $passed = (strtotime(Carbon::now()->format('Y-m-d h:m')) - strtotime($user->real_programtraining_start->format('Y-m-d h:m')))/60/60/24;
        $passed = intval($passed);

        $relaxtrainings_data = [];
        $relaxtrainings = $user->getRelaxtrainings();
        foreach($relaxtrainings as $item) {
            if (!isset($relaxtrainings_data[$item->number_day - $passed + $today - 1])) {
                $relaxtrainings_data[$item->number_day - $passed + $today - 1] = [];
            }
            $relaxtrainings_data[$item->number_day - $passed + $today - 1][] = $item;
        }

        $trainings_data = [];
        $trainings = $user->getTrainings();

        foreach($trainings as $item) {
            if (!isset($trainings_data[$item->day_number - $passed + $today - 1])) {
                $trainings_data[$item->day_number - $passed + $today - 1] = [];
            }
            $trainings_data[$item->day_number - $passed + $today - 1][] = $item;
        }

        $equipments_data = [];
        $equipments = $user->getEquipments();

        foreach($equipments as $item) {
            if (!isset($equipments_data[$item->notify_day - $passed + $today - 1])) {
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

        if ($today == 5 && (!$request->session()->has('friday_notification') || $passed != $request->session()->get('friday_notification'))) {
            $nextGroceries = $user->getGroceries(true);
            $nextEquipments = $user->getEquipments(true);
            $request->session()->put('friday_notification', $passed);
        } else {
            $nextGroceries = collect();
            $nextEquipments = collect();
        }

        if ((!isset($trainings_data[$today]) || count($trainings_data[$today]) == 0) && !$user->checkExersice($today, 1)) {
            $user->doneExersices()->create([
                'user_id' => $user->id,
                'key' => 1,
                'day_number' => $passed
            ]);
        }
        if ((!isset($planeats_data[$today]) || count($planeats_data[$today]) == 0) && !$user->checkExersice($today, 2)) {
            $user->doneExersices()->create([
                'user_id' => $user->id,
                'key' => 2,
                'day_number' => $passed
            ]);
        }
        if ((!isset($relaxtrainings_data[$today]) || count($relaxtrainings_data[$today]) == 0) && !$user->checkExersice($today, 3)) {
            $user->doneExersices()->create([
                'user_id' => $user->id,
                'key' => 3,
                'day_number' => $passed
            ]);
        }

        return view('dashboard.dashboardv1', [
            'events' => $user->programtraining->getEvents($user->real_programtraining_start),
            'user' => $user,
            'time' => $time,
            'week' => $week,
            'today' => $today,
            'passed' => $passed,
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
        $passed = (strtotime(Carbon::now()->format('Y-m-d h:m')) - strtotime(Carbon::parse($user->real_programtraining_start)->format('Y-m-d h:m')))/60/60/24;
        $passed = intval($passed);

        $today = \Date::today()->dayOfWeek;
        $day = $passed + $today - $request->day;
        $doneExersice = $user->doneExersices()->where('key', $request->key)->where('day_number', $day)->first();
        if (!$doneExersice) {
            $doneExersice = DoneExersice::create([
                'user_id' => $user->id,
                'key' => $request->key,
                'day_number' => $day,
            ]);
        } else {
            $doneExersice->delete();
        }
    }

    public function saveView(Request $request)
    {
        $user = $request->user();
        $model = $request->model;
        $model_id = $request->model_id;
        $type = $request->type;
        $url = $request->url ?? null;

        \App\View::create([
            'user_id' => $user->id,
            'model' => $model,
            'model_id' => $model_id,
            'type' => $type,
            'url' => $url,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

}
