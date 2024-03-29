<?php

namespace App\Http\Middleware;

use Closure;
use \Carbon\Carbon;

class CheckProgram
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user();

        if (!$user->programtraining) {
            return redirect(route('programs'));
        }

        // QUESTION: 
        $cnt = $user->programtraining->activeprograms()
                              ->where('date_start', '<=', \DB::raw('NOW()'))
                              ->where('date_finish', '>=', \DB::raw('NOW()'))
                              ->count();

        if($cnt == 0) {
            return redirect(route('programs'));
        }

        $passed = $user->getProgramtrainginDaysPassed();

        if ($passed >= $user->programtraining->duration) {
            return redirect(route('programs'));
        }

        return $next($request);
    }
}
