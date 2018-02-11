<?php namespace App\Http\Middleware;

use App\Classes\SmartdetectClass;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Schema;

class SetDevDebugTrue
{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        $turn_on = false;
        if (Schema::hasTable(\App\Smartdetect::schema_table))
        {
            $smartdetect = new SmartdetectClass();
            if ($smartdetect->results['ip'])
            {
                $turn_on = true;
            }
        }

        //if (in_array($request->getClientIp(), ['89.165.122.115', '188.34.116.207', '127.0.0.1']))
        if ($turn_on)
        {
            config(['app.debug' => true]);
            \Debugbar::disable();
        }
        else
        {
            config(['app.debug' => env('APP_DEBUG')]);
            \Debugbar::disable();
        }
        return $next($request);
    }
}
