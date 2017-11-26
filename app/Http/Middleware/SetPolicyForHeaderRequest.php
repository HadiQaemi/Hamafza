<?php

namespace App\Http\Middleware;

use Request;
use Closure;
use App\Jobs\storeLogRequest;

class SetPolicyForHeaderRequest
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (method_exists($response, 'header'))
        {
            $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
            $response->header('Pragma', 'no-cache');
        }
        return $response;
    }

}
