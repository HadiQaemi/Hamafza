<?php
//----------------Begin-------------- Tasks / Projects / Process -------------------Begin---------------//
if (!function_exists('hamahang_get_task_use_type_name'))
{
    function hamahang_get_task_use_type_name($use_type)
    {
        switch ($use_type)
        {
            case 0:
            {
                $use_type_name = 'عادی';
                break;
            }
            case 1:
            {
                $use_type_name = 'پروژه ای';
                break;
            }
            case 2:
            {
                $use_type_name = 'فرایندی';
                break;
            }
            default:
            {
                $use_type_name = 'ناشناخته';
                break;
            }
        }
        return $use_type_name;
    }
}
if (!function_exists('hamahang_respite_remain'))
{
    function hamahang_respite_remain($creation_timestamp, $duration_timestamp, $api = false)
    {
        date_default_timezone_set('Asia/Tehran');
        $dif = (($creation_timestamp + $duration_timestamp) - time());
        if ($api)
        {
            return hamahang_get_respite($dif, 'd', true);
        }
        return hamahang_get_respite($dif);
    }
}
if (!function_exists('hamahang_get_respite'))
{
    /**
     * @param int $respite
     * @param string $type 'd' => day , 'w' => week
     * @param boolean $api 'false'=>for web , 'true'=> for application api
     * @return array
     */
    function hamahang_get_respite($respite, $type = 'd', $api = false)
    {
        $arr = [];
        $delayed = 0;
        if ($respite < 0)
        {
            $delayed = 1;
            $respite = abs($respite);
        }
        if ($type == 'd')
        {
            $day_no = (int)floor($respite / 86400);
            $hour_no = (int)floor(($respite % 86400) / 3600);
            $min_no = (int)floor((($respite % 86400) % 3600) / 60);
            $sec_no = (int)floor(($respite % 86400) % 3600) % 60;
            if ($api)
            {
                array_push($arr, ['delayed' => "$delayed", 'day_no' => "$day_no", 'hour_no' => "$hour_no", 'min_no' => "$min_no", 'sec_no' => "$sec_no"]);
            }
            else
            {
                array_push($arr, ['delayed' => $delayed, 'day_no' => $day_no, 'hour_no' => $hour_no, 'min_no' => $min_no, 'sec_no' => $sec_no]);
            }
        }
        elseif ($type == 'w')
        {
            $week_no = (int)floor($respite / (7 * 86400));
            $respite -= ($week_no * 7 * 86400);
            $day_no = (int)floor($respite / 86400);
            $hour_no = (int)floor(($respite % 86400) / 3600);
            $min_no = (int)floor((($respite % 86400) % 3600) / 60);
            $sec_no = (int)floor(($respite % 86400) % 3600) % 60;
            if ($api)
            {
                array_push($arr, ['delayed' => "$delayed", 'day_no' => "$day_no", 'hour_no' => "$hour_no", 'min_no' => "$min_no", 'sec_no' => "$sec_no"]);
            }
            else
            {
                array_push($arr, ['delayed' => $delayed, 'day_no' => $day_no, 'hour_no' => $hour_no, 'min_no' => $min_no, 'sec_no' => $sec_no]);
            }
        }
        return $arr;
    }
}
if (!function_exists('hamahang_convert_respite_to_timestamp'))
{
    /*
     * @param int $mon
     * @param int $week
     * @param int $day
     * @param int $hour
     * @param int $min
     * @param int $sec
     */
    function hamahang_convert_respite_to_timestamp($mon = 0, $week = 0, $day = 0, $hour = 0, $min = 0, $sec = 0)
    {
        return ($mon * 30 + $week * 7 + $day) * 86400 + ($hour * 3600) + ($min * 60) + $sec;
    }
}
if (!function_exists('hamahang_make_task_respite'))
{
    function hamahang_make_task_respite($input_date, $input_time)
    {
        $cTime = time();
        $date = new \jDateTime();
        date_default_timezone_set('Asia/Tehran');
        $date_to_split = explode('-', $input_date);
        $time_to_split = explode(':', $input_time);
        $respite_timestsmp = $date->mktime($time_to_split[0], $time_to_split[1], '0', $date_to_split['1'], $date_to_split[2], $date_to_split[0]);
        $timestamp_diff = $respite_timestsmp - $cTime;
        //array_push($arr,['respite'=>$timestamp_diff]);
        return $timestamp_diff;
    }
}
if (!function_exists('get_project_task_relation_name'))
{
    function get_project_task_relation_name($id)
    {
        $relation_name = '';
        switch ($id)
        {
            case 0:
            {
                $relation_name = 'شروع به شروع';
                break;
            }
            case 1:
            {
                $relation_name = 'شروع به پایان';
                break;
            }
            case 2:
            {
                $relation_name = 'پایان به شروع';
                break;
            }
            case 3:
            {
                $relation_name = 'پایان به پایان';
                break;
            }
        }
        return $relation_name;
    }
}
if (!function_exists('GetTaskStatusName'))
{
    function GetTaskStatusName($id)
    {
        $status_name = '';
        switch ($id)
        {
            case 0:
            {
                $status_name = trans('tasks.status_not_started');
                break;
            }
            case 1:
            {
                $status_name = trans('tasks.status_started');
                break;
            }
            case 2:
            {
                $status_name = trans('tasks.status_done');
                break;
            }
            case 3:
            {
                $status_name = trans('tasks.status_finished');
                break;
            }
            case 4:
            {
                $status_name = trans('tasks.status_suspended');
                break;
            }
        }
        return $status_name;
    }
}
if (!function_exists('hamahang_add_keyword'))
{
    function hamahang_add_keyword($keyword)
    {
        $keyword_id = '';
        if (substr($keyword, 0, 8) == 'exist_in')
        {
            $keyword_id = (int)substr($keyword, 8);
        }
        else
        {
            $keyword_id = keywords::add_new_keyword($keyword);
        }
        return $keyword_id;
    }
}
//----------------End-------------- Tasks / Projects / Process -------------------End---------------//