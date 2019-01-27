<?php
namespace App\Http\Controllers\Hamahang;

use App\Models\hamafza\Pages;
use DB;
use Auth;
use Request;
use Datatables;
use App\User;
use App\Models\Hamahang\Calendar\Calendar;
use App\Models\Hamahang\CalendarEvents\User_Event;
use App\Models\Hamahang\CalendarEvents\Session_Events;
use App\Models\Hamahang\CalendarEvents\Event_Reminder;
use App\Models\Hamahang\CalendarEvents\Invitation_Events;
use App\Models\Hamahang\CalendarEvents\Event_Invitees;
use App\Models\Hamahang\CalendarEvents\Events_Files;
use App\Models\Hamahang\CalendarEvents\Sessions_Decisions;
use App\Models\Hamahang\CalendarEvents\Events_Tasks;
use App\Models\Hamahang\CalendarEvents\Decisions_Tasks;
use App\Models\Hamahang\CalendarEvents\Session_Guest;
use App\Models\Hamahang\Tasks\tasks;
use App\Models\Hamahang\Tasks\task_assignments;
use App\Models\Hamahang\Tasks\task_status;
use App\Models\Hamahang\Tasks\task_staffs;
use App\Models\Hamahang\CalendarEvents\Events;
use App\Models\Hamahang\CalendarEvents\Persian_Event;
use App\Models\Hamahang\Tasks\task_packages;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Support\Facades\Session;
use App\HamafzaViewClasses\TaskClass;
use App\HamafzaViewClasses\DesktopClass;
use App\Http\Controllers\Controller;
use App\HamahangCustomClasses\EncryptString;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\FileManager\FileMimeTypes;
class CalendarEventsController extends Controller
{
    public function index($username)
    {
//        can('calendar_events_manager_view');
        $arr = variable_generator('user','desktop',$username);
        $arr['HFM_CalendarEvent'] = HFM_GenerateUploadForm([['CalendarEvent', ['doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'], 'Multi']]);
        /* foreach ($events as $index=>$event)
         {
             switch ($event['type'])
             {
                 case 0:
                     $events[$index]['type']='رویداد';
                     break;
                 case 1:
                     $events[$index]['type'] ='جلسه';
                     break;
                 case 2:
                     $events[$index]['type']='دعوتنامه';
                 break;
                 case 3:
                     $events[$index]['type']='یادآوری';
                 break;


             }

         }*/
        return view('hamahang.CalendarEvents.index', $arr);
    }

    public function saveSelectedTaskEvent()
    {
        dd('asdad');
        $validator = \Validator::make(Request::all(), [
            'title' => 'required|string',
            'cid' => 'required|integer',
            'startdate' => 'required',
            'starttime' => 'required',
            'enddate' => 'required',
            'enddate' => 'required'
        ]);
        //DB::enableQueryLog();
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        if (Request::input('event_id') && Request::input('mode') == 'edit')
        {
            $userEvent = User_Event::find(Request::input('event_id'));
        }
        else
        {
            $userEvent = new User_Event();
        }
        $uid = Auth::id();
        $type = Request::input('type') ? Request::input('type') : 0;
        $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
//            dd(Request::all());
        $jdate = new jDateTime();
        $userEvent->uid = $uid;
        $userEvent->title = Request::input('title');
        $userEvent->allDay = Request::input('allDay');
        $startdate = explode('-', Request::input('startdate'));
//            dd(Request::input('event_startdate'));
        if (Request::input('allDay') == 1)
        {
            $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' 00:00:00';
        }
        else
        {
            $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . Request::input('starttime');
        }

        //die(dd($startdate));

        $enddate = explode('-', Request::input('enddate'));
        if (Request::input('allDay') == 1)
        {
            $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' 00:00:00';
        }
        else
        {
            $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . Request::input('endtime');
        }
        $userEvent->description = Request::input('description');
        $userEvent->type = $type;
        $userEvent->event_type = $event_type;
        $userEvent->cid = Request::input('event_cid');
        //die(dd(DB::getQueryLog()));
        if ($userEvent->save())
        {
            $final_result = ['success' => true, 'event' => $userEvent, 'mode' => 'calendar'];
        }

        foreach (Request::input('multiTaskTime') as $taskid)
        {
            $eventTask = new Events_Tasks();
            $eventTask->uid = $uid;
            $eventTask->task_id = $taskid;
            $eventTask->event_id = $userEvent->id;
            $eventTask->save();
        }

        return json_encode($final_result);
    }
    public function saveUserEvent()
    {
        $uid = Auth::id();
//        dd(Request::all());
        $type = Request::input('type') ? Request::input('type') : 0;
        $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
        // die(dd(Request::input('type')));
        $jdate = new jDateTime();
        $validator = \Validator::make(Request::all(), [
            'htitle' => 'required|string',
            'hcid' => 'required|integer'
//            ,
//            'hstartdate' => 'required'
//            ,
//            'henddate' => 'required'
        ]);
        //DB::enableQueryLog();
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (Request::input('event_id') && Request::input('mode') == 'edit')
            {
                $userEvent = User_Event::find(Request::input('event_id'));

            }
            else
            {
                $userEvent = new User_Event();
            }
            if(Request::input('save_type')==0){
                $userEvent->uid = $uid;
                $userEvent->title = Request::input('htitle');
                $userEvent->allDay = Request::input('allDay');
                $userEvent->form_data = serialize(Request::all());
                $userEvent->description = Request::input('description');
                $userEvent->type = $type;
                $userEvent->is_draft = 1;
                $userEvent->event_type = $event_type;
                $userEvent->cid = Request::input('hcid');
                $in_day = Request::input('in_day');
                $firstTyp_term = Request::input('firstTyp_term');
                $startdate = explode('-', $in_day[0]['value']);
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . $firstTyp_term[0]['value'].':00';
                $enddate = explode('-', $in_day[0]['value']);
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . $firstTyp_term[0]['value'].':00';

                if ($userEvent->save())
                {
                    //die(dd(Request::input('mode')));
                    if (Request::input('mode') == 'edit')
                    {
                        return json_encode(array('success' => true, 'event_id' => $userEvent->id, 'mode' => 'edit', 'type' => $userEvent->type));
                    }
                    else
                    {
                        if (Request::input('mode') == 'calendar')
                        {
                            return json_encode(array('success' => true, 'event' => $userEvent, 'mode' => 'calendar'));

                        }
                        else
                        {
                            return json_encode(array('success' => true, 'event_id' => $userEvent->id));
                        }
                    }

                }
                else
                {
                    return json_encode(array('success' => false));
                }
            }else{
                if (Request::input('event_id') && Request::input('mode') == 'edit')
                {
                    $userEvent = User_Event::find(Request::input('event_id'));
                }
                else
                {
                    $userEvent = new User_Event();
                }
                $userEvent->uid = $uid;
                $userEvent->title = Request::input('htitle');
                $userEvent->allDay = Request::input('allDay');
                $userEvent->form_data = serialize(Request::all());
                $userEvent->description = Request::input('description');
                $userEvent->type = $type;
                $userEvent->event_type = $event_type;
                $userEvent->is_draft = 0;
                $userEvent->cid = Request::input('hcid');
                $in_day = Request::input('in_day');
                $firstTyp_term = Request::input('firstTyp_term');
                $startdate = explode('-', $in_day[0]['value']);
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . $firstTyp_term[0]['value'].':00';
                $enddate = explode('-', $in_day[0]['value']);
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . $firstTyp_term[0]['value'].':00';
                if($userEvent->save()){
                    foreach(Request::input('in_day') as $key=>$Ain_day)
                    {
                        $reminderObj = new Event_Reminder();
                        $startdate = explode('-', $Ain_day['value']);
                        $reminderObj->remind_time = strtotime($jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-'). ' ' . $firstTyp_term[0]['value'].':00');
                        $reminderObj->remind_date = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . $firstTyp_term[$key]['value'].':00';
                        $reminderObj->form_data = serialize(Request::all());
                        $reminderObj->event_id = $userEvent->id;
                        $reminderObj->time = $firstTyp_term[$key]['value'].':00';
//                    $reminderObj->type = $ft['type'];
//                    $reminderObj->notification = $ft['notification'];
//                    $reminderObj->in_events = $ft['in_event'];
//                    $reminderObj->sms = $ft['sms'];
//                    $reminderObj->email = $ft['email'];

                        if(!$reminderObj->save())
                            return json_encode(array('success' => false));
                    }
                    return json_encode(array('success' => true, 'event_id' => $userEvent->id));
                }else{
                    return json_encode(array('success' => false));
                }

            }
//            $userEvent->uid = $uid;
//            $userEvent->title = Request::input('htitle');
//            $userEvent->allDay = Request::input('allDay');
//            $startdate = explode('-', Request::input('hstartdate'));
//            if (Request::input('allDay') == 1)
//            {
//                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' 00:00:00';
//            }
//            else
//            {
//                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . Request::input('starttime');
//            }
//
//            //die(dd($startdate));
//
//            $enddate = explode('-', Request::input('henddate'));
//            if (Request::input('allDay') == 1)
//            {
//                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' 00:00:00';
//            }
//            else
//            {
//                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . Request::input('endtime');
//            }
//            $userEvent->description = Request::input('description');
//            $userEvent->type = $type;
//            $userEvent->event_type = $event_type;
//            $userEvent->cid = Request::input('hcid');
//
//            //die(dd(DB::getQueryLog()));
//            if ($userEvent->save())
//            {
//                //die(dd(Request::input('mode')));
//                if (Request::input('mode') == 'edit')
//                {
//                    return json_encode(array('success' => true, 'event_id' => $userEvent->id, 'mode' => 'edit', 'type' => $userEvent->type));
//                }
//                else
//                {
//                    if (Request::input('mode') == 'calendar')
//                    {
//                        return json_encode(array('success' => true, 'event' => $userEvent, 'mode' => 'calendar'));
//
//                    }
//                    else
//                    {
//                        return json_encode(array('success' => true, 'event_id' => $userEvent->id));
//                    }
//                }
//
//            }
//            else
//            {
//                return json_encode(array('success' => false));
//            }
        }
    }

