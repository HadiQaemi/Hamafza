<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class DynamicPermission
{
    public function __construct()
    {

    }

    public function handle($request, Closure $next, $permission)
    {
//        echo '<hr/>'.($permission).'<hr/>';
//        return $next($request);

        $role_name = config('constants.APP_PUBLIC_ROLE');
        $role = Role::where('name', $role_name)->first();
        if ($role && $role->_permissions)
        {
            $exist_permission = $role->permissions()->where('name', $permission)->first();
            if ($exist_permission)
            {
                return $next($request);
            }
            else
            {
                if (auth()->check())
                {
                    if ($request->user()->hasPermission($permission))
                    {
                        return $next($request);
                    }
                    else
                    {
//                        echo '<hr/>'.($permission).'<hr/>';
                        return response()->view('errors.403');
                        //abort('403');
                    }
                }
                else
                {
//                    echo '<hr/>'.($permission).'<hr/>';
                    return response()->view('errors.403');
                    //abort('403');
                }
            }
        }

        return response()->view('errors.403');
        //abort('403');
    }
}
