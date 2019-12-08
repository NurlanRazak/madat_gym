<?php

namespace App\Http\Controllers;

use App\Models\Programtraining;
use App\User;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    public function programs(Request $request)
    {
        $user = $request->user();
        $programs = Programtraining::whereHas('activeprograms', function($query) {
            $query->where('date_start', '<=', \DB::raw('NOW()'))
                  ->where('date_finish', '>=', \DB::raw('NOW()'));
        })->where('active', 1)->get();

        return view('programs', ['programs' => $programs]);
    }

    public function postProgram(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->update(['programtraining_id' => $request->programtraining_id]);
        $user->save();
    }
}
