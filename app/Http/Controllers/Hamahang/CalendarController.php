<?php

namespace App\Http\Controllers\Hamahang;

use App\Models\Hamahang\Tasks\tasks;
use DB;
use Auth;
use Request;
use Session;
use Redirect;
use App\User;
use Datatables;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;
use App\HamahangCustomClasses\jDateTime;
use App\HamahangCustomClasses\OghatSharei;
use App\Models\Hamahang\Calendar\Calendar;
use App\Models\Hamahang\CalendarEvents\Events;
use App\Models\Hamahang\Calendar\Calendar_Sharing;
use App\Models\Hamahang\Calendar\Calendar_Permission;
use App\Models\Hamahang\CalendarEvents\Persian_Event;
use App\Models\Hamahang\Calendar\Calendar_Hiddentimes;

class CalendarController extends Controller
{
    public function GetAllEvents($year, $GhamariMonthes = array())
    {
        date_default_timezone_set('Asia/Tehran');
        $jDate = new jDateTime();
        //  return $jDate->Jalali_to_Ghamari($year,$month,$day);
        $start_date_miladi = jDateTime::toGregorian($year, 1, 1);
        $end_date_miladi = jDateTime::toGregorian($year + 1, 1, 1);
        $start_time = strtotime(implode("-", $start_date_miladi));
        $end_time = strtotime(implode("-", $end_date_miladi));
        $i = $start_time;
        $result = array();
        $count = 0;
        while ($i < $end_time)
        {
            $count++;
            $miladi_year = date('Y', $i);
            $miladi_month = date('m', $i);
            $miladi_day = date('d', $i);
            $GhamariDate = $jDate->gregorian_to_ghamari($miladi_year, $miladi_month, $miladi_day);
            $Gregorian_Events = DB::table('hamahang_calendar_events')
                ->where('type', 'GregorianCalendar')
                ->where('Month', $miladi_month)
                ->where('Day', $miladi_day)
                ->get();
            foreach ($Gregorian_Events as $g)
            {
                $this->toPersian($i, $g);
            }
            /* if(isset($GhamariMonthes) && count($GhamariMonthes) > 0 )
             {
                 $count_day = $GhamariDate[2];
                 $count_default_day =  $GhamariDate[2];
                 foreach($GhamariMonthes as $k=>$v)
                 {
                     if($k < $GhamariDate[1]-1)
                     {
                         $count_day = $count_day + $v;
                         $count_default_day = $count_default_day + $defaultGhamariMonthLength[$k];
                     }
                     else
                     {
                         continue;
                     }
                 }*/
            //$diffLength =   $count_default_day -$count_day;
            //$GhamariDate[2] = $GhamariDate[2] -  $diffLength;
            // }
            $Ghamari_Events = DB::table('hamahang_calendar_events')
                ->where('type', 'ObservedHijriCalendar')
                ->where('Month', $GhamariDate[1])
                ->where('Day', $GhamariDate[2])
                ->get();
            foreach ($Ghamari_Events as $g)
            {
                $this->toPersian($i, $g);
            }
            $Jalali_Events = DB::table('hamahang_calendar_events')
                ->where('type', 'PersianCalendar')
                ->where('Month', jDateTime::strftime('m', $i))
                ->where('Day', jDateTime::strftime('d', $i))
                ->get();
            foreach ($Jalali_Events as $j)
            {
                $this->toPersian($i, $j);
            }
            $result[$count]['timestamp'] = $i;
            $result[$count]['jDate'] = jDateTime::strftime('Y-m-d', $i);
            $result[$count]['gDate'] = implode("-", $GhamariDate);
            $result[$count]['Date'] = date('Y-d-m', $i);
            $result[$count]['Gregorian_Events'] = $Gregorian_Events->toArray();
            $result[$count]['Ghamari_Events'] = $Ghamari_Events->toArray();
            $result[$count]['Jalali_Events'] = $Jalali_Events->toArray();

            $i = $i + 86400;
        }
        return var_dump($result);
    }

