<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('jalali_date', function ($attribute, $value, $parameters)
        {
            $value = HConvertNumbersFatoEn($value);
            $matches = [];
            if (!$parameters || empty($parameters))
            {
                $parameters[0] = '\/';
            }
            elseif ($parameters[0] == '/')
            {
                $parameters[0] = '\/';
            }
            preg_match('/^((?:13|14)\d\d)[' . $parameters[0] . '](0[1-9]|1[012])[' . $parameters[0] . '](0[1-9]|[12][0-9]|3[01])$/i', $value, $matches);
//            dd($value, $parameters, $matches);
            return isset($matches[0]);
        });
        Validator::extend('jalali_date_after', function ($attribute, $value, $parameters)
        {
            $field = $attribute;
            $field_value = $value;
            $parameter = array_shift($parameters);
            $parameter_values = $parameters;
            $compare_value = time();
            switch ($parameter)
            {
                case 'today':
                {
                    $compare_value = HDate_GtoJ(date('Y-m-d'), 'Y/m/d', false);
                    break;
                }
                case 'yesterday':
                {
                    $compare_value = HDate_GtoJ(date('Y-m-d', strtotime("-1 days")), 'Y/m/d', false);
                    break;
                }
                case 'field':
                {
                    if (isset($parameter_values[0]))
                    {
                        $compare_value = Request::get($parameter_values[0]);
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            return $field_value > $compare_value;
        });
        Validator::extend('melli_code', function ($attribute, $value, $parameters)
        {
            if (!preg_match('/^[0-9]{10}$/', $value))
            {
                return false;
            }
            for ($i = 0; $i < 10; $i++)
                if (preg_match('/^' . $i . '{10}$/', $value))
                {
                    return false;
                }
            for ($i = 0, $sum = 0; $i < 9; $i++)
                $sum += ((10 - $i) * intval(substr($value, $i, 1)));
            $ret = $sum % 11;
            $parity = intval(substr($value, 9, 1));
            if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
            {
                return true;
            }
            return false;
        });
        Validator::extend('mobile_phone', function ($attribute, $value, $parameters)
        {
            //^09([123])\d{8}$
            return preg_match('/^09\d{9}$/', $value, $matches);
        });
        Validator::extend('check_captcha', function ($attribute, $value, $parameters, $validator)
        {
            return check_captcha($parameters[0], strtoupper($value));
        });
        Validator::extend('valid_username', function ($attribute, $value, $parameters, $validator)
        {
            $valid_user = str_replace('.', '', $value);
            $valid_user = str_replace('_', '', $valid_user);
            $valid_user = str_replace(' ', '', $valid_user);
            return preg_match('/(?!^\d+$)^[a-zA-Z\d-_.]{3,64}$/', $valid_user);
//            return preg_match('/(?!^\d+$)^.+$/', $valid_user);

        });
        /*\Validator::extend( 'test', function ( $attribute, $value, $parameters, $validator ) {
           dd(\Request::get( 'title' ));
           dd($this->get('title'));
           return false;
       });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}