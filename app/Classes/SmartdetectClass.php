<?php

namespace App\Classes;

use App\Smartdetect;

class SmartdetectClass
{

    var $hostname;

    function __construct(array $config = [])
    {
        dd($this->init());
    }

    function __destruct()
    {

    }

    private function init()
    {
        $request = Request();
        $client_ip = $request->getClientIp();

        $ips = Smartdetect::where('content_type', 'ip')->select(['content', 'action'])->get();

        if ($ips)
        {
            foreach ($ips as $ip)
            {
                if ($client_ip == $ip->content)
                {
                    return true;
                }
            }
        }
    }

    private function hostname()
    {
        /*
        local
        development
        production
        */
        //$r = preg_match('/.*\.local|aaa$|localhost/i', $_SERVER['HTTP_HOST'], $this->hostname);
        //return $r;
    }

    private function has_ip()
    {

    }

    function result()
    {

    }

}