    public function saveMultiTaskEvent()
    {
        $uid = Auth::id();
        $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
        $validator = \Validator::make(Request::all(), [
            'task_id' => 'required',
            'hcid' => 'required|integer',
            'hstartdate' => 'required',
            'henddate' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $tasks = DB::table('hamahang_task')
                ->select('hamahang_task.title','hamahang_task.id')
                ->whereIn('hamahang_task.id', Request::input('task_id'))
                ->get();
            foreach($tasks as $Atask){
                $info['uid'] = $uid;
                $info['htitle'] = $Atask->title;
                $info['task_id'] = $Atask->id;
                $info['hstartdate'] = Request::input('hstartdate');
                $info['henddate'] = Request::input('henddate');
                $info['event_type'] = "task";
                $info['hcid'] = Request::input('hcid');
                $this->saveTaskEvent($info);
                $allInfo[] = $info;
            }
            return json_encode($allInfo);

        }

    }
    public function deleteTaskEvent()
    {
        $uid = Auth::id();
        $ctid = deCode(Request::input('ctid'));
        $ce = deCode(Request::input('ce'));
        User_Event::where('id','=',$ce)->where('uid','=',$uid)->delete();
        Events_Tasks::where('id','=',$ctid)->where('uid','=',$uid)->delete();
        return json_encode(array('success' => true));
    }
    public function saveTaskEvent($info = [])
    {
        $uid = Auth::id();
        $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
        $validator = \Validator::make(Request::all(), [
            'hstartdate' => 'required',
            'henddate' => 'required'
        ]);
        if ($validator->fails() && count($info) == 0)
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if(Request::input('hcid') == ''){
                $Calendar = Calendar::Where('uid','=',$uid)->Where('is_default','=',1)->whereNull('deleted_at')->first();
                if(!$Calendar){
                    $Calendar = Calendar::CreateCalendar();
                }
                $hcid = $Calendar->id;
            }else{
                $hcid = Request::input('hcid');
            }
            if (Request::input('event_id') && Request::input('mode') == 'edit')
            {
                $userEvent = User_Event::find(Request::input('event_id'));
            }
            else
            {
                $userEvent = new User_Event();
            }
            $userEvent->uid = isset($info['uid']) ? $info['uid'] : $uid;
            $userEvent->title = isset($info['htitle']) ? $info['htitle'] : Request::input('htitle');
            $userEvent->allDay = isset($info['allDay']) ? $info['allDay'] : Request::input('allDay');
            $userEvent->startdate = isset($info['startdate']) ? $info['startdate'] : Request::input('hstartdate');
            $userEvent->enddate = isset($info['enddate']) ? $info['enddate'] : Request::input('henddate');
            $userEvent->description = isset($info['description']) ? $info['description'] : Request::input('description');
            $userEvent->type = isset($info['type']) ? $info['type'] : Request::input('type') ? Request::input('type') : 0;
            $userEvent->event_type = isset($info['event_type']) ? $info['event_type'] : $event_type;
            $userEvent->cid = isset($info['hcid']) ? $info['hcid'] : $hcid;

            if ($userEvent->save())
            {
                if (Request::input('mode') == 'edit')
                {
                    $taskObj  = Events_Tasks::where('event_id', '=', $userEvent->event_type)->firstOrFail();
                }
                else
                {
                    $taskObj = new Events_Tasks();
                }
                $taskObj ->uid = $uid;
                $taskObj->event_id = $userEvent->id;
                $taskObj->task_id = Request::input('task_id') ? (is_numeric(Request::input('task_id')) ? Request::input('task_id') : deCode(Request::input('task_id'))) : $info['task_id'];
                if ($taskObj->save())
                {
                    task_status::create_task_status($taskObj->task_id, 1, 0);

                    if (Request::input('mode') == 'edit')
                    {
                        return json_encode(array('success' => true, 'mode' => 'edit'));
                    }
                    else
                    {
                        if (Request::input('mode') == 'calendar')
                        {
                            $event = $this->getEventById($userEvent->id);
                            return json_encode(array('success' => true, 'event' => $event, 'mode' => 'calendar'));

                        }
                        else
                        {
                            return json_encode(array('success' => true));
                        }
                    }
                }
            }
            else
            {
                return json_encode(array('success' => false));
            }
        }
    }

