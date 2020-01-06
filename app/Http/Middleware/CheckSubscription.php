<?php

namespace App\Http\Middleware;

use Closure;

class CheckSubscription
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
        if ($user->roles->count() > 0) {
            return redirect()->to('/admin');
        }

        $cnt = $user->subscriptions()
                    ->whereRaw("DATE_ADD(subscription_user.created_at, INTERVAL subscriptions.days DAY) >= CURDATE()")
                    ->count();

        if ($cnt == 0) {
            return redirect(route('subscription'));
        }

        return $next($request);
    }
}
