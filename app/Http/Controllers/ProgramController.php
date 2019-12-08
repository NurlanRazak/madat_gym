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
        $programs = Programtraining::where('active', 1)->get();
        return view('programs', ['programs' => $programs]);
    }

    public function postProgram(Request $request)
    {
        $user = $request->user();
        $user->update(['programtraining_id' => $request->programtraining_id]);

        return redirect(route('home'));
    }
}
