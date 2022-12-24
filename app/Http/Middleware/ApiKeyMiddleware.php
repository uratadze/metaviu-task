<?php

namespace App\Http\Middleware;

use Closure;

class ApiKeyMiddleware
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
        $key = $request->header('x-api-key');

        if ($key != config('app.x_api_key'))
        {
            return responder()->error(401,'Unauthorised x-api-key')->respond(401);
        }

        return $next($request);
    }
}