    public function toPersian($times, $records = array())
    {
        $jdate = jDateTime::strftime('Y-m-d', $times, false);
        $jdate = explode('-', $jdate);
        try
        {
            $pCalendar = new Persian_Event();
            $pCalendar->uid = Auth::id();
            $pCalendar->Month = $jdate[1];
            $pCalendar->Day = $jdate[2];
            $pCalendar->Year = $jdate[0];
            $jDateObj = new jDateTime();
            $pCalendar->g_time = $jDateObj->Jalali_to_Gregorian($jdate[0], $jdate[1], $jdate[2], '-');
            $pCalendar->Description = $records->Description;
            $pCalendar->IsVacation = $records->IsVacation;
            $pCalendar->type = $records->type;
            //var_dump($pCalendar);die();
            if ($pCalendar->save())
            {
                return Redirect::to('users')->with('message', sprintf('Day: "%s" successfully saved', $pCalendar->Day));
            }
            else
            {
                return Redirect::to('users')->with('message', 'Failed to create user');
            }
        } catch (Exception $e)
        {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function Index($Uname)
    {
        /*dd((serialize(array(
            'jalali'=> array('checked'=>1 ,'color'=>'#db832b'),
            'gergorian'=> array('checked'=>1 ,'color'=>'#db832b'),
            'ghamari'=> array('checked'=>1 ,'color'=>'#db832b'),
            'vacation'=> array('checked'=>1 ,'color'=>'#f73900'),
            'event'=>  array('checked'=>1 ,'color'=>'#116df7'),
            'session'=>array('checked'=>1 ,'color'=>'#16224f'),
            'invitation'=> array('checked'=>1 ,'color'=>'#db832b'),
            'reminder'=>array('checked'=>1 ,'color'=>'#26242d'),
            ))));*/
        $arr = variable_generator('user', 'desktop', $Uname);
        DB::enableQueryLog();
        $arr['cal'] = DB::table('hamahang_calendar')
            ->select('hamahang_calendar.*')
            ->where('hamahang_calendar.user_id', '=', Auth::id())
            ->get();
        if (!$arr['cal']->count())
        {

            $arr['cal'][0] = (object)array('title' => 'تقویمی موجود نیست ', 'id' => 0);
        }
        // var_dump($arr['cal'][0]);die();
        Session::put('current_c', $arr['cal'][0]->id);
        Session::put('current_c_title', $arr['cal'][0]->title);
        $arr['cal_title'] = Session::get('current_c_title', $arr['cal'][0]->title);
        $user = Auth::user()->getAttributes();
        $arr['uname'] = $user['Uname'];
        $arr['HFM_CalendarEvent'] = HFM_GenerateUploadForm([['CalendarEvent', ['doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'], 'Multi']]);
        return view('hamahang.Calendar.Index', $arr);
    }

    function SetTask($Uname)
    {
        /*dd((serialize(array(
            'jalali'=> array('checked'=>1 ,'color'=>'#db832b'),
            'gergorian'=> array('checked'=>1 ,'color'=>'#db832b'),
            'ghamari'=> array('checked'=>1 ,'color'=>'#db832b'),
            'vacation'=> array('checked'=>1 ,'color'=>'#f73900'),
            'event'=>  array('checked'=>1 ,'color'=>'#116df7'),
            'session'=>array('checked'=>1 ,'color'=>'#16224f'),
            'invitation'=> array('checked'=>1 ,'color'=>'#db832b'),
            'reminder'=>array('checked'=>1 ,'color'=>'#26242d'),
            ))));*/
        $date = date('Y-m-d-D');
        $date2 = date('Y-m');
        $gdate['Georgian'] = $date2;
        $date = preg_split('/\-/',$date);
        $gdate['GeorgianDay'] = $date[2];
        $gdate['GeorgianMonth'] = $date[1];
        $gdate['GeorgianYear'] = $date[0];
        $gdate['cal'] = jDateTime::toJalali($date[0],$date[1],$date[2]);
        $gdate['strCal'] = jDateTime::convertNumbers(implode('-',jDateTime::toJalali($date[0],$date[1],$date[2])));
        $gdate['getDayNames'] = jDateTime::getDayNames($date[3]);
        $gdate['getMonthNames'] = jDateTime::getMonthNames($gdate['cal'][1]);

        $arr = variable_generator('user', 'desktop', $Uname);
        DB::enableQueryLog();
        $arr['cal'] = DB::table('hamahang_calendar')
            ->select('hamahang_calendar.*')
            ->where('hamahang_calendar.user_id', '=', Auth::id())
            ->get();
        if (!$arr['cal']->count())
        {
            $arr['cal'][0] = (object)array('title' => 'تقویمی موجود نیست ', 'id' => 0);
        }
        // var_dump($arr['cal'][0]);die();
        Session::put('current_c', $arr['cal'][0]->id);
        Session::put('current_c_title', $arr['cal'][0]->title);
        $arr['cal_title'] = Session::get('current_c_title', $arr['cal'][0]->title);
        $user = Auth::user()->getAttributes();
        $arr['uname'] = $user['Uname'];
        $arr['HFM_CalendarEvent'] = HFM_GenerateUploadForm([['CalendarEvent', ['doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'], 'Multi']]);

        $arr['filter_subject_id'] = $Uname;
        $arr['date'] = $gdate;
        $arr = array_merge($arr, tasks::MyTasksPriorityTime());
        return view('hamahang.Calendar.SetTask', $arr);
    }

    public function calendar()
    {
        $type = Request::input('type');
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        if ($type == 'new')
        {
            $startdate = Request::input('startdate') . ' ' . '00:00:00'; //.'+'.$_POST['zone']
            $enddate = Request::input('startdate') . ' ' . '23:59:59';
            $title = Request::input('title');
            $event = new events;
            $event->title = $title;
            $event->uid = $uid;
            $event->startdate = $startdate;
            $event->enddate = $enddate;
            $event->allDay = 'false';
            $event->cid = Session::get('current_c');
            $event->type = Request::input('event_type');
            $event->save();
            switch ($event->type)
            {
                case(1):
                    $color = 'red';
                    break;
                case(2):
                    $color = 'green';
                    break;
                case(3):
                    $color = 'blue';
                    break;
                case(4):
                    $color = 'pink';
                    break;
                case(5):
                    $color = 'graytext';
                    break;
            }
            echo json_encode(array('status' => 'success', 'eventid' => $event->id, 'color' => $color));
        }

        if ($type == 'changetitle')
        {
            include('assets/file/jdf.php');
            $start_date = explode('-', Request::input('start_date'));
            $st_date = jalali_to_gregorian($start_date[0], $start_date[1], $start_date[2]);
            $gstart_date = $st_date[0] . '-' . $st_date[1] . '-' . $st_date[2];
            $start_time = explode(':', Request::input('start_time'));
            $st_time = jalali_to_gregorian($start_time[0], $start_time[1], $start_time[2]);
            $gstart_time = $st_time[0] . '-' . $st_time[1];
            $end_date = explode('-', Request::input('end_date'));
            $en_date = jalali_to_gregorian($end_date[0], $end_date[1], $end_date[2]);
            $gend_date = $en_date[0] . '-' . $en_date[1] . '-' . $en_date[2];
            $end_time = explode(':', Request::input('end_time'));
            $en_time = jalali_to_gregorian($end_time[0], $end_time[1], $end_time[2]);
            $gend_time = $en_time[0] . '-' . $en_time[1];
            $eventid = Request::input('eventid');
            $title = Request::input('title');
            $event = events::find($eventid);
            $event->uid = $uid;
            $event->title = $title;
            $event->startdate = $gstart_date + ' ' + $gstart_time;
            $event->enddate = $gend_date + ' ' + $gend_time;
            $event->save();
            //$update = mysqli_query($con, "UPDATE sa SET title='$title' where id='$eventid'");
//            if ($update)
            echo json_encode(array('status' => 'success'));
//            else
//                echo json_encode(array('status' => 'failed'));
        }

        if ($type == 'resetdate')
        {
            $title = Request::input('title');
            $startdate = Request::input('start');
            $enddate = Request::input('end');
            $eventid = Request::input('eventid');
            $event = events::find($eventid);
            $event->uid = $uid;
            $event->startdate = $startdate;
            $event->enddate = $enddate;
            $event->save();
//            $update = mysqli_query($con, "UPDATE sa SET title='$title', startdate = '$startdate', enddate = '$enddate' where id='$eventid'");
//            if ($update)
            echo json_encode(array('status' => 'success'));
//            else
//                echo json_encode(array('status' => 'failed'));
        }

        if ($type == 'remove')
        {
            $eventid = Request::input('eventid');
            $event = events::find($eventid);
            $event->delete();
            echo json_encode(array('status' => 'success'));
        }

        if ($type == 'fetch')
        {
            //$events = events:: where('cid', 2 );
            //$events = events::all();
            //die(var_dump($events));
            //DB::enableQueryLog();
            $events = DB::table('hamahang_calendar_user_events')
                ->select('hamahang_calendar_user_events.*')
                ->where('hamahang_calendar_user_events.cid', '=', session('current_c'));
            $x = $events->get();
            $e = array();
            $res = array();
            foreach ($x as $fetch)
            {
                //die(var_dump($fetch));
                $e = array();
                $e['id'] = $fetch->id;
                // die($e['id']);
                $e['title'] = $fetch->title;
                $e['start'] = $fetch->startdate;
                $e['end'] = $fetch->enddate;

                $allday = ($fetch->allDay == "true") ? true : false;
                $e['allDay'] = $allday;
                switch ($fetch->type)
                {
                    case(1):
                        $e['color'] = 'red';
                        break;
                    case(2):
                        $e['color'] = 'green';
                        break;
                    case(3):
                        $e['color'] = 'blue';
                        break;
                    case(4):
                        $e['color'] = 'pink';
                        break;
                    case(5):
                        $e['color'] = 'graytext';
                        break;
                }
                array_push($res, $e);
            }
            //return var_dump($res);die();
            echo json_encode($res);
        }

        if ($type == 'fetch_especial')
        {
            //$events = events:: where('cid', 2 );
            //$events = events::all();
            //die(var_dump($events));
            $events = DB::table('hamahang_calendar_user_events')
                ->select('hamahang_calendar_user_events.*')
                ->where('event.cid', '=', Session::get('current_c'));

            $x = $events->get();
            //die(var_dump($events));
            $e = array();
            $res = array();
            foreach ($x as $fetch)
            {
                //die(var_dump($fetch));
                $e = array();
                $e['id'] = $fetch->id;
                // die($e['id']);
                $e['title'] = $fetch->title;
                $e['start'] = $fetch->startdate;
                $e['end'] = $fetch->enddate;

                $allday = ($fetch->allDay == "true") ? true : false;
                $e['allDay'] = $allday;
                switch ($fetch->type)
                {
                    case(1):
                        $e['color'] = 'red';
                        break;
                    case(2):
                        $e['color'] = 'green';
                        break;
                    case(3):
                        $e['color'] = 'blue';
                        break;
                    case(4):
                        $e['color'] = 'pink';
                        break;
                    case(5):
                        $e['color'] = 'graytext';
                        break;
                }
                array_push($res, $e);
            }
            echo json_encode(array('status' => 'success', 'res' => $res, 'clndr_ttl' => 'current_c_title'));
        }
    }

    public function getAllEvent()
    {
        //$events = Calendar_Persian_Event::where('Month','=',1)->get();
        $events = Calendar_Persian_Event::all();
        $dateObj = new jDateTime();
        $e = array();
        $res = array();
        //include('assets/file/jdf.php');
        foreach ($events as $day)
        {
            $st_date = $dateObj->Jalali_to_Gregorian($day->Year, $day->Month, $day->Day);
            if ($st_date[1] < 10)
            {
                $st_date[1] = '0' . $st_date[1];
            }
            if ($st_date[2] < 10)
            {
                $st_date[1] = '0' . $st_date[2];
            }
            $gstart_date = $st_date[0] . '-' . $st_date[1] . '-' . $st_date[2];
            $e['id'] = $day->id;
            $e['start'] = $gstart_date;
            $e['end'] = $gstart_date;
            $e['allDay'] = true;
            $e['title'] = $day->Description;
            switch ($day->type)
            {
                case 'PersianCalendar':
                    $e['className'] = 'event_calendar jalali_event ';
                    break;
                case 'GregorianCalendar':
                    $e['className'] = 'event_calendar gerregorian_event ';
                    break;
                case 'ObservedHijriCalendar':
                    $e['className'] = 'event_calendar ghamari_event ';
                    break;
            }
            if ($day->IsVacation == 1)
            {
                $e['color'] = 'red';
            }
            else
            {
                $e['color'] = 'green';
            }
            array_push($res, $e);
        }
        $userEvent = $this->getUserEvents();
        $res = array_merge($res, $userEvent);
        echo json_encode(array('status' => 'success', 'res' => $res, 'clndr_ttl' => 'current_c_title'));
    }

    public function getUserEvents()
    {
        $type = Request::input('type');
        if ($type == 'fetch')
        {
            //$events = events:: where('cid', 2 );
            //$events = events::all();
            //die(var_dump($events));
            //DB::enableQueryLog();
            $events = DB::table('hamahang_calendar_user_events')
                ->select('hamahang_calendar_user_events.*')
                ->where('hamahang_calendar_user_events.cid', '=', session('current_c'));
            $x = $events->get();
            $e = array();
            $res = array();
            foreach ($x as $fetch)
            {
                $e = array();
                $e['id'] = $fetch->id;
                // die($e['id']);
                $e['title'] = $fetch->title;
                $e['start'] = $fetch->startdate;
                $e['end'] = $fetch->enddate;

                $allday = ($fetch->allDay == "true") ? true : false;
                $e['className'] = 'personal_event';
                $e['allDay'] = $allday;
                switch ($fetch->type)
                {
                    case(1):
                        $e['color'] = 'red';
                        break;
                    case(2):
                        $e['color'] = 'green';
                        break;
                    case(3):
                        $e['color'] = 'blue';
                        break;
                    case(4):
                        $e['color'] = 'pink';
                        break;
                    case(5):
                        $e['color'] = 'graytext';
                        break;
                }
                array_push($res, $e);
            }
        }
        if ($type == 'fetch_especial')
        {
            $events = DB::table('hamahang_calendar_user_events')
                ->select('hamahang_calendar_user_events.*')
                ->where('event.cid', '=', Session::get('current_c'));
            $x = $events->get();
            //die(var_dump($events));
            $e = array();
            $res = array();
            foreach ($x as $fetch)
            {
                //die(var_dump($fetch));
                $e = array();
                $e['id'] = $fetch->id;
                // die($e['id']);
                $e['title'] = $fetch->title;
                $e['start'] = $fetch->startdate;
                $e['end'] = $fetch->enddate;
                $e['className'] = 'personal_event';
                $allday = ($fetch->allDay == "true") ? true : false;
                $e['allDay'] = $allday;
                switch ($fetch->type)
                {
                    case(1):
                        $e['color'] = 'red';
                        break;
                    case(2):
                        $e['color'] = 'green';
                        break;
                    case(3):
                        $e['color'] = 'blue';
                        break;
                    case(4):
                        $e['color'] = 'pink';
                        break;
                    case(5):
                        $e['color'] = 'graytext';
                        break;
                }
                array_push($res, $e);
            }
        }
        return $res;
    }

    public function oghatSharee($cit_id)
    {
        $cityObj = new ProvinceCityController();
        $coordinates = $cityObj->getCoordinate($cit_id);
        $ogObj = new OghatSharei();
        date_default_timezone_set('Asia/Tehran');
        $jDate = new jDate;
        $gNow = explode('-', date('Y-m-d'));
        $jNow = $jDate->Gregorian_to_Jalali($gNow[0], $gNow[1], $gNow[2]);
        // var_dump($coordinates);exit;
        $list = $ogObj->owghat($jNow[1], $jNow[2], $coordinates['lng'], $coordinates['lat']);
        return json_encode($list);
    }

    public function personalEventSearch()
    {
        //$searchStr = Request::input('searchStr');
        // if($searchStr)
        // {
        //var_dump($searchStr);die();
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        DB::enableQueryLog();
        $calendars = DB::table('hamahang_calendar')
            ->select('id', 'title')
            ->where([
                ['hamahang_calendar.user_id', '=', $uid],
            ])->get();
        // die( dd(DB::getQueryLog()));
        // }
        return json_encode($calendars);
    }

    public function getAllUsers()
    {
        $users = User::all('id', 'Uname')->toJson();
        return $users;
    }

    public function getOwnCalendar()
    {
        $uid = Auth::id();
        //DB::enableQueryLog();
        $createCalendar = Calendar::select('id', 'title')->where('user_id', '=', $uid)->get()->toArray();
        $accessCalendar = DB::table('hamahang_calendar')
            ->select('hamahang_calendar.id', 'hamahang_calendar.title')
            ->join('hamahang_calendar_permission', 'hamahang_calendar.user_id', '=', 'hamahang_calendar_permission.uid')
            ->where('hamahang_calendar.user_id', '=', $uid)
            ->groupBy('hamahang_calendar.id')
            ->get()->toArray();
        return json_encode(array_merge($createCalendar, $accessCalendar));
    }

    public function addNewCalendar()
    {
        // $params = Request::();
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $validator = \Validator::make(Request::all(), [
            'title' => 'required',
            'calander_type' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $calendar = new Calendar();
            $calendar->title = Request::input('title');
            $calendar->type = Request::input('calander_type');
            $calendar->is_default = Request::input('is_default');
            $calendar->prayer_times = Request::input('description');
            $calendar->prayer_time_province = Request::input('description');
            $calendar->prayer_time_city = Request::input('description');
            if (Request::exists('beginning_day'))
                $calendar->beginning_day = Request::input('beginning_day');
            if (Request::exists('prayer_times'))
                $calendar->prayer_poss = Request::input('prayer_times');
            if (Request::exists('monasebat'))
                $calendar->show_events = 1;
            if (Request::exists('prayer_times'))
                $calendar->show_prayer = 1;
            if (Request::exists('brith_day'))
                $calendar->show_birthday = 1;
            $calendar->description = Request::input('description');
            $calendar->user_id = $uid;
            $calendar->uid = $uid;

        }
        if ($calendar->save())
        {
            if ($calendar->is_default)
            {
                $this->setDefaultCalendar($calendar->id);
            }
            if (Request::exists('viewPermissions'))
            {
                foreach (Request::input('viewPermissions') as $value_user_id)
                {
                    $Calendar_Permission = new Calendar_Permission();
                    $Calendar_Permission->uid = $uid;
                    $Calendar_Permission->user_id = $value_user_id;
                    $Calendar_Permission->calendar_id = $calendar->id;
                    $Calendar_Permission->access = 'view';
                    $Calendar_Permission->save();
                }
            }
            if (Request::exists('editPermissions'))
            {
                foreach (Request::input('editPermissions') as $value_user_id)
                {
                    $Calendar_Permission = new Calendar_Permission();
                    $Calendar_Permission->uid = $uid;
                    $Calendar_Permission->user_id = $value_user_id;
                    $Calendar_Permission->calendar_id = $calendar->id;
                    $Calendar_Permission->access = 'edit';
                    $Calendar_Permission->save();
                }
            }
            if (Request::exists('hidden_from'))
            {
                foreach (Request::input('hidden_from') as $key => $hidden_from)
                {
                    $Calendar_Hiddentimes = new Calendar_Hiddentimes();
                    $Calendar_Hiddentimes->uid = $uid;
                    $Calendar_Hiddentimes->calendar_id = $calendar->id;
                    $Calendar_Hiddentimes->time_from = $hidden_from;
                    $Calendar_Hiddentimes->time_to = Request::input('hidden_to')[$key];
                    $Calendar_Hiddentimes->save();
                }
            }
            if (Request::exists('sharing_calendar_list'))
            {
                foreach (Request::input('sharing_calendar_list') as $key => $sharing_calendar)
                {
                    $Calendar_Hiddentimes = new Calendar_Sharing();
                    $Calendar_Hiddentimes->uid = $uid;
                    $Calendar_Hiddentimes->calendar_share_to = $calendar->id;
                    $Calendar_Hiddentimes->calendar_share_of = $sharing_calendar;
                    $Calendar_Hiddentimes->type = Request::input('sharing_type')[$key];
                    $Calendar_Hiddentimes->color = Request::input('sharing-color')[$key];
                    $Calendar_Hiddentimes->save();
                }
            }
            return json_encode(['success'=>true, 'id' => $calendar->id, 'sowConfig' => Request::input('showConfig')]);
        }
        else
        {
            $result['error'] = ['خطایی روی داده است'];
            $result['success'] = false;
            return json_encode($result);
        }
    }

    public function getCalendarInfo()
    {
        $id = Request::input('id');
        $info = Calendar::find($id);
        $info->sharing_options = unserialize($info->sharing_options);
        $info->default_options = unserialize($info->default_options);
        $hiddenTimes = Calendar_Hiddentimes::where('calendar_id', '=', $id)->orderBy('id', 'DESC')->get();
        // DB::enableQueryLog();
        $permission = Calendar_Permission::where('calendar_id', '=', $id)->whereNull('deleted_at')->get();
        //dd(DB::getQueryLog());
        foreach ($permission as $k => $p)
        {
            $user = User::select('Uname')->where('id', '=', $p['user_id'])->first();
            $permission[$k]['uname'] = $user->Uname;
        }
        $sharing = DB::table('hamahang_calendar')->select('hamahang_calendar.id', 'hamahang_calendar.title', 'hamahang_calendar.description')
            ->join('hamahang_calendar_sharing_events', 'hamahang_calendar.id', 'hamahang_calendar_sharing_events.calendar_share_of')
            ->where('hamahang_calendar_sharing_events.calendar_share_to', '=', $id)
            ->whereNull('hamahang_calendar_sharing_events.deleted_at')->get();
        return array('calendar' => $info, 'hiddenTimes' => $hiddenTimes, 'permissions' => $permission, 'sharings' => $sharing);
    }

    public function getPermissionCalendar()
    {
        $cid = Request::input('id');
        $permission = Calendar_Permission::where('calendar_id', '=', $cid)->get();
        foreach ($permission as $k => $p)
        {
            $user = User::select('Uname')->where('id', '=', $p['uid'])->first();
            $permission[$k]['uname'] = $user->Uname;
        }
        return json_encode($permission);
    }

    public function setDefaultCalendar($id)
    {
        //  dd($id);
        DB::enableQueryLog();
        DB::table('hamahang_calendar')
            ->where('id', '!=', $id)
            ->update(array('is_default' => 0));
        //die(dd(DB::getQueryLog()));
    }

    public function editSave()
    {
        $id = intval(Request::input('id'));
        $uid = Auth::id();
        $validator = \Validator::make(Request::all(), [
            'htitle' => 'required',
            'htype' => 'required|in:1,2,3',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $calendar = Calendar::find($id);
            $calendar->title = Request::input('htitle');
            $calendar->uid = $uid;
            $calendar->type = Request::input('htype');
            $calendar->is_default = Request::input('his_default');
            $calendar->description = Request::input('hdescriotion');
            $calendar->user_id = $uid;
            $calendar->uid = $uid;
            $calendar->prayer_times = Request::input('hprayer_times');
            $calendar->prayer_time_province = Request::input('hprovince');
            $calendar->prayer_time_city = Request::input('hcity');
            $calendar->beginning_day = Request::input('hbeginning_day');
            $calendar->monasebat = Request::input('hmonasebat');
            $calendar->birth_day = Request::input('hbrith_day');
            $calendar->default_options = serialize(Request::input('default_options'));
            $calendarSave = $calendar->save();
            if ($calendarSave)
            {
                if ($calendar->is_default)
                {
                    $this->setDefaultCalendar($calendar->id);
                }
                // if(Request::input('hbeginning_day')== 3)
                // {
                // dd('hhhhh');
                if (Request::input('hhidden_from') && Request::input('hhidden_to'))
                {
                    // DB::enableQueryLog();
                    Calendar_Hiddentimes::where('calendar_id', '=', Request::input('id'))->delete();
                    //die(dd(DB::getQueryLog()));
                    $froms = explode(',', Request::input('hhidden_from'));
                    $to = explode(',', Request::input('hhidden_to'));
                    foreach ($froms as $k => $f)
                    {
                        if ($to[$k] != '')
                        {
                            $CalendarHidden = new Calendar_Hiddentimes();
                            $CalendarHidden->uid = $uid;
                            $CalendarHidden->time_from = $f;
                            $CalendarHidden->time_to = $to[$k];
                            $CalendarHidden->calendar_id = $id;
                            $CalendarHidden->save();
                        }
                    }
                }
                //}
                //dd(Request::input('hviewPermissions'));
                if (Request::input('hviewPermissions') != '')
                {
                    Calendar_Permission::where('calendar_id', '=', $id)->where('access', '=', '001')->delete();
                    $viwArr = explode(',', Request::input('hviewPermissions'));

                    foreach ($viwArr as $v)
                    {
                        $permissionObj = new Calendar_Permission();
                        $permissionObj->uid = Auth::id();
                        $permissionObj->user_id = $v;
                        $permissionObj->access = '001';
                        $permissionObj->calendar_id = $id;
                        $permissionObj->save();
                        // dd($permissionObj->save());
                    }

                }
                if (Request::input('heditPermissions') != '')
                {
                    Calendar_Permission::where('calendar_id', '=', $id)->where('access', '=', '011')->delete();
                    $editArr = explode(',', Request::input('heditPermissions'));
                    //  dd($editArr);
                    foreach ($editArr as $e)
                    {
                        $permissionObj = new Calendar_Permission();
                        $permissionObj->uid = Auth::id();
                        $permissionObj->user_id = $e;
                        $permissionObj->access = '011';
                        $permissionObj->calendar_id = $id;
                        ///  dd($permissionObj->save());
                        $permissionObj->save();
                    }
                }
                //dd(Request::input('hsharing_calendars'));
                if (Request::input('hsharing_calendars') != '')
                {
                    $sharing_calendars = Request::input('hsharing_calendars');
                    if (count($sharing_calendars) > 0)
                    {
                        $sharing_calendarsArr = array_keys(get_object_vars(json_decode($sharing_calendars)));
                    }
                    $sharObj = new Calendar_Sharing();
                    Calendar_Sharing::where('calendar_share_to', '=', $id)->delete();
                    //dd($sharing_calendarsArr);
                    foreach ($sharing_calendarsArr as $a)
                    {
                        //dd($a);
                        $sharObj = new Calendar_Sharing();
                        $sharObj->calendar_share_of = (int)$a;
                        $sharObj->calendar_share_to = $id;
                        $sharObj->uid = $uid;
                        $sharObj->save();
                    }
                    $calendar = Calendar::find($id);
                    $calendar->sharing_options = serialize($sharing_calendars);
                    $calendar->save();
                }
                return json_encode(array('success' => true));
            }
        }
    }

    public function getUserCalendar()
    {
        $calendar = Calendar::getUserCalendar();
        return json_encode($calendar);
    }

    public function deleteCalendar()
    {
        $cid = Request::input('cid');
        $calendar = Calendar::find($cid);
        $delete = DB::transaction(function ()
        {
            Calendar::find(Request::input('cid'))->delete();
            Calendar_Hiddentimes::where('calendar_id', '=', Request::input('cid'))->delete();
            Calendar_Permission::where('calendar_id', '=', Request::input('cid'))->delete();
            Calendar_Sharing::where('calendar_share_of', '=', Request::input('cid'))->delete();
        });
        //die(dd($delete));
        if ($delete == null)
        {
            return json_encode(array('success' => true, 'title' => $calendar->title));
        }
        else
        {
            return json_encode(array('success' => false));
        }
    }

    public function getSeansonEvents()
    {
        $seasonEvents = Calendar::getEventsBetWeen(Request::input('cid'), 'seanson', Request::input('selected'));
        return json_encode($seasonEvents);
    }

    public function sixMonthEvents()
    {
        $sixMonthsEvents = Calendar::getEventsBetWeen(Request::input('cid'), 'sixMonth', Request::input('selected'));
        return json_encode($sixMonthsEvents);
    }

    public function yearEvents()
    {
        $yearEvents = Calendar::getEventsBetWeen(Request::input('cid'), 'year');
        return json_encode($yearEvents);
    }

    function defaultEvents()
    {
        $jDate = new jDateTime();
        $calendar = Calendar::select('id', 'title', 'default_options', 'sharing_options')
            ->where('is_default', '=', 1)
            ->where('uid', '=', Auth::id())
            ->firstOrFail()
            ->toArray();
        $cid = $calendar['id'];
        $defaultoption = '';
        if ($calendar['default_options'] != '')
        {
            $defaultoption = unserialize($calendar['default_options']);
        }
        $sharing_options = '';
        if ($calendar['sharing_options'] > 0)
        {
            $sharing_options = unserialize($calendar['sharing_options']);
        }
        $persianIN = array();
        if ($defaultoption != '')
        {
            foreach ($defaultoption as $k => $op)
            {//dd($op);
                switch ($k)
                {
                    case $k == 'jalali' && $op['checked'] == 1:
                    {
                        $persianIN[] = 'PersianCalendar';
                        break;
                    }
                    case $k == 'gergorian' && $op['checked'] == 1:
                    {
                        $persianIN[] = 'ObservedHijriCalendar';
                        break;
                    }
                    case $k == 'ghamari' && $op['checked'] == 1:
                    {
                        $persianIN[] = 'GregorianCalendar';
                        break;
                    }
                    case $k == 'event' && $op['checked'] == 1:
                    {
                        $eventtype[] = 0;
                        break;
                    }
                    case $k == 'session' && $op['checked'] == 1:
                    {
                        $eventtype[] = 1;
                        break;
                    }
                    case $k == 'invitation' && $op['checked'] == 1:
                    {
                        $eventtype[] = 2;
                        break;
                    }
                    case $k == 'reminder' && $op['checked'] == 1:
                    {
                        $eventtype[] = 3;
                        break;
                    }
                }
            }
        }
        //  DB::enableQueryLog();
        $historical_events = DB::table('hamahang_calendar_persian_events')
            ->select('id', 'Description', 'Month', 'type', 'Day', 'Year')
            ->whereIn('type', $persianIN)
            ->get();
        //dd(DB::getQueryLog());
        foreach ($historical_events as $h)
        {
            $h->start = implode('-', $jDate->Jalali_to_Gregorian($h->Year, $h->Month, $h->Day));
            $h->end = implode('-', $jDate->Jalali_to_Gregorian($h->Year, $h->Month, $h->Day));
            $h->title = $h->Description;
            //if(strtotime($betweenDayFirst) < strtotime($h->start) && strtotime($h->start) <= strtotime($lastDayOfMonth[2]))
            //{
            $color = '';
            switch ($h->type)
            {
                case 'PersianCalendar':
                {
                    $color = isset($defaultoption['jalali']['color']) ? $defaultoption['jalali']['color'] : '';
                    break;
                }
                case 'GregorianCalendar':
                {
                    $color = isset($defaultoption['gergorian']['color']) ? $defaultoption['gergorian']['color'] : '';
                    break;
                }
                case 'ObservedHijriCalendar':
                {
                    $color = isset($defaultoption['ghamari']['color']) ? $defaultoption['ghamari']['color'] : '';
                    break;
                }
            }
            $h->color = $color;
            $eventArr[] = $h;
            // }
        }
        if (isset($defaultoption['vacation']) && $defaultoption['vacation']['checked'] == 1)
        {
            $vacation_events = DB::table('hamahang_calendar_persian_events')
                ->select('id', 'Description', 'Month', 'type', 'Day', 'Year')
                ->where('IsVacation', '=', 1)
                ->get();
            foreach ($vacation_events as $v)
            {
                $v->start = implode('-', $jDate->Jalali_to_Gregorian($v->Year, $v->Month, $v->Day));
                $v->end = implode('-', $jDate->Jalali_to_Gregorian($v->Year, $v->Month, $v->Day));
                $v->title = $h->Description;
                // if (strtotime($betweenDayFirst) < strtotime($v->start) &&  strtotime($v->start) <= strtotime($lastDayOfMonth[2]))
                //{
                $v->color = isset($defaultoption['vacation']['color']) ? $defaultoption['vacation']['color'] : '';
                $eventArr[] = $v;
                // }
            }
        }
        if (isset($eventtype) && count($eventtype) > 0)
        {
            $type_events = DB::table('hamahang_calendar_user_events as eventTable')
                ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate as start', 'eventTable.enddate as end', 'eventTable.type')
                ->where('eventTable.cid', '=', $cid)
                ->whereIn('eventTable.type', $eventtype)
                ->get();
            foreach ($type_events as $event)
            {
                $gArr = explode('-', $event->start);

                $jstartDate = $jDate->Gregorian_to_Jalali($gArr[0], $gArr[1], $gArr[2]);
                $color = '';
                switch ($event->type)
                {
                    case 0:
                    {
                        $color = isset($defaultoption['event']['color']) ? $defaultoption['event']['color'] : '';
                        break;
                    }
                    case 1:
                    {
                        $color = isset($defaultoption['session']['color']) ? $defaultoption['session']['color'] : '';
                        break;
                    }
                    case 2:
                    {
                        $color = isset($defaultoption['invitation']['color']) ? $defaultoption['invitation']['color'] : '';
                        break;
                    }
                    case 3:
                    {
                        $color = isset($defaultoption['reminder']['color']) ? $defaultoption['reminder']['color'] : '';
                        break;
                    }
                }
                // dd($color);
                $event->color = $color;

                $eventArr[] = $event;
                if (strtotime($event->end) - strtotime($event->start) > 86400)
                {
                    $begin = new \DateTime($event->start);
                    $endDay = new \DateTime($event->end);

                    $interval = \DateInterval::createFromDateString('1 day');
                    $period = new \DatePeriod($begin, $interval, $endDay);
                    foreach ($period as $dt)
                    {
                        //die(dd($dt->format('Y-m-d'),$event->startdate));
                        $dateArr = explode('-', $dt->format('Y-m-d'));
                        $jMiddleDate = $jDate->Gregorian_to_Jalali($dateArr[0], $dateArr[1], $dateArr[2]);
                        $eventArr[] = $event;
                    }
                }
            }
        }
        //dd($seasonEvents);
        $sharing_events = DB::table('hamahang_calendar_user_events as eventTable')
            ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate as start', 'eventTable.enddate as end', 'shareTable.calendar_share_of AS sharId')
            ->join('hamahang_calendar_sharing_events as shareTable', 'eventTable.cid', 'shareTable.calendar_share_to')
            ->where('eventTable.cid', '=', $cid)
            ->get();
        foreach ($sharing_events as $event)
        {
            $gArr = explode('-', $event->start);
            $jstartDate = $jDate->Gregorian_to_Jalali($gArr[0], $gArr[1], $gArr[2]);
            $color = '';
            $color = isset($sharing_options[$event->sharId]) ? $sharing_options[$event->sharId]['color'] : '';
            $event->color = $color;
            $eventArr[] = $event;
            if (strtotime($event->end) - strtotime($event->start) > 86400)
            {
                $begin = new \DateTime($event->start);
                $endDay = new \DateTime($event->end);
                $interval = \DateInterval::createFromDateString('1 day');
                $period = new \DatePeriod($begin, $interval, $endDay);
                foreach ($period as $dt)
                {
                    //die(dd($dt->format('Y-m-d'),$event->startdate));
                    $dateArr = explode('-', $dt->format('Y-m-d'));
                    $jMiddleDate = $jDate->Gregorian_to_Jalali($dateArr[0], $dateArr[1], $dateArr[2]);
                    $eventArr[] = $event;
                }
            }
        }
        return json_encode(array('events' => $eventArr, 'calendarInfo' => $calendar));
    }

    public function updateCalendarSetting()
    {
        $options = json_decode(Request::input('option'), true);
        $calendar = Calendar::find($options['cid']);
        $calendar->default_options = serialize($options['defaultOptions']);
        $calendar->sharing_options = serialize($options['sharingOptions']);
        if ($calendar->save())
        {
            return json_encode(array('success' => true, 'title' => $calendar->title, 'cid' => $calendar->id));
        }
        else
        {
            return '';
        }
    }

    public function personalCalendar()
    {
        $calendars = Calendar::select('id', 'title', 'is_default')->where('hamahang_calendar.user_id', '=', auth()->id())->orderBy('is_default');
        return Datatables::eloquent($calendars)->make(true);
    }

    public function newCalendar()
    {
        return json_encode([
            'header' => trans('calendar.modal_calendar_ header_title'),
            'content' => view('hamahang.Calendar.helper.Index.modals.modal_calendar_add')->render(),
            'footer' => view('hamahang.Calendar.helper.Index.modals.modal_buttons')->with('btn_type', 'newCalendar')->render()
        ]);
    }

    public function editCalendar()
    {
        $info = $this->getCalendarInfo();
        return json_encode([
            'header' => trans('calendar.modal_calendar_edit_header_title') . ' : ' . $info['calendar']->title,
            'content' => view('hamahang.Calendar.helper.Index.modals.modal_calendar_edit')->render(),
            'footer' => view('hamahang.Calendar.helper.Index.modals.modal_buttons')->with('btn_type', 'editCalendar')->render(),
            'info' => $info
        ]);
    }
}