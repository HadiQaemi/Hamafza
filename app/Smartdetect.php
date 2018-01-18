<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smartdetect extends Model
{

    protected $table = 'smartdetect';

    public function ip(array $columns = [])
    {
        return $this->where('content_type', '=', 'ip')->select(empty($columns) ? '*' : $columns);
    }

    public function ip_array(array $columns = [])
    {
        return $this->ip($columns)->get()->toArray();
    }

    public function ip_array_flat($column = 'content')
    {
        return array_column($this->ip_array([$column]), $column);
    }

    public function domain(array $columns = [])
    {
        return $this->where('content_type', '=', 'domain')->select(empty($columns) ? '*' : $columns);
    }

    public function domain_array(array $columns = [])
    {
        return $this->domain($columns)->get()->toArray();
    }

    public function domain_array_flat($column = 'content')
    {
        return array_column($this->domain_array([$column]), $column);
    }

    public function user($user_factor, array $columns = [])
    {
        switch ($user_factor)
        {
            case 'id':
            case 'email':
                $value = "user_$user_factor";
            break;
            default:
                $value = '-';
                break;
        }
        return $this->where('content_type', '=', $value)->select(empty($columns) ? '*' : $columns);
    }

    public function user_array($user_factor, array $columns = [])
    {
        return $this->user($user_factor, $columns)->get()->toArray();
    }

    public function user_array_flat($user_factor, $column = 'content')
    {
        return array_column($this->user_array($user_factor, [$column]), $column);
    }

    public function request($request_method = 'any', array $columns = [])
    {
        $request_method = strtolower($request_method);
        switch ($request_method)
        {
            case 'get':
            case 'post':
            case 'any':
                $value = "request_$request_method";
            break;
            default:
                $value = '-';
                break;
        }
        return $this->where('content_type', '=', $value)->select(empty($columns) ? '*' : $columns);
    }

    public function request_array($user_factor, array $columns = [])
    {
        return $this->request($user_factor, $columns)->get()->toArray();
    }

    public function request_array_flat($user_factor, $column = 'content')
    {
        return array_column($this->request_array($user_factor, [$column]), $column);
    }

}

