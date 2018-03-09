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
        $APP_DEBUG = null;
        switch (strtolower(env('APP_DEBUG')))
        {
            case 'smartdetect':
                $smartdetect = new SmartdetectClass();
                $APP_DEBUG = $smartdetect->results['ip'];
            break;
            default:
                $APP_DEBUG = env('APP_DEBUG');
        }
        config(['app.debug' => $APP_DEBUG]);
        if ($APP_DEBUG)
        {
            \Debugbar::disable();
        } else
        {
            \Debugbar::disable();
        }
        return $next($request);
    }
}
