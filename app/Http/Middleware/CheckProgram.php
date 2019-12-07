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
        if(!$user->programtraining_id) {
            return redirect(route('programs'));
        }
        return $next($request);
    }
}
