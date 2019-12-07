<?php

namespace App\Http\Controllers;

use App\Models\Programtraining;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    public function programs(Request $request)
    {
        $user = $request->user();
        $programs = Programtraining::where('active', 1)->get();
        return view('programs', ['programs' => $programs]);
    }
}
