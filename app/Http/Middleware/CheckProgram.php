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

        $cnt = $user->programtraining->activeprograms()
                              ->where('date_start', '<=', \DB::raw('NOW()'))
                              ->where('date_finish', '>=', \DB::raw('NOW()'))
                              ->count();

        if($cnt == 0) {
            return redirect(route('programs'));
        }

        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($user->real_programtraining_start->format('Y-m-d h:m')))/60/60/24;
        $passed = intval($passed);
        if ($passed >= $user->programtraining->duration) {
            return redirect(route('programs'));
        }

        return $next($request);
    }
}
