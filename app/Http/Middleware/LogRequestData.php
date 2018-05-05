<?php

namespace App\Http\Middleware;

use Request;
use Closure;
use App\Jobs\storeLogRequest;

class LogRequestData
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
        $request_info['ip'] = Request::ip();
        $request_info['url'] = Request::url();
        $request_info['uri'] = Request::getUri();
        $request_info['path'] = Request::path();
        $request_info['request_uri'] = Request::getRequestUri();
        $request_info['query_string'] = Request::getQueryString();
        $request_info['port'] = Request::getPort();
        $request_info['ajax'] = Request::ajax() == true ? '1' : '0';
        $request_info['method'] = Request::method();
        $request_info['is_secure'] = Request::secure() == true ? '1' : '0';
        //$request_info['post_data'] = Request::instance()->getContent();
        $request_info['response_format'] = Request::format();

        //$IP_info = geoip()->getLocation();
        $job = (new storeLogRequest($request_info))->onQueue('log_request');
        dispatch($job);
        return $next($request);
    }
}
