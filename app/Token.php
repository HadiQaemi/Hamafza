<?php

namespace App;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use SoftDeletes;
    protected $table = 'tokens';
    protected $hidden = [
        'token',
    ];
    protected $dates = ['deleted_at'];

    public static function GenerateToken($uid, $imei, $os_name, $os_version, $device_name, $guest_mode = 0, $life_time = 84600)
    {
        if ($guest_mode)
        {
            $token_str = 'Guest__' . Hash::make(time() . '_' . $imei . $os_name . $os_version . $device_name);
        }
        else
        {
            $token_str = 'User__' . Hash::make(time() . '_' . $imei . $os_name . $os_version . $device_name);
        }
        $token = new Token;
        $token->uid = $uid;
        $token->guest_mode = $guest_mode;
        $token->token = $token_str;
        $token->life_time = $life_time;
        $token->last_response_time = date('c',time());
        $token->imei = $imei;
        $token->os_name = $os_name;
        $token->os_version = $os_version;
        $token->device_name = $device_name;
        $token->save();
        $res['token_id'] = $token->id;
        $res['token'] = $token_str;
        return $res;
    }

    public function user(){
        return $this->hasOne('App\User','id','uid');
    }
}
