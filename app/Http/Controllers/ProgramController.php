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
        })->get();

        return view('programs', ['programs' => $programs]);
    }

    public function buyProgram(Request $request)
    {
        $user = $request->user();

        $programtraining = Programtraining::findOrFail($request->programtraining_id);
        $request->session()->put('programtraining_id', $programtraining->id);

        return redirect()->to('/buy');
    }


    public function postProgram(Request $request)
    {
        $user = $request->user();
        // TODO: set next program
        $updating = $user->changeUserProgram(Programtraining::where('id', $request->programtraining_id)->first());

        $user->update([
            'programtraining_id' => $request->programtraining_id,
            'programtraining_start' => \DB::raw('NOW()'),
        ]);
        $user->doneExersices()->delete();
        return redirect(route('home'));
    }

    public function changeProgram(Request $request)
    {
        $user = $request->user();
        $updating = $user->changeUserProgram(Programtraining::where('id', $request->programtraining_id)->first());

    }
}
