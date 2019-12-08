<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{


    public function history(Request $request)
    {
        $subscriptions = $request->user()->subscriptions;
        return view('history', ['subscriptions' => $subscriptions]);
    }
}
