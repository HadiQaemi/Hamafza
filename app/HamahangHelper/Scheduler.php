<?php
//----------------Begin-------------- Scheduler -------------------Begin---------------//
function p($input = null, $continue = false, $pre = true, $return = false)
{
    $t = array
    (
        'raw' => '%s',
        'pre' => "<pre>\n%s\n</pre>\n",
    );
    $input_final = print_r($input, true);
    $PRE_r = sprintf($pre ? $t['pre'] : $t['raw'], $input_final);
    $r = print_r($PRE_r, true);
    if ($return)
    {
        return ($r);
    }
    else
    {
        print_r($r);
        if ($continue)
        {

        }
        else
        {
            exit(0);
        }
    }
}

function get_page_title($is_members = false)
{
    $rn = Route::getCurrentRoute()->getPath();
    $explode = explode('/', $rn);
    $key = ($is_members ? 'members/' : null) . "forms.$explode[1]";
    if (Lang::has($key))
    {
        echo '<b>/ ' . trans($key) . '</b>';
    }
    else
    {

    }
}

function get_date_diff($start, $end)
{
    $datetime1 = new DateTime($start);
    $datetime2 = new DateTime($end);
    $r = $datetime1->diff($datetime2);
    return ($r);
}

function get_persian_weekday($weekday)
{
    $weekdays = array(6 => 0, 0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6);
    $r = $weekdays[$weekday];
    return ($r);
}

function get_date_diff_mounts(DateInterval $date_interval, $round_mount = true)
{
    $r = 0;
    $r += $date_interval->y * 12;
    $r += $date_interval->m;
    $r += $round_mount ? $date_interval->d > 27 ? 1 : 0 : 0;
    return ($r);
}

//----------------End-------------- Scheduler -------------------End---------------//