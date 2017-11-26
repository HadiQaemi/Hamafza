<?php

namespace App\Models\Hamahang\Calendar;
use DB;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\HamahangCustomClasses\jDateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
class Calendar extends Model
{
    use softdeletes;
    protected $table = "hamahang_calendar";

    /**
     * this function list on current user calendar
     */
    public static function getUserCalendar()
    {
        $uid = (session('uid') != '') ? session('uid') : 0;
        $list = DB::table("hamahang_calendar")->where('user_id','=',$uid)->get();
        return $list;
    }
    /**
     * @param $cid int
     * @param $type string
     */
    public static function getEventsBetWeen($cid,$type,$selected=0)
    {
        $eventArr='';
        if ($cid) {


            $calendar = Calendar::select('id', 'title', 'default_options', 'sharing_options')
                ->where('id', '=', $cid)
                ->firstOrFail()
                ->toArray();
        } else {
            $calendar = Calendar::select('id', 'title', 'default_options', 'sharing_options')
                ->where('is_default', '=', 1)
                ->where('uid', '=', Auth::id())
                ->firstOrFail()
                ->toArray();
            $cid = $calendar['id'];
        }
        $jDate = new jDateTime();
        $gNow = explode('-', date('Y-m-d'));
        $jNow = $jDate->Gregorian_to_Jalali($gNow[0], $gNow[1], $gNow[2]);
        $jalaliMonth[1] = 31;
        $jalaliMonth[2] = 31;
        $jalaliMonth[3] = 31;
        $jalaliMonth[4] = 31;
        $jalaliMonth[5] = 31;
        $jalaliMonth[6] = 31;
        $jalaliMonth[7] = 30;
        $jalaliMonth[8] = 30;
        $jalaliMonth[9] = 30;
        $jalaliMonth[10] = 30;
        $jalaliMonth[11] = 30;
        $lastDaay = $jDate->Gregorian_to_Jalali($gNow[0], 4, 20);
        $jalaliMonth[12] = $lastDaay[2];
        switch ($type) {
            case 'seanson': {
                $season = array();
                switch ( $selected ) {
                    case ($selected ==4):

                        $season = array(10, 11, 12);
                        break;

                    case ($selected ==3):

                        $season = array(7, 8, 9);
                        break;
                    case ($selected ==2):

                        $season = array(4, 5, 6);
                        break;
                    default:
                        $season = array(1, 2, 3);
                }
                $year = $jNow[0] ;
                $start = $jDate->Jalali_to_Gregorian($year, $season[0], 1, '-');
                $end = $jDate->Jalali_to_Gregorian($year, $season[2], $jalaliMonth[$season[2]], '-');
                break;
            }
            case 'sixMonth': {
                if ($selected==1) {
                    $start = $jDate->Jalali_to_Gregorian($jNow[0], 1, 1, '-');
                    $end = $jDate->Jalali_to_Gregorian($jNow[0], 6, 31, '-');
                } else {
                    $start = $jDate->Jalali_to_Gregorian($jNow[0], 7, 1, '-');
                    $end = $jDate->Jalali_to_Gregorian($jNow[0], 12, $jalaliMonth[12], '-');
                }
                break;
            }
            case 'year': {
                $start = $jDate->Jalali_to_Gregorian($jNow[0], 1, 1, '-');
                $end = $jDate->Jalali_to_Gregorian($jNow[0], 12, $jalaliMonth[12], '-');
                break;
            }
        }
        $defaultoption = '';
        if ($calendar['default_options'] != '') {
            $defaultoption = (array)json_decode(unserialize($calendar['default_options']));
        }
        $sharing_options = '';
        if ($calendar['sharing_options'] > 0) {
            $sharing_options = (array)json_decode(unserialize($calendar['sharing_options']));

        }
        $persianIN = array();


        if ($defaultoption != '' && is_array($defaultoption)) {
            foreach ($defaultoption as $k => $op) {//dd($k);
                switch ($k) {
                    case $k == 'jalali' && $op->checked == 1: {
                        $persianIN[] = 'PersianCalendar';
                        break;
                    }
                    case $k == 'gergorian' && $op->checked  == 1: {
                        $persianIN[] = 'ObservedHijriCalendar';
                        break;
                    }
                    case $k == 'ghamari' && $op->checked  == 1: {
                        $persianIN[] = 'GregorianCalendar';
                        break;
                    }
                    case $k == 'event' && $op->checked  == 1: {
                        $eventtype[] = 0;
                        break;
                    }
                    case $k == 'session' && $op->checked  == 1: {
                        $eventtype[] = 1;
                        break;
                    }
                    case $k == 'invitation' && $op->checked  == 1: {
                        $eventtype[] = 2;
                        break;
                    }
                    case $k == 'reminder' && $op->checked  == 1: {
                        $eventtype[] = 3;
                        break;
                    }

                }
            }
        }

       //  DB::enableQueryLog();
        $historical_events = DB::table('hamahang_calendar_persian_events')
            ->select('id', 'Description', 'Month', 'type', 'Day', 'Year')
            ->whereBetween('g_time', array($start, $end))
            ->whereIn('type', $persianIN)
            ->get();
        //dd(DB::getQueryLog());
        foreach ($historical_events as $h) {
            $h->start = implode('-', $jDate->Jalali_to_Gregorian($h->Year, $h->Month, $h->Day));
            $h->end = implode('-', $jDate->Jalali_to_Gregorian($h->Year, $h->Month, $h->Day));
            $h->title = $h->Description;

            //if(strtotime($betweenDayFirst) < strtotime($h->start) && strtotime($h->start) <= strtotime($lastDayOfMonth[2]))
            //{
            $color = '';
            switch ($h->type) {
                case 'PersianCalendar': {
                    $color = isset($defaultoption['jalali']['color']) ? $defaultoption['jalali']['color'] : '';
                    break;
                }
                case 'GregorianCalendar': {
                    $color = isset($defaultoption['gergorian']['color']) ? $defaultoption['gergorian']['color'] : '';
                    break;
                }
                case 'ObservedHijriCalendar': {
                    $color = isset($defaultoption['ghamari']['color']) ? $defaultoption['ghamari']['color'] : '';
                    break;
                }
            }
            $h->color = $color;
            $eventArr[$h->Month][$h->Day][] = $h;
            // }


        }

        if (isset($defaultoption['vacation']) && $defaultoption['vacation']->checked == 1) {
            $vacation_events = DB::table('hamahang_calendar_persian_events')
                ->select('id', 'Description', 'Month', 'type', 'Day', 'Year')
                ->whereBetween('g_time', array($start, $end))
                ->where('IsVacation', '=', 1)
                ->get();
            foreach ($vacation_events as $v) {
                $v->start = implode('-', $jDate->Jalali_to_Gregorian($v->Year, $v->Month, $v->Day));
                $v->end = implode('-', $jDate->Jalali_to_Gregorian($v->Year, $v->Month, $v->Day));
                $v->title = $h->Description;
                // if (strtotime($betweenDayFirst) < strtotime($v->start) &&  strtotime($v->start) <= strtotime($lastDayOfMonth[2]))
                //{
                $v->color = isset($defaultoption['vacation']['color']) ? $defaultoption['vacation']['color'] : '';
                $eventArr[$h->Month][$h->Day][] = $v;
                // }
            }
        }

        if (isset($eventtype) && count($eventtype) > 0) {
            $type_events = DB::table('hamahang_calendar_user_events as eventTable')
                ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate as start', 'eventTable.enddate as end', 'eventTable.type')
                ->where('eventTable.cid', '=', $cid)
                ->whereIn('eventTable.type', $eventtype)
                ->whereBetween('eventTable.startdate', array($start, $end))
                ->get();
            foreach ($type_events as $event) {
                $gArr = explode('-', $event->start);

                $jstartDate = $jDate->Gregorian_to_Jalali($gArr[0], $gArr[1], $gArr[2]);
                $color = '';
                switch ($event->type) {
                    case 0: {
                        $color = isset($defaultoption['event']->color) ? $defaultoption['event']->color : '';
                        break;
                    }
                    case 1: {
                        $color = isset($defaultoption['session']->color) ? $defaultoption['session']->color : '';
                        break;
                    }
                    case 2: {
                        $color = isset($defaultoption['invitation']->color) ? $defaultoption['invitation']->color : '';
                        break;
                    }
                    case 3: {
                        $color = isset($defaultoption['reminder']->color) ? $defaultoption['reminder']->color : '';
                        break;
                    }
                }
                // dd($color);
                $event->color = $color;

                $eventArr[$jstartDate[1]][$jstartDate[2]][] = $event;
                if (strtotime($event->end) - strtotime($event->start) > 86400) {
                    $begin = new \DateTime($event->start);
                    $endDay = new \DateTime($event->end);

                    $interval = \DateInterval::createFromDateString('1 day');
                    $period = new \DatePeriod($begin, $interval, $endDay);
                    foreach ($period as $dt) {
                        //die(dd($dt->format('Y-m-d'),$event->startdate));
                        $dateArr = explode('-', $dt->format('Y-m-d'));
                        $jMiddleDate = $jDate->Gregorian_to_Jalali($dateArr[0], $dateArr[1], $dateArr[2]);
                        $eventArr[$jMiddleDate[1]][$jMiddleDate[2]][] = $event;
                    }

                }

            }

        }
        //dd($seasonEvents);
        $sharing_events = DB::table('hamahang_calendar_user_events as eventTable')
            ->select('eventTable.id', 'eventTable.title', 'eventTable.startdate as start', 'eventTable.enddate as end', 'shareTable.calendar_share_of AS sharId')
            ->join('hamahang_calendar_sharing_events as shareTable', 'eventTable.cid', 'shareTable.calendar_share_to')
            ->whereBetween('eventTable.startdate', array($start, $end))
            ->where('eventTable.cid', '=', $cid)
            ->get();
        foreach ($sharing_events as $event) {
            $gArr = explode('-', $event->start);

            $jstartDate = $jDate->Gregorian_to_Jalali($gArr[0], $gArr[1], $gArr[2]);
            $color = '';
            $color = isset($sharing_options[$event->sharId]) ? $sharing_options[$event->sharId]['color'] : '';
            $event->color = $color;
            $eventArr[$jstartDate[1]][$jstartDate[2]][] = $event;
            if (strtotime($event->end) - strtotime($event->start) > 86400) {
                $begin = new \DateTime($event->start);
                $endDay = new \DateTime($event->end);

                $interval = \DateInterval::createFromDateString('1 day');
                $period = new \DatePeriod($begin, $interval, $endDay);
                foreach ($period as $dt) {
                    //die(dd($dt->format('Y-m-d'),$event->startdate));
                    $dateArr = explode('-', $dt->format('Y-m-d'));
                    $jMiddleDate = $jDate->Gregorian_to_Jalali($dateArr[0], $dateArr[1], $dateArr[2]);
                    $eventArr[$jMiddleDate[1]][$jMiddleDate[2]][] = $event;

                }
            }
        }
//dd($eventArr);
        return $eventArr;
    }

    /**
     * @return   Object of calendar that default
     */
    public static function getDefaultCalendar()
    {
        return Calendar::where('is_default','=',1)->where('user_id','=',Auth::id())->first();
    }

}
