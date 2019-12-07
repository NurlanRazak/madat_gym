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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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

        return view('dashboard.dashboardv1', ['user' => $user, 'time' => $time, 'week' => $week, 'today' => $today]);
    }

}
