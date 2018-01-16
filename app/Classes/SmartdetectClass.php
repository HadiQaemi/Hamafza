<?php

namespace App\Classes;

use App\Smartdetect as Model;
use Request;

class SmartdetectClass
{

    private $model;
    public $result;

    function __construct(array $config = [])
    {
        $this->model = new Model();
        $this->result = $this->hostname() || $this->user_email() || $this->user_id() || $this->hostname();
    }

    private function ip()
    {
        $factor = Request::getClientIp();
        if ($factor)
        {
            if (in_array($factor, ['127.0.0.1', ]))
            {
                return true;
            }
            $items = $this->model->ip->get();
            if ($items)
            {
                foreach ($items as $item)
                {
                    if ($factor == $item->content)
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function user_email()
    {
        $factor = auth()->user()->Email;
        if ($factor)
        {
            if (in_array($factor, ['root', 'administrator', 'admin', 'developer', ]))
            {
                return true;
            }
            $items = $this->model->user_email->get();
            if ($items)
            {
                foreach ($items as $item)
                {
                    if ($factor == $item->content)
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function user_id()
    {
        $factor = auth()->id();
        if ($factor)
        {
            if (in_array($factor, [1, ]))
            {
                return true;
            }
            $items = $this->model->user_id->get();
            if ($items)
            {
                foreach ($items as $item)
                {
                    if ($factor == $item->content)
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function hostname()
    {
        $factor = Request::getHttpHost();
        dd($factor);
        /*
        local
        development
        production
        */
        //$r = preg_match('/.*\.local|aaa$|localhost/i', $_SERVER['HTTP_HOST'], $this->hostname);
        //return $r;
    }

    function result()
    {

    }

    function __destruct()
    {

    }

}

