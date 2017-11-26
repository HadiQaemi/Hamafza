<?php
namespace App\Http\Controllers\Hamahang;

use DB;
use Auth;
use Request;
use Redirect;
use Storage;
use Morilog\Jalali\jDate;
use Morilog\Jalali\jDateTime;
use App\Models\Hamahang\Calendar\Calendar_Event;

use App\Http\Controllers\Controller;

class WebRTC extends Controller
{
    public function OperatorShow($uname,$id)
    {
		$arr = variable_generator('user','desktop',$uname);
        $arr['Operator_ID']=$id;
        return view('hamahang.WebRTC.OperatorShow', $arr);
    }
}