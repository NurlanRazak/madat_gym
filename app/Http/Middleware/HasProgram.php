<?php

namespace App\Http\Middleware;

use Closure;

class HasProgram
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
        if (!$user->programtraining_id || !$user->programtraining) {
            return $next($request);
        }

        $cnt = $user->programtraining->activeprograms()
                              ->where('date_start', '<=', \DB::raw('NOW()'))
                              ->where('date_finish', '>=', \DB::raw('NOW()'))
                              ->count();

        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($user->real_programtraining_start->format('Y-m-d h:m')))/60/60/24;
        $passed = intval($passed);
        if ($cnt > 0 && $passed < $user->programtraining->duration) {
            // return redirect()->to('/');
        }

        return $next($request);
    }
}
