<?php

namespace App\Http\Middleware;

use Closure;

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

        $cnt = $user->programtraining->activeprograms()
                              ->where('date_start', '<=', \DB::raw('NOW()'))
                              ->where('date_finish', '>=', \DB::raw('NOW()'))
                              ->count();

        if(!$user->programtraining_id || $cnt == 0) {
            return redirect(route('programs'));
        }
        return $next($request);
    }
}
