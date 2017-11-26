<?php

namespace App\Jobs;

use Request;
use App\Models\Hamahang\LogRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class storeLogRequest implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $request_info;

    public function __construct($request_info)
    {
        $this->request_info = $request_info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request_info = $this->request_info;
        $IP_info = geoip($request_info['ip']);
//        dd($IP_info);
        $logs = new LogRequest();
        $logs->ip = $IP_info['ip'];
        $logs->iso_code = $IP_info['iso_code'];
        $logs->country = $IP_info['country'];
        $logs->city = $IP_info['city'];
        $logs->state = $IP_info['state'];
        $logs->state_name = $IP_info['state_name'];
//        $logs->postal_code = $IP_info['postal_code'];
        $logs->lat = $IP_info['lat'];
        $logs->lon = $IP_info['lon'];
        $logs->timezone = $IP_info['timezone'];
        $logs->continent = $IP_info['continent'];
        $logs->currency = $IP_info['currency'];
        $logs->default = $IP_info['default'] == true ? '1' : '0';
        $logs->cached = $IP_info['cached'] == true ? '1' : '0';

        $logs->url = $request_info['url'];
        $logs->uri = $request_info['uri'];
        $logs->path = $request_info['path'];
        $logs->request_uri = $request_info['request_uri'];
        $logs->query_string = $request_info['query_string'];
        $logs->port = $request_info['port'];
        $logs->ajax = $request_info['ajax'];
        $logs->method = $request_info['method'];
        $logs->is_secure = $request_info['is_secure'];
//        $logs->post_data = $request_info['post_data'];
        $logs->response_format = $request_info['response_format'];


        $logs->save();
    }
}
