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

        if($cnt > 0) {
            return redirect()->to('/');
        }

        return $next($request);
    }
}
