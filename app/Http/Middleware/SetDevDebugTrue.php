<?php namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;

class SetDevDebugTrue
{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getClientIp(), ['89.165.122.115', '188.34.116.207', '127.0.0.1']))
        {
            config(['app.debug' => true]);
            \Debugbar::enable();
        }
        else
        {
            config(['app.debug' => env('APP_DEBUG')]);
            \Debugbar::disable();
        }
        return $next($request);
    }
}
