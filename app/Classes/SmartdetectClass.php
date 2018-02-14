<?php

namespace App\Classes;

use App\Smartdetect as Model;
use Request;
use Schema;

class SmartdetectClass
{

    private $default_ips =
    [
        '127.0.0.1',
    ];

    private $default_domains =
    [
        'localhost',
        'local',
        'dev',
        'pro',
        'staging',
        'development',
        'production',
    ];
    private $default_users =
    [
        'ids' => ['1', ],
        'emails' => ['root', 'administrator', 'admin', 'developer', ],
    ];
    private $default_requests =
    [
        'debug',
    ];

    private $model;

    public $result_factors =
    [
        'ip' => null,
        'domain' => null,
        'user_id' => null,
        'user_email' => null,
        'request' => null,
    ];
    public $results =
    [
        'ip' => null,
        'domain' => null,
        'user_id' => null,
        'user_email' => null,
        'request' => null,
    ];
    public $result = null;

    function __construct(array $config = [])
    {
        if (!Schema::hasTable(Model::schema_table)) { return; }
        if (!Request::input('smartdetect', true)) { return; }
        $this->model = new Model();
        $this->result_factors =
        [
            'ip' => $this->ip(),
            'domain' => $this->domain(),
            'user_id' => $this->user('id'),
            'user_email' => $this->user('email'),
            'request' => $this->request('any'),
        ];
        foreach ($this->result_factors as $k => $v)
        {
            $this->results[$k] = (bool) $v;
        }
        $this->result = in_array(true, $this->results);
    }

    private function ip()
    {
        if ($factor = Request::getClientIp())
        {
            if (in_array($factor, array_merge($this->default_ips, $this->model->ip_array_flat())))
            {
                return $factor;
            }
        }
        return false;
    }

    private function domain()
    {
        if ($factor = Request::getHttpHost())
        {
            if (in_array($factor, array_merge($this->default_domains, $this->model->domain_array_flat())))
            {
                return $factor;
            }
        }
        return false;
    }

    private function user($user_factor)
    {
        if (auth()->check())
        {
            switch ($user_factor)
            {
                case 'id':
                case 'email':
                    $factor = auth()->user()->$user_factor;
                break;
                default:
                    return false;
                    break;
            }
            if (in_array($factor, array_merge($this->default_users[$user_factor . 's'], $this->model->user_array_flat($user_factor))))
            {
                return $factor;
            }
        }
        return false;
    }

    private function request($request_method = 'any')
    {
        $request_method = strtolower($request_method);
        switch ($request_method)
        {
            case 'get':
            case 'post':
                $factor_method = $request_method;
            break;
            case 'any':
                $factor_method = null;
            break;
            default:
                return false;
        }
        $factors = array_merge($this->default_requests, $this->model->request_array_flat($request_method));
        if ($factors)
        {
            foreach ($factors as $factor)
            {
                if (Request::exists($factor))
                {
                    if ($factor_method)
                    {
                        if ($factor_method == strtolower(Request::getMethod()))
                        {
                            return $factor;
                        } else
                        {
                            return false;
                        }
                    } else
                    {
                        return $factor;
                    }
                }

            }
        }
        return false;
    }

    function __destruct()
    {
        //dd(Request::all());
    }

}

// Usage:
/*
if (Schema::hasTable(\App\Smartdetect::schema_table))
{
    $smartdetect = new \App\Classes\SmartdetectClass();
    if ($smartdetect->results['ip'])
    {
        dd(time());
    }
}
*/