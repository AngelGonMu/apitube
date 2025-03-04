<?php

namespace App\Http\Middleware;

use Closure;

class RequestMethods
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
        header('Access-Control-Allow-Methods : GET, PUT, POST, DELETE');
        return $next($request);
    }
}
