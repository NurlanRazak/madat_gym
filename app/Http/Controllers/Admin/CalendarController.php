<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function update(Request $request)
    {
        return dd($request->toArray());
    }

}
