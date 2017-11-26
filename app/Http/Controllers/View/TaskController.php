<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\TaskClass;
use App\HamafzaViewClasses\DesktopClass;
class TaskController extends Controller
{
    public static function Show($uname) {
         if (!Auth::check())
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        else {
            $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
            $Tree = DesktopClass::DeskTopTree($uid, 0, '', '');
            $Tc= new TaskClass();
            $arr =  $Tc->ShowTask($uname, $uid, $Tree);
			$arr['content']="54654645";
			return view('pages.Desktop.Task',$arr);
        }
        
        
    }
}