    public function saveSessionEvent()
    {
        $uid = Auth::id();
//        dd(Request::all());
        $type = Request::input('type') ? Request::input('type') : 0;
        $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
        // die(dd(Request::input('type')));
        $jdate = new jDateTime();
        $validator = \Validator::make(Request::all(), [
            'htitle' => 'required|string',
            'hcid' => 'required|integer',
            'hstartdate' => 'required',
            'henddate' => 'required',

            'hagenda' => 'required|string',
//            'hevent_id' => 'required|integer',
            'hlocation' => 'required',
            'session_voting_users' => 'required_without:session_notvoting_users',
            'session_notvoting_users' => 'required_without:session_voting_users',
        ]);
        //DB::enableQueryLog();
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if(Request::input('save_type')==0)
            {
                $userEvent = new User_Event();
                $userEvent->uid = $uid;
                $userEvent->title = Request::input('htitle');
                $userEvent->allDay = Request::input('allDay');
                $startdate = explode('-', Request::input('hstartdate'));
                if (Request::input('allDay') == 1)
                {
                    $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' 00:00:00';
                }
                else
                {
                    $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . Request::input('starttime');
                }


                $enddate = explode('-', Request::input('henddate'));
                if (Request::input('allDay') == 1)
                {
                    $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' 00:00:00';
                }
                else
                {
                    $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . Request::input('endtime');
                }
                $userEvent->description = Request::input('description');
                $userEvent->type = $type;
                $userEvent->event_type = $event_type;
                $userEvent->cid = Request::input('hcid');

                if (Request::input('mode') == 'edit')
                {
                    $sessionObj = Session_Events::where('id', '=', Request::input('event_id'))->firstOrFail();
                }
                else
                {
                    $sessionObj = new Session_Events();
                }

//                $sessionObj = new Session_Events();
                $sessionObj->form_data = serialize(Request::all());
                $sessionObj->agenda = Request::input('htitle');
                $sessionObj->uid = $uid;
                $sessionObj->session_type = 0;
                if ($sessionObj->save())
                {
                    if (Request::input('mode') == 'edit')
                    {
                        return json_encode(array('success' => true, 'mode' => 'edit'));
                    }
                    else
                    {
                        if (Request::input('mode') == 'calendar')
                        {
                            return json_encode(array('success' => true, 'event' => $userEvent, 'mode' => 'calendar'));
                        }
                        else
                        {
                            return json_encode(array('success' => true));
                        }
                    }

                }
            }
            if (Request::input('event_id') && Request::input('mode') == 'edit')
            {
                $userEvent = User_Event::find(Request::input('event_id'));
            }
            else
            {
                $userEvent = new User_Event();
            }

            $userEvent->uid = $uid;
            $userEvent->title = Request::input('htitle');
            $userEvent->allDay = Request::input('allDay');
            $startdate = explode('-', Request::input('hstartdate'));
            if (Request::input('allDay') == 1)
            {
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' 00:00:00';
            }
            else
            {
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . Request::input('starttime');
            }

            //die(dd($startdate));

            $enddate = explode('-', Request::input('henddate'));
            if (Request::input('allDay') == 1)
            {
                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' 00:00:00';
            }
            else
            {
                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . Request::input('endtime');
            }
            $userEvent->description = Request::input('description');
            $userEvent->type = $type;
            $userEvent->event_type = $event_type;
            $userEvent->cid = Request::input('hcid');
            //die(dd(DB::getQueryLog()));
            if ($userEvent->save())
            {
                if (Request::input('mode') == 'edit')
                {
                    // DB::enableQueryLog();
                    //dd(Request::input('hevent_id'));
                    $sessionObj = Session_Events::where('event_id', '=', Request::input('hevent_id'))->firstOrFail();
                    //dd(DB::getQueryLog());
                }
                else
                {
                    $sessionObj = new Session_Events();
                }

                $users_voting = explode(',', Request::input('session_voting_users'));

                $users_notvoting = explode(',', Request::input('session_notvoting_users'));
                //    die(dd($uid));
                $sessionObj->uid = $uid;
                $sessionObj->session_type = 1;

//                $sessionObj->event_id = Request::input('hevent_id');
                $sessionObj->event_id = $userEvent->id;
                $sessionObj->form_data = serialize(Request::all());
                $sessionObj->agenda = Request::input('htitle');
                $sessionObj->term = Request::input('term');
                $sessionObj->type = Request::input('type');
                $sessionObj->location = Request::input('hlocation');
                $sessionObj->send_Invitation = Request::input('send_Invitation');
                $sessionObj->create_session_page = Request::input('create_session_page');
                $sessionObj->allow_inform_invitees = Request::input('allow_inform_invitees');
                $sessionObj->session_chief = Request::input('session_chief');
                $sessionObj->session_secretary = Request::input('session_secretary');
                $sessionObj->session_facilitator = Request::input('session_facilitator');
                $sessionObj->long = Request::input('long');
                $sessionObj->lat = Request::input('lat');
                $sessionObj->location_phone = Request::input('location_phone');
                $sessionObj->coordination_phone = Request::input('coordination_phone');
//                Event_Invitees::where('event_id', '=', Request::input('hevent_id'))->delete();
                Event_Invitees::where('event_id', '=', $userEvent->id)->delete();
                foreach ($users_voting as $u)
                {
                    $invitees = new Event_Invitees();
                    $invitees->uid = $u;
                    $invitees->user_type = 1;
//                    $invitees->event_id = Request::input('hevent_id');
                    $invitees->event_id = $userEvent->id;
                    $invitees->save();
                }
                foreach ($users_notvoting as $u)
                {
                    $invitees = new Event_Invitees();
                    $invitees->uid = $u;
                    $invitees->user_type = 2;
//                    $invitees->event_id = Request::input('hevent_id');
                    $invitees->event_id = $userEvent->id;
                    $invitees->save();
                }
                if (Session::has('Files'))
                {
                    $files = Session::get('Files');
                    if (isset($files['CalendarEvent']) && is_array($files['CalendarEvent']))
                    {
                        $sessiofiles = $files['CalendarEvent'];
                        foreach ($sessiofiles as $key => $value)
                        {
                            $f = new Events_Files();
//                            $f->event_id = Request::input('hevent_id');
                            $f->event_id = $userEvent->id;
                            $f->file_id = $key;
                            $f->save();
                        }
                        unset($files['CalendarEvent']);
                        Session::put('Files', $files);
                    }

                }

                if ($sessionObj->save())
                {

                    User_Event::setType($sessionObj->event_id, 1);

                    if (Request::input('mode') == 'edit')
                    {
                        return json_encode(array('success' => true, 'mode' => 'edit'));
                    }
                    else
                    {
                        if (Request::input('mode') == 'calendar')
                        {
                            $event = $this->getEventById($userEvent->id);
                            return json_encode(array('success' => true, 'event' => $userEvent, 'mode' => 'calendar'));

                        }
                        else
                        {
                            return json_encode(array('success' => true, 'event' => $userEvent));
                        }
                    }

                }
            }
            else
            {
                return json_encode(array('success' => false));
            }
        }
    }

    public function saveInvitation()
    {
        $uid = Auth::id();
        //dd(Request::input('mode'));
        $type = Request::input('type') ? Request::input('type') : 0;
        $event_type = Request::input('event_type') ? Request::input('event_type') : 0;
        // die(dd(Request::input('type')));
        $jdate = new jDateTime();
        $validator = \Validator::make(Request::all(), [
            'htitle' => 'required|string',
            'hcid' => 'required|integer',
            'hstartdate' => 'required',
            'henddate' => 'required',

            'hlocation' => 'required',
            'haudiences' => 'required|string'
        ]);
        //DB::enableQueryLog();
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            if (Request::input('event_id') && Request::input('mode') == 'edit')
            {
                $userEvent = User_Event::find(Request::input('event_id'));

            }
            else
            {
                $userEvent = new User_Event();
            }

            $userEvent->uid = $uid;
            $userEvent->title = Request::input('htitle');
            $userEvent->allDay = Request::input('allDay');
            $startdate = explode('-', Request::input('hstartdate'));
            if (Request::input('allDay') == 1)
            {
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' 00:00:00';
            }
            else
            {
                $userEvent->startdate = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-') . ' ' . Request::input('starttime');
            }

            //die(dd($startdate));

            $enddate = explode('-', Request::input('henddate'));
            if (Request::input('allDay') == 1)
            {
                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' 00:00:00';
            }
            else
            {
                $userEvent->enddate = $jdate->Jalali_to_Gregorian($enddate[0], $enddate[1], $enddate[2], '-') . ' ' . Request::input('endtime');
            }
            $userEvent->description = Request::input('description');
            $userEvent->type = $type;
            $userEvent->event_type = $event_type;
            $userEvent->cid = Request::input('hcid');

            //die(dd(DB::getQueryLog()));
            if ($userEvent->save())
            {
                $uid = Auth::id();
                if (Request::input('mode') == 'edit')
                {
                    $invitationObj = Invitation_Events::where('event_id', '=', Request::input('hevent_id'))->firstOrFail();

                }
                else
                {
                    $invitationObj = new Invitation_Events();
                }

                $invitationObj->uid = $uid;
                $invitationObj->event_id = $userEvent->id;
                $invitationObj->about = Request::input('about');
                $invitationObj->type = Request::input('type');
                $invitationObj->location = Request::input('hlocation');
                $invitationObj->term = Request::input('term');
                $invitationObj->allow_inform_invitees = Request::input('allow_inform_invitees');
                $invitationObj->long = Request::input('long');
                $invitationObj->lat = Request::input('lat');
                $haudiences = explode(',', Request::input('haudiences'));
                Event_Invitees::where('event_id', '=', $userEvent->id)->delete();
                foreach ($haudiences as $h)
                {
                    $invitees = new Event_Invitees();
                    $invitees->uid = $h;
                    $invitees->event_id = $userEvent->id;
                    $invitees->save();
                }
                if ($invitationObj->save())
                {
                    User_Event::setType($invitationObj->event_id, 2);
                    if (Request::input('mode') == 'edit')
                    {
                        return json_encode(array('success' => true, 'mode' => 'edit'));
                    }
                    else
                    {
                        if (Request::input('mode') == 'calendar')
                        {
                            $event = $this->getEventById(Request::input('hevent_id'));
                            return json_encode(array('success' => true, 'event' => $userEvent, 'mode' => 'calendar'));

                        }
                        else
                        {
                            return json_encode(array('success' => true));
                        }
                    }
                }

            }else
            {
                return json_encode(array('success' => false));
            }
        }
    }

    public function saveReminder()
    {
        //die(dd(Request::all()));
        $uid = Auth::id();
        $eventObj = User_Event::find(Request::input('hevent_id'));

        $startDate = strtotime($eventObj->startdate);

        $jdate = new jDateTime();
        $firstType = array();
        $secondType = array();
        $validator = \Validator::make(Request::all(), [
            'hevent_id' => 'required|integer',

        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            // dd(Request::input('haudiences'));

            return json_encode($result);
        }
        else
        {


            foreach (Request::input('firstType') as $k => $v)
            {
                $temp[$k] = explode(',', $v);
            }

            for ($i = 0; $i < count($temp['sms']); $i++)
            {
                if ($temp['in_day'][$i] != '')
                {
                    $inday = explode('-', $temp['in_day'][$i]);
                    //die(dd(strtotime($jdate->Jalali_to_Gregorian($inday[0],$inday[1],$inday[2], '-'))));
                    $firstType[$i]['in_day'] = strtotime($jdate->Jalali_to_Gregorian($inday[0], $inday[1], $inday[2], '-'));
                    $firstType[$i]['term'] = $temp['term'][$i];
                    $firstType[$i]['in_event'] = $temp['in_event'][$i];
                    $firstType[$i]['notification'] = $temp['notification'][$i];
                    $firstType[$i]['sms'] = $temp['sms'][$i];
                    $firstType[$i]['email'] = $temp['email'][$i];
                    $firstType[$i]['event_id'] = Request::input('hevent_id');
                    $firstType[$i]['type'] = 1;
                }

            }
            if (count($firstType) > 0)
            {
                foreach ($firstType as $ft)
                {
                    //die(dd($ft));
                    $reminderObj = new Event_Reminder();
                    $reminderObj->remind_date = $ft['in_day'];
                    $reminderObj->event_id = $ft['event_id'];
                    $reminderObj->term = $ft['term'];
                    $reminderObj->type = $ft['type'];
                    $reminderObj->notification = $ft['notification'];
                    $reminderObj->in_events = $ft['in_event'];
                    $reminderObj->sms = $ft['sms'];
                    $reminderObj->email = $ft['email'];

                    $reminderObj->save();


                }
            }

            unset($temp);
            foreach (Request::input('secondType') as $k => $v)
            {
                $temp[$k] = explode(',', $v);
            }

            for ($i = 0; $i < count($temp['sms']); $i++)
            {
                if ($temp['beforType'][$i] > 0)
                {
                    switch ($temp['beforType'][$i])
                    {
                        case 1:
                        {
                            $time = $startDate - ($temp['befordays'][$i] * 86400);
                            break;
                        }
                        case 2:
                        {
                            $time = $startDate - ($temp['befordays'][$i] * 7 * 86400);
                            break;
                        }
                        case 3:
                        {
                            $time = $startDate - ($temp['befordays'][$i] * 30 * 86400);
                            break;
                        }


                    }
                    $secondType[$i]['remind_date'] = $time;
                    $secondType[$i]['term'] = $temp['term'][$i];
                    $secondType[$i]['in_event'] = $temp['in_event'][$i];
                    $secondType[$i]['notification'] = $temp['notification'][$i];
                    $secondType[$i]['sms'] = $temp['sms'][$i];
                    $secondType[$i]['email'] = $temp['email'][$i];
                    $secondType[$i]['event_id'] = Request::input('hevent_id');
                    $secondType[$i]['type'] = 2;

                }

            }
            if (count($secondType) > 0)
            {
                foreach ($secondType as $st)
                {
                    //die(dd($ft));
                    $reminderObj = new Event_Reminder();
                    $reminderObj->remind_date = $st['remind_date'];
                    $reminderObj->event_id = $st['event_id'];
                    $reminderObj->type = $st['type'];
                    $reminderObj->notification = $st['notification'];
                    $reminderObj->in_events = $st['in_event'];
                    $reminderObj->sms = $st['sms'];
                    $reminderObj->term = $st['term'];
                    $reminderObj->email = $st['email'];
                    //die(dd($reminderObj));
                    $reminderObj->save();


                }
            }
            switch (Request::input('mode'))
            {
                case Request::input('mode') == 'calendar':
                {
                    $event = $this->getEventById(Request::input('hevent_id'));
                    return json_encode(array('success' => true, 'event' => $event, 'mode' => 'calendar'));
                    break;
                }
                case Request::input('mode') == 'edit':
                {
                    return json_encode(array('success' => true, 'mode' => 'edit'));
                    break;
                }

                case Request::input('mode') == 'noChange':
                {
                    User_Event::setType(Request::input('hevent_id'), 3);
                    break;
                }

            }

        }
    }

    public function eventData()
    {
        $jdate = new jDateTime();
        $event = User_Event::find(Request::input('id'));
        if($event!=null)
        {
            $startDate = explode(' ', $event['startdate']);
            $jStartDate = explode('-', $startDate[0]);
            $event['startdate'] = $jdate->Gregorian_to_Jalali($jStartDate[0], $jStartDate[1], $jStartDate[2], '-');
            $event['starttime'] = $startDate[1];
            $endDate = explode(' ', $event['enddate']);
            $jEndDate = explode('-', $endDate[0]);
            $event['enddate'] = $jdate->Gregorian_to_Jalali($jEndDate[0], $jEndDate[1], $jEndDate[2], '-');
            $event['endtime'] = $endDate[1];
            return json_encode($event);
        }else{
            return json_encode(array());
        }
    }

    public function sessionData()
    {
        $uid = Auth::id();
        $sessions = Session_Events::where('event_id', '=', Request::input('event_id'))->first();

         $sessions->chief;
      $sessions->secretary;
         $sessions->facilitator;
        $invitees = DB::table('user')
            ->select('user.id', DB::raw('CONCAT(Name," ",Family) AS text'), 'hamahang_calendar_events_invitees.user_type')
            ->join('hamahang_calendar_events_invitees', 'hamahang_calendar_events_invitees.uid', 'user.id')
            ->where('hamahang_calendar_events_invitees.event_id', '=', Request::input('event_id'))
            ->whereNull('hamahang_calendar_events_invitees.deleted_at')
            ->get();
        //die(dd($invitees));
        //die(dd(DB::getQueryLog()));


        //die(dd($invitees));
        $sessions['invitees'] = $invitees;
        return json_encode($sessions);
    }

    public function invitationData()
    {
        $invitation = Invitation_Events::where('event_id', '=', Request::input('event_id'))->first();
        $invitation_invitess = DB::table('user')
            ->select('user.id', DB::raw('CONCAT(Name," ",Family) AS text'))
            ->join('hamahang_calendar_events_invitees', 'hamahang_calendar_events_invitees.uid', 'user.id')
            ->where('hamahang_calendar_events_invitees.event_id', '=', Request::input('event_id'))
            ->get();
        $invitation['invitees'] = $invitation_invitess;
        return json_encode($invitation);
    }

    public function reminderData()
    {
        $reminders = Event_Reminder::where('event_id', '=', Request::input('event_id'))->get();
        $jdate = new jDateTime();
        foreach ($reminders as $index => $r)
        {
            $gDate = date("Y-m-d", $r['remind_date']);
            $gDate = explode('-', $gDate);
            $reminders[$index]['remind_date'] = $jdate->Gregorian_to_Jalali($gDate[0], $gDate[1], $gDate[2], '-');
            $reminders[$index]['rowIndex'] = $index + 1;
        }
        return Datatables::of($reminders)->make(true);
    }

    public function deleteEvent()
    {
        if (apiCan('calendar_events_manager_delete') == false)
        {
            return json_encode(array('access' => false));
        }
        else
        {
            $delete = DB::transaction(function ()
            {
                //die(dd(Request::input('rec_id')));
                $record = User_Event::find(Request::input('rec_id'));

                $record->delete();
                if ($record->type == 1)
                {
                    Session_Events::where('event_id', '=', Request::input('rec_id'))->delete();
                    Event_Invitees::where('event_id', '=', Request::input('rec_id'))->delete();

                }
                if ($record->type == 2)
                {
                    Invitation_Events::where('event_id', '=', Request::input('rec_id'))->delete();
                    Event_Invitees::where('event_id', '=', Request::input('rec_id'))->delete();
                }
                Event_Reminder::where('event_id', '=', Request::input('rec_id'))->delete();
            });
            //die(dd($delete));
            if ($delete == null)
            {
                return json_encode(array('success' => true));
            }
            else
            {
                return json_encode(array('success' => false));
            }
        }
    }

    public function getInfoToReminder()
    {
        $eventinfo = User_Event::find(Request::input('id'));
        if ($eventinfo->type == 1)
        {
            $session = Session_Events::where('event_id', '=', Request::input('id'))->first();
            $title = 'مدیریت یادآوری جلسه:';
            $titleStr = $eventinfo->title;
            $titleTerm = ' درتاریخ :' . $eventinfo->startdate;
        }
        else
        {
            if ($eventinfo->type == 2)
            {
                // DB::enableQueryLog();
                $invitation = Invitation_Events::where('event_id', '=', Request::input('id'))->first();
                //  die(dd(DB::getQueryLog()));
                $title = ' مدیریت يادآوری دعوت نامه: ';
                $titleStr = $eventinfo->title;
                $titleTerm = ' درتاریخ ' . $eventinfo->startdate;
            }
            elseif ($eventinfo->type == 3)
            {
                $invitation = Event_Reminder::where('event_id', '=', Request::input('id'))->first();
                $title = ' مدیریت يادآوری یادآور: ';
                $titleStr = $eventinfo->title;
                $titleTerm = ' درتاریخ ' . $eventinfo->startdate;
            }
            else
            {
                $title = ' مدیریت یادآوری رویداد: ';
                $titleStr = $eventinfo->title;
                $titleTerm = '  تاریخ شروع ' . $eventinfo->startdate;
            }
        }
        return json_encode(array('title' => $title, 'titleStr' => $titleStr, 'titleTerm' => $titleTerm));
    }

    public function getCalendarEvents()
    {
        $jdate = new jDateTime();
        $cid = Request::input('cid');
        $startDate = Request::input('startDate');
        $endDate = Request::input('endDate');
        \Session::put('default_calendar',$cid);
//        dd(Request::all());
//        $cid = trim(Request::input('cid')) !== '' ? Request::input('cid') : '31';
//        $startDate = trim(Request::input('startDate')) !== '' ? Request::input('startDate') : '2018-6-22';
//        $endDate = trim(Request::input('endDate')) !== '' ? Request::input('endDate') : '2018-7-22';
//        dd($cid,$startDate,$endDate);
        if ($cid)
        {
            $calendar = Calendar::select('id', 'title', 'default_options', 'is_optional', 'sharing_options')
                ->where('id', '=', $cid)
                ->firstOrFail()
                ->toArray();
        }
        else
        {
            $calendar = Calendar::select('id', 'title', 'default_options', 'is_optional', 'sharing_options')
                ->where('is_default', '=', 1)
                ->where('uid', '=', Auth::id())
                ->firstOrFail()
                ->toArray();
            $cid = $calendar['id'];
        }

        $defaultoption = '';
        // dd($calendar['sharing_options']);
        if ($calendar['default_options'] != '')
        {
            $defaultoption = (array)json_decode(unserialize($calendar['default_options']));
        }
        // dd($defaultoption);
        $persianIN = array();
        if ($defaultoption != '' && is_array($defaultoption))
        {
            foreach ($defaultoption as $k => $op)
            {
                switch ($k)
                {
                    case $k == 'jalali' && $op->checked == 1:
                    {
                        $persianIN[] = 'PersianCalendar';
                        break;
                    }
                    case $k == 'gergorian' && $op->checked == 1:
                    {
                        $persianIN[] = 'ObservedHijriCalendar';
                        break;
                    }
                    case $k == 'ghamari' && $op->checked == 1:
                    {
                        $persianIN[] = 'GregorianCalendar';
                        break;
                    }
                    case $k == 'event' && $op->checked == 1:
                    {
                        $eventtype[] = 0;
                        break;
                    }
                    case $k == 'session' && $op->checked == 1:
                    {
                        $eventtype[] = 1;
                        break;
                    }
                    case $k == 'invitation' && $op->checked == 1:
                    {
                        $eventtype[] = 2;
                        break;
                    }
                    case $k == 'reminder' && $op->checked == 1:
                    {
                        $eventtype[] = 3;
                        break;
                    }
                }
            }
        }

        $historical_events = DB::table('hamahang_calendar_persian_events')
            ->select('id', 'Description', 'Month', 'type', 'Day', 'Year')
            ->whereIn('type', $persianIN)
            ->get();
        foreach ($historical_events as $h)
        {
            $h->start = implode('-', $jdate->Jalali_to_Gregorian($h->Year, $h->Month, $h->Day));
            $h->end = implode('-', $jdate->Jalali_to_Gregorian($h->Year, $h->Month, $h->Day));
            $h->allDay = true;
            $h->title = $h->Description;
        }
        if (isset($defaultoption['vacation']) && $defaultoption['vacation']->checked == 1)
        {
            $vacation_events = DB::table('hamahang_calendar_persian_events')
                ->select('id', 'Description', 'Month', 'type', 'Day', 'Year')
                ->where('IsVacation', '=', 1)
                ->get();
            foreach ($vacation_events as $v)
            {
                $v->start = implode('-', $jdate->Jalali_to_Gregorian($v->Year, $v->Month, $v->Day));
                $v->end = implode('-', $jdate->Jalali_to_Gregorian($v->Year, $v->Month, $v->Day));
                $v->allDay = true;
                $v->title = $h->Description;
            }
        }
        $type_events = '';
        if (isset($eventtype) && count($eventtype) > 0)
        {
            $type_events = DB::table('hamahang_calendar_user_events as eventTable')
                ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate', 'eventTable.enddate','eventTable.allDay', 'eventTable.type')
                ->where('eventTable.cid', '=', $cid)
                ->whereIn('eventTable.type', $eventtype)
                ->get();
        }
        $sharing_events = '';
//        DB::enableQueryLog();
        if(trim($startDate)=='' || trim($endDate)=='')
        {
            $gdate = explode('-',date('Y-m-d'));
            $jdate_now = $jdate->Gregorian_to_Jalali($gdate[0],$gdate[1],$gdate[2]);
            $gdate2_first_month = $jdate->Jalali_to_Gregorian($jdate_now[0],$jdate_now[1],1);
            $gdate2_last_month = $jdate->Jalali_to_Gregorian($jdate_now[0],$jdate_now[1],($jdate_now[1]<7 ? 31 : 30));
            if(trim($startDate)=='')
                $startDate = implode('-',$gdate2_first_month);
            if(trim($endDate)=='')
                $endDate = implode('-',$gdate2_last_month);
        }
        $sharing_events = DB::table('hamahang_calendar_user_events as eventTable')
            ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate', 'eventTable.enddate','eventTable.allDay', 'shareTable.calendar_share_of AS sharId')
            ->join('hamahang_calendar_sharing_events as shareTable', 'eventTable.cid', 'shareTable.calendar_share_to')
            ->where('eventTable.cid', '=', $cid);
        if(trim($startDate)=='')
            $sharing_events->where('eventTable.startdate', '>=', $startDate);
        if(trim($endDate)!='')
            $sharing_events->where('eventTable.enddate', '<=', $endDate);
        $sharing_events = $sharing_events->get();
//        $laQuery = DB::getQueryLog();
//        print_r($laQuery);
        $sharing_options = null;
        $sharing_ids = null;
        $sharing_ids = DB::table('hamahang_calendar as cal')
            ->select('shareTable.calendar_share_of', 'cal.title')
            ->join('hamahang_calendar_sharing_events as shareTable', 'shareTable.calendar_share_of', 'cal.id')
            ->where('calendar_share_to', '=', $cid)
            ->get();
        //    dd(DB::getQueryLog());
        //dd($sharing_ids);
        if ($calendar['sharing_options'] != null)
        {
            $sharing_options = (array)json_decode( unserialize($calendar['sharing_options']));

            $getdefaulIds = array_keys($sharing_options);
            foreach ($sharing_ids as $share)
            {
                if (in_array($share->calendar_share_of, $getdefaulIds))
                {
                    $sharing_options[$share->calendar_share_of]['title'] = $share->title;
                }
            }
            $sharing_ids = null;
        }
        elseif ($calendar['sharing_options'] == '')
        {
            $sharing_options = null;
        }
        $events = DB::table('hamahang_calendar_user_events as eventTable')
            ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate', 'eventTable.enddate','eventTable.allDay')
            ->where('eventTable.cid', '=', $cid);
        if(trim($startDate)!='')
            $events->where('eventTable.startdate', '>=', $startDate);
        if(trim($endDate)!='')
            $events->where('eventTable.enddate', '<=', $endDate);
        $events = $events->get();

        return json_encode(array('historical_events' => isset($historical_events) ? $historical_events : '',
            'vacation_events' => isset($vacation_events) ? $vacation_events : '',
            'type_events' => isset($type_events) ? $type_events : '',
//            'sharing_events' => isset($sharing_events) ? $sharing_events : '',
            'sharing_events' => isset($events) ? $events : '',
            'calendarInfo' => isset($calendar) ? $calendar : '',
            'defaultoptions' => json_encode($defaultoption),
            'sharing_options' => json_encode($sharing_options),
            'sharing_ids' => $sharing_ids,
//            'events' => $events
            'events' => []
        ));
    }

    public function sessionsGrid($username)
    {
        $arr = variable_generator('user','desktop',$username);
        $arr['HFM_Session'] = HFM_GenerateUploadForm([['CalendarEvent_session', ['doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'], 'Multi']]);
        return view('hamahang.CalendarEvents.sessions', $arr);
    }

    public function deleteReminder()
    {
        if (Request::input('delReminder'))
        {
            Event_Reminder::whereIn('id', explode(',', Request::input('delReminder')))->delete();
        }
    }

    public function decisionsSave()
    {
        $uid = Auth::id();
        $dc = new Sessions_Decisions();
        $dc->uid = $uid;
        $dc->event_id = Request::input('event_id');
        $dc->title = Request::input('title');
        $dc->description = Request::input('desc');
        if ($dc->save())
        {
            return json_encode(array('success' => true));
        }
        else
        {
            return json_encode(array('success' => false));
        }
    }

    public function deleteDescision()
    {
        Sessions_Decisions::where('id', '=', Request::input('id'))->delete();
    }

    public function saveTemporaryTask()
    {
        // die(dd(Request::all()));
        $date = new jDateTime();
        date_default_timezone_set('Asia/Tehran');
        //date_default_timezone_set('Asia/Tehran');
        $date_to_split = explode('-', Request::input('respite_date'));
        $respite_timestsmp = $date->mktime(0, 0, 0, $date_to_split[1], $date_to_split[2], $date_to_split[0]);
        $task = new tasks;
        $task->title = Request::input('title');
        $task->duration_timestamp = $respite_timestsmp-time();
        $task->uid = Auth::id();
        $task->save();
        $x = 0;
        if (sizeof(Request::input('user_id') > 0))
        {
            foreach (Request::input('user_id') as $u)
            {
                if ($x == 0)
                {
                    ///////نفر اول بعنوان مسوول ثبت می شود
                    $assign = new task_assignments;
                    $assign->employee_id = $u;
                    $assign->assigner_id = 125;
                    $assign->task_id = $task->id;
                    $assign->uid = Auth::id();
                    $assign->save();
                    $x = 1;
                }
                else
                {
                    /////////// ثبت سایر افراد وظیفه
                    $staff = new task_staffs;
                    $staff->assignment_id = $assign->id;
                    $staff->user_id = $u;
                    $staff->save();
                }
            }
        }
        //  die($task->id."xxxx");
        $status = new task_status;
        $status->task_id = $task->id;
        $status->type = 0;
        $status->timestamp = time();
        $status->save();


        $respite_date = date('Y-m-d', $task->respite);
        $date1 = date_create($respite_date);
        $date2 = date_create(date('Y-m-d'));
        $diff = date_diff($date2, $date1);
        $respite_date = $diff->format('%R%a');
        $username = User::find($assign->employee_id);

        $eventTask = new Events_Tasks();
        $eventTask->task_id = $task->id;
        $eventTask->uid = Auth::id();
        $eventTask->event_id = Request::input('event_id');
        if ($eventTask->save())
        {
            return json_encode(array('success' => true));
        }
        else
        {
            return json_encode(array('success' => false));
        }

    }

    public function saveTaskDecision()
    {
        $decision_id = Request::input('decision_id');
        $tasks = explode(',', Request::input('tasks'));
        // die(dd($tasks));
        foreach ($tasks as $task)
        {
            $dt = new Decisions_Tasks();
            $dt->uid = Auth::id();
            $dt->decision_id = $decision_id;
            $dt->task_id = $task;
            $dt->save();
        }
        //DB::enableQueryLog();
        $task_titles = DB::table('hamahang_task')
            ->select('title')
            ->whereIn('id', $tasks)
            ->get();
        //die(dd(DB::getQueryLog()));
        return json_encode(array('success' => true, 'titles' => $task_titles));
    }

    public function deleteDecisionTask()
    {
        DB::enableQueryLog();
        $isDeleted = Decisions_Tasks::destroy(Request::input('rmId'));
        dd(DB::getQueryLog());

        if ($isDeleted)
        {
            return json_encode(array('success' => true));
        }
    }

    public function SessionUsersList()
    {
        $users = DB::table('user')
            ->select('hamahang_calendar_events_invitees.id', 'user.Uname', 'hamahang_calendar_events_invitees.present')
            ->join('hamahang_calendar_events_invitees', 'hamahang_calendar_events_invitees.uid', 'User.id')
            ->where('hamahang_calendar_events_invitees.event_id', '=', Request::input('event_id'))
            ->get();
        foreach ($users as $index => $u)
        {
            $u->rowIndex = $index + 1;
            //$d->e_ID =
        }
        return json_encode($users);
    }

    public function saveSessionUsersPresent()
    {
        $users = Request::input('users');
        foreach ($users as $i => $u)
        {
            if ($u != '')
            {
                $invitees = Event_Invitees::find($i);
                $invitees->present = $u;
                $invitees->save();
            }
        }
    }

    public function addGuestToSession()
    {
        $uid = Request::input('uid');
        $username = Request::input('username');
        $event_id = Request::input('event_id');
        $guestObj = new Session_Guest();
        if ($uid != '')
        {
            $guestObj->uid = $uid;
        }
        else
        {
            $guestObj->name = $username;
        }
        $guestObj->event_id = $event_id;
        $guestObj->save();
    }

    public function deleteGuestSession()
    {
        // DB::enableQueryLog();
        $isDeleted = Session_Guest::destroy(Request::input('rmId'));
        if ($isDeleted)
        {
            return json_encode(array('success' => true));
        }
    }

    public function getEventById($id)
    {
        $event = User_Event::find($id);
        return json_encode($event);
    }

    public function invitationsGrid($username)
    {
        $arr = variable_generator('user','desktop',$username);
        return view('hamahang.CalendarEvents.invitations', $arr);
    }
    public function fetchEvents()
    {
        $types = [12];
        if(count(Request::input('types'))> 0)
        {
            $types = Request::input('types');
        }
        $uid = (session('uid') != '' && session('uid') != '') ? session('uid') : 0;
        $jdate = new jDateTime();
        $events = User_Event::select('id', 'title', 'startdate', 'enddate', 'type', 'event_type', 'allDay')
            ->where('uid', '=', $uid)
            ->where('event_type', '=', 'reminder')
            ->whereIn('is_draft', $types)
            ->orderBy('id', 'desc')
            ->get();
        //die(dd(DB::getQueryLog()));
        foreach ($events as $index => $event)
        {
            $startdate = explode(' ', $event['startdate']);
            $enddate = explode(' ', $event['enddate']);
            if($startdate[0]!='0000-00-00' && $startdate[1]!='00:00:00')
            {
                $jstartdate = explode('-', $startdate[0]);
                $events[$index]['startdate'] = $jdate->Gregorian_to_Jalali($jstartdate[0], $jstartdate[1], $jstartdate[2], '-') . ' ' . $startdate[1];
            }
            if($enddate[0]!='0000-00-00' && $enddate[1]!='00:00:00')
            {
                $jenddate = explode('-', $enddate[0]);
                $events[$index]['enddate'] = $jdate->Gregorian_to_Jalali($jenddate[0], $jenddate[1], $jenddate[2], '-') . ' ' . $enddate[1];
            }
            $events[$index]['rowIndex'] = $index + 1;
            $now = date('Y-m-d');
            if ($enddate[0] < $now)
            {
                $event->showMinutesDailog = true;
            }
            else
            {
                $event->showMinutesDailog = false;
            }
        }
//        dd($events);
        return Datatables::of($events)->addColumn('access_list', function ($data)
        {
            $res['delete'] = apiCan('calendar_events_manager_delete');
            $res['edit'] = apiCan('calendar_events_manager_edit');
            $res['add_reminder'] = apiCan('calendar_events_manager_add_reminder');
            return $res;
        })->make(true);
    }
    public function calendarEventFileList()
    {
        // DB::enableQueryLog();
        $files = DB::table('hamahang_files')
            ->select('hamahang_calendar_events_files.file_id', 'hamahang_files.originalName', 'hamahang_files.size', 'hamahang_files.extension')
            ->join('hamahang_calendar_events_files', 'hamahang_calendar_events_files.file_id', 'hamahang_files.id')
            ->where('hamahang_calendar_events_files.event_id', '=', Request::input('event_id'))
            ->get();
        //die(dd(DB::getQueryLog()));exit;
        $EncryptString = new EncryptString;
        $FileManager = new FileManager;
        foreach ($files as $index => $f)
        {
            //die(dd($f));
            $f->ID_N = $EncryptString->encode($f->file_id);
            $f->file_size = $FileManager->FileSizeConvert($f->size);
            $f->rowIndex = $index + 1;
        }
        // die(dd($files));
        return Datatables::of($files)->make(true);

    }
    public function fetchSessionData()
    {
        if(Request::input('types'))
        {
            $types = Request::input('types');
        }else{
            $types[] = 12;
        }

        $jdate = new jDateTime();
        $sessions = DB::table('hamahang_calendar_sessions_events')
            ->select(
//                'hamahang_calendar_user_events.id',
                'hamahang_calendar_user_events.startdate',
                'hamahang_calendar_user_events.enddate',
                'hamahang_calendar_sessions_events.id',
                'hamahang_calendar_sessions_events.agenda',
                'hamahang_calendar_sessions_events.type',
                'hamahang_calendar_sessions_events.session_type',
                'hamahang_calendar_sessions_events.form_data',
                'hamahang_calendar.title'
            )
            ->leftJoin('hamahang_calendar_user_events', 'hamahang_calendar_sessions_events.event_id', 'hamahang_calendar_user_events.id')
            ->leftJoin('hamahang_calendar', 'hamahang_calendar_user_events.cid', 'hamahang_calendar.id')
            ->where('hamahang_calendar_sessions_events.uid', '=', Auth::id())
            ->whereIn('hamahang_calendar_sessions_events.session_type', $types)
            ->whereNull('hamahang_calendar_sessions_events.deleted_at')
            ->get();
        foreach ($sessions as $index => $s)
        {
            if($s->session_type){
                $startdate = explode(' ', $s->startdate);
                $jstartdate = explode('-', $startdate[0]);
                $s->startdate = $jdate->Gregorian_to_Jalali($jstartdate[0], $jstartdate[1], $jstartdate[2], '-') . ' ' . $startdate[1];
                $now = date('Y-m-d');

                $enddate = explode(' ', $s->enddate);
                //die(dd($enddate[0]));
                if ($enddate[0] < $now)
                {
                    $s->showMinutesDailog = true;
                }
                else
                {
                    $s->showMinutesDailog = false;
                }
                $jenddate = explode('-', $enddate[0]);
                $s->enddate = $jdate->Gregorian_to_Jalali($jenddate[0], $jenddate[1], $jenddate[2], '-') . ' ' . $enddate[1];
            }else{
                $form_data = unserialize($s->form_data);
//                dd($form_data,$form_data["htitle"]);
                $s->startdate = $form_data["hstartdate"] . ' ' . $form_data['starttime'];
                $s->showMinutesDailog = false;
                $s->enddate = $form_data["henddate"] . ' ' . $form_data['endtime'];
            }

            $s->rowIndex = $index + 1;
        }

        return Datatables::of($sessions)->make(true);
    }

    public function getDecisions()
    {
        $decisions = DB::table('hamahang_calendar_sessions_decisions')
            ->select('id', 'event_id', 'title')
            ->where('event_id', '=', Request::input('event_id'))
            ->whereNull('deleted_at')
            ->get();
        //encrypt()
        foreach ($decisions as $index => $d)
        {
            $d->rowIndex = $index + 1;
            //$d->e_ID =
        }
        return Datatables::of($decisions)->make(true);
    }

    public function getDecisionsTemporaryTask()
    {
        //  DB::enableQueryLog();
        $tasks = DB::table('hamahang_calendar_events_task')
            ->select('hamahang_calendar_events_task.id',
                'hamahang_calendar_events_task.event_id',
                'hamahang_task.title',
                'hamahang_calendar_events_task.task_id')
            ->join('hamahang_task', 'hamahang_task.id', 'hamahang_calendar_events_task.task_id')
            ->where('hamahang_calendar_events_task.event_id', '=', Request::input('event_id'))
            ->whereNull('hamahang_calendar_events_task.deleted_at')
            ->get();
//die(dd(DB::getQueryLog()));
        foreach ($tasks as $index => $t)
        {
            $t->rowIndex = $index + 1;
            //$d->e_ID =
        }
        return Datatables::of($tasks)->make(true);
    }
    public function fetcTaskOfEvents()
    {
        $tasks = DB::table('hamahang_calendar_events_decision_task')
            ->select('hamahang_calendar_events_decision_task.id', 'hamahang_task.title AS task', 'hamahang_calendar_sessions_decisions.title AS decision')
            ->join('hamahang_task', 'hamahang_task.id', 'hamahang_calendar_events_decision_task.task_id')
            ->join('hamahang_calendar_sessions_decisions', 'hamahang_calendar_sessions_decisions.id', 'hamahang_calendar_events_decision_task.decision_id')
            ->where('hamahang_calendar_sessions_decisions.event_id', '=', Request::input('event_id'))
            ->whereNull('hamahang_calendar_sessions_decisions.deleted_at')
            ->get();
        foreach ($tasks as $index => $t)
        {
            $t->rowIndex = $index + 1;
            //$d->e_ID =
        }
        return Datatables::of($tasks)->make(true);
    }

    public function sessionGuest()
    {
        $gusers = DB::table('hamahang_calendar_events_session_guest AS guest')
            ->select('guest.id', 'guest.name', 'user.Uname')
            ->leftJoin('user', 'guest.uid', 'user.id')
            ->whereNull('guest.deleted_at')
            ->get();
        foreach ($gusers as $index => $g)
        {
            $g->rowIndex = $index + 1;
            if ($g->name != '')
            {
                $g->username = $g->name;

            }
            else
            {
                if ($g->Uname != '')
                {
                    $g->username = $g->Uname;
                }
            }
        }
        return Datatables::of($gusers)->make(true);
    }

    public function fetchinvitationsData()
    {
        $jdate = new jDateTime();
        $invitations = DB::table('hamahang_calendar_invitation_events')
            ->select('hamahang_calendar_user_events.id',
                'hamahang_calendar_user_events.startdate',
                'hamahang_calendar_user_events.enddate',
                'hamahang_calendar_invitation_events.about',
                'hamahang_calendar_invitation_events.type',
                'hamahang_calendar.title')
            ->join('hamahang_calendar_user_events', 'hamahang_calendar_invitation_events.event_id', 'hamahang_calendar_user_events.id')
            ->join('hamahang_calendar', 'hamahang_calendar_user_events.cid', 'hamahang_calendar.id')
            ->where('hamahang_calendar_invitation_events.uid', '=', Auth::id())
            ->whereNull('hamahang_calendar_invitation_events.deleted_at')
            ->get();
        foreach ($invitations as $index => $in)
        { //die(dd($s));
            $startdate = explode(' ', $in->startdate);

            $jstartdate = explode('-', $startdate[0]);
            $in->startdate = $jdate->Gregorian_to_Jalali($jstartdate[0], $jstartdate[1], $jstartdate[2], '-') . ' ' . $startdate[1];
            $now = date('Y-m-d');

            $enddate = explode(' ', $in->enddate);
            //die(dd($enddate[0]));

            $jenddate = explode('-', $enddate[0]);
            $in->enddate = $jdate->Gregorian_to_Jalali($jenddate[0], $jenddate[1], $jenddate[2], '-') . ' ' . $enddate[1];

            $in->rowIndex = $index + 1;
        }

        return Datatables::of($invitations)->make(true);
    }
    public function newEventModal()
    {
        if(Request::input('mode')=='editEvent')
        {
            $btn= 'editEvent';
            $title = trans('calendar_events.ce_modal_event_edit_header_title');
        }else{
            $btn='newEvent';
            $title = trans('calendar_events.ce_modal_event_header_title');
        }
        return json_encode([
            'header'=>$title,
            'content'=>view('hamahang.CalendarEvents.helper.Index.modal_event')->render(),
            'footer'=>view('hamahang.CalendarEvents.helper.Index.modal_buttons')->with('btn_type',$btn)->render()
        ]);

    }
    public function sessionModal()
    {
        $form_data = '';
        if(Request::input('mode')=='editSession')
        {
            $btn= 'editSession';
            $session = Session_Events::where('hamahang_calendar_sessions_events.id', '=', Request::input('id'))->first();
            Session::put('id_session_edit_form',Request::input('id'));
            $form_data = unserialize($session->form_data);
            $form_data["session_id"] = Request::input('id');
            $title = trans('calendar_events.ce_modal_session_header_edit_title');
            $session_pages = preg_split('/,/',$form_data['session_pages']);

            if($form_data['session_pages']){
                $data = DB::table('pages')
                    ->join('subjects', 'subjects.id', '=', 'pages.sid')
                    ->whereIn('pages.id', $session_pages)
                    ->select('subjects.title as title', 'pages.id')
                    ->get()->toArray();
                $form_data['session_pages'] = $data;
            }
            if($form_data['hcid']){
                $list = DB::table("hamahang_calendar")
                    ->select('id', 'title', 'is_default')
                    ->where('hamahang_calendar.id', '=', $form_data['hcid'])
                    ->get()->toArray();
                $form_data['hcid'] = $list;
            }
            if($form_data['session_chief']){
                $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                    ->where("id", "=", $form_data['session_chief'])
                    ->get()->toArray();
                $form_data['session_chief'] = $usermodel;
            }
            if($form_data['session_secretary']){
                $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                    ->where("id", "=", $form_data['session_secretary'])
                    ->get()->toArray();
                $form_data['session_secretary'] = $usermodel;
            }
            if($form_data['session_facilitator']){
                $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                    ->where("id", "=", $form_data['session_facilitator'])
                    ->get()->toArray();
                $form_data['session_facilitator'] = $usermodel;
            }
            $session_voting_users = preg_split('/,/',$form_data['session_voting_users']);
            if($form_data['session_voting_users']){
                $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                    ->whereIn("id", $session_voting_users)
                    ->get()->toArray();
                $form_data['session_voting_users'] = $usermodel;
            }
            $session_notvoting_users = preg_split('/,/',$form_data['session_notvoting_users']);
            if($form_data['session_notvoting_users']){
                $usermodel = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                    ->whereIn("id", $session_notvoting_users)
                    ->get()->toArray();
                $form_data['session_notvoting_users'] = $usermodel;
            }
//            dd($form_data);
        }else{
            $btn='session';
            $title = trans("calendar_events.ce_modal_session_header_title");
        }
        $HFM_CalendarEvent = HFM_GenerateUploadForm([['CalendarEvent', ['doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'], 'Multi']]);
        return json_encode([
            'header'=>$title,
            'content'=>view('hamahang.CalendarEvents.helper.Index.modal_session')->with('HFM_CalendarEvent',$HFM_CalendarEvent)->with('form_data',$form_data)->render(),
            'footer'=>view('hamahang.CalendarEvents.helper.Index.modal_buttons')->with('btn_type',$btn)->with('form_data',$form_data)->render()
        ]);

    }
    public function invitationModal()
    {
        if(Request::input('mode')=='editInvitation')
        {
            $btn= 'editInvitation';
            $title = trans('calendar_events.ce_modal_invitation_header_title_edit');
        }else{
            $btn='invitation';
            $title = trans('calendar_events.ce_modal_invitation_header_title_new');
        }
        return json_encode([
            'header'=>$title,
            'content'=>view('hamahang.CalendarEvents.helper.Index.modal_invitation')->render(),
            'footer'=>view('hamahang.CalendarEvents.helper.Index.modal_buttons')->with('btn_type',$btn)->render()
        ]);

    }
    public function reminderModal()
    {
        $form_data = '';
        if(Request::input('mode')=='editReminder')
        {
            Session::put('id_reminder_edit_form',Request::input('id'));
            $jdate = new jDateTime();
            $btn= 'editReminder';
            $title = trans('calendar_events.ce_modal_reminder_navbarـ_edit_nav2');
            $reminder = User_Event::where('id', '=', Request::input('id'))->first();
            $form_data = unserialize($reminder->form_data);
            $form_data['id'] = Request::input('id');
            $form_data['end_id'] = enCode(Request::input('id'));

            foreach ($form_data['in_day'] as $key => $Ain_day){
                $startdate = explode('-', $Ain_day['value']);
                $form_data['in_day'][$key]['gregorian'] = $jdate->Jalali_to_Gregorian($startdate[0], $startdate[1], $startdate[2], '-');
            }
            if($form_data['hcid']){
                $list = DB::table("hamahang_calendar")
                    ->select('id', 'title', 'is_default')
                    ->where('hamahang_calendar.id', '=', $form_data['hcid'])
                    ->get()->toArray();
                $form_data['hcid'] = $list;
            }
        }else{
            $btn='reminder';
            $title = trans('calendar_events.ce_modal_reminder_header_title');
        }
        return json_encode([
            'header'=>$title,
            'content'=>view('hamahang.CalendarEvents.helper.Index.modal_reminder')->with('form_data',$form_data)->render(),
            'footer'=>view('hamahang.CalendarEvents.helper.Index.modal_buttons')->with('btn_type',$btn)->render()
        ]);

    }
    public function addReminderModal()
    {
        if(Request::input('mode')=='editReminder')
        {

            $btn= 'editReminder';
            $title = trans('calendar_events.ce_modal_reminder_navbarـ_edit_nav2');
        }else{
            $btn='reminder';
            $title = trans('calendar_events.ce_modal_reminder_header_title');
        }
        return json_encode([
            'header'=>$title,
            'content'=>view('hamahang.CalendarEvents.helper.Index.modal_add_reminder')->render(),
            'footer'=>view('hamahang.CalendarEvents.helper.Index.modal_buttons')->with('btn_type',$btn)->render()

        ]);
    }
    public function minutesModal()
    {
        return json_encode([
            'header'=>trans('calendar_events.ce_modal_minutes_header_title'),
            'content'=>view('hamahang.CalendarEvents.helper.sessions.modal_minutes')->render(),
            'footer'=>''
        ]);
    }
}