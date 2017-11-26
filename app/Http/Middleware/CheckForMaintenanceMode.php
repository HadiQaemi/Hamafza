<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as MaintenanceMode;

class CheckForMaintenanceMode {

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() && !in_array($request->getClientIp(), ['89.165.122.115', '188.34.116.207','127.0.2.1']))
        {
            //abort(500);
            $with_arr['error'] = '503';
            return response()->view('layouts.errors.errors_helper.503', $with_arr);
            /*$maintenanceMode = new MaintenanceMode($this->app);
            return $maintenanceMode->handle($request, $next);*/
        }
        return $next($request);
    }
}
