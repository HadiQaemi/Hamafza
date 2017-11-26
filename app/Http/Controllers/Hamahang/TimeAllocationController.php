<?php

namespace App\Http\Controllers\Hamahang;

use Request;
use App\Models\Hamahang\Calendar\Calendar;
use App\Models\Hamahang\Calendar\Calendar_Hiddentimes;
use App\Http\Controllers\Controller;

class TimeAllocationController extends Controller
{

    public function index()
    {
        $returnArr = [];
        if (Request::input('cid'))
        {
            $returnArr['selectdCalendarId'] = Request::input('cid');
        }
        else
        {
            $defaultCalendar = Calendar::getDefaultCalendar();
            $returnArr['selectdCalendarId'] = $defaultCalendar->id;
        }
        //get hiidentim list of selected calendar
        //$calendarHiddenObj = new Calendar_Hiddentimes();
        //$hiddenTimeList = $calendarHiddenObj->getCalendarHiddenTimes($returnArr['selectdCalendarId']);
        $returnArr['selectdCalendarId'];
        //$currentGergorianDarte = date('Y-m-d');
        //$sevenGergorainafterToDay = date('Y-m-d', strtotime("+7 day", strtotime($currentGergorianDarte)));
        //dd($currentGergorianDarte,$sevenGergorainafterToDay);
    }

}
