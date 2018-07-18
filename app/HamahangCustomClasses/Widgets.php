<?php
/**
 * Created by PhpStorm.
 * User: hamahang
 * Date: 3/6/17
 * Time: 12:55 PM
 */

namespace App\HamahangCustomClasses;
use Auth;

class Widgets
{
     public function userCalendarGrid()
     {
         return view('hamahang.Widgets.UserCalendar.user_calendar');
     }
     public function userProjectsWidget()
     {
         return view('hamahang.Widgets.UserProject.user_project');
     }
}