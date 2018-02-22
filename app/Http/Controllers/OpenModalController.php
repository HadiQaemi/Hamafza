<?php
/**
 * Created by PhpStorm.
 * User: hamahang
 * Date: 3/4/17
 * Time: 9:50 AM
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use DB;


class OpenModalController extends Controller
{
    public function create_new_task()
    {
        $arr['uname'] = $arr['UName'] = Auth::user()->Uname;
        $arr['HFM_CNT'] = HFM_GenerateUploadForm([['CreateNewTask', ['jpeg', 'jpg', 'png', 'gif', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'],'Multi']]);
        return view('hamahang.modals.create_new_task', $arr);
    }
    public function  new_procccess()
    {
        $arr['uname'] = $arr['UName'] = Auth::user()->Uname;
        return view('hamahang.modals.create_new_proccess',$arr);
    }
    public function new_project()
    {
        $arr['uname'] = $arr['UName'] = Auth::user()->Uname;
        $calendars = DB::table('hamahang_calendar')->select('id', 'title')->where('uid', '=', Auth::id())->get();
        return view('hamahang.modals.create_new_project', $arr)->with('calendars', $calendars);
    }
}