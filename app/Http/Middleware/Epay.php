<?php

namespace App\Http\Middleware;

use Closure;

class Epay
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
        if (!$this->checkSign($request)) {
            abort(400, 'FUCK U!');
        }

        return $next($request);
    }

    private function checkSign($request)
    {
        $checksum = $request->pg_sig;

        $params = $request->except('pg_sig');
        ksort($params);
        array_unshift($params, basename(route('payment-result')));
        array_push($params, config('epay.secret'));

        return $checksum == md5(implode(';', $params));
    }
}
