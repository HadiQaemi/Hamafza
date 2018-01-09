<?php

if (!function_exists('d'))
{
    function d(...$args)
    {
        http_response_code(500);
        dd($args);
    }
}

if (!function_exists('enCode'))
{

    function enCode($var)
    {
        $EncryptString = new App\HamahangCustomClasses\EncryptString;
        $result = $EncryptString->encode($var);
        return trim($result);
    }

}

if (!function_exists('deCode'))
{

    function deCode($var)
    {
        $EncryptString = new App\HamahangCustomClasses\EncryptString;
        $result = $EncryptString->decode($var);
        return trim($result);
    }

}
if (!function_exists('HConvertNumbersFatoEn'))
{
    function HConvertNumbersEntoFa($matches)
    {
        $farsi_array = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($english_array, $farsi_array, $matches);
    }
}
if (!function_exists('HConvertNumbersFatoEn'))
{
    function HConvertNumbersFatoEn($matches)
    {
        $farsi_array = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($farsi_array, $english_array, $matches);
    }
}
if (!function_exists('HJDate'))
{
    function HJDate($format = "Y/m/d-H:i", $numberType = "fa", $stamp = false, $convert = null, $jalali = false, $timezone = "Asia/Tehran")
    {
        if (!$stamp)
        {
            $stamp = time();
        }
        $date = new App\HamahangCustomClasses\jDateTime();
        $res = $date->date($format, $stamp, $convert, $jalali, $timezone);
        if ($numberType != "fa")
        {
            $res = HConvertNumbersFatoEn($res);
        }
        return $res;
    }
}
if (!function_exists('HDate_GtoJ'))
{

    function HDate_GtoJ($GDate, $Format = "Y/m/d-H:i", $convert = true)
    {
        $date = new App\HamahangCustomClasses\jDateTime($convert, true, 'Asia/Tehran');
        $time = is_numeric($GDate) ? strtotime(date('Y-m-d H:i:s', $GDate)) : strtotime($GDate);
//        dd($date->date($Format, $time));
        return $date->date($Format, $time);
    }

}
if (!function_exists('HDate_JtoG'))
{
    function HDate_JtoG($jDate, $delimiter = '/', $to_string = false)
    {
        $jDate = HConvertNumbersFatoEn($jDate);
        $date = explode($delimiter, $jDate);
        $r = App\HamahangCustomClasses\jDateTime::toGregorian($date[0], $date[1], $date[2]);
        if ($to_string)
        {
            $r = $r[0] . $delimiter . $r[1] . $delimiter . $r[2];
        }
        return ($r);
    }
}
if (!function_exists('get_all_descendant_from_flat_array'))
{
    function get_all_descendant_from_flat_array($f_array, $parent_id, $just_array = true, $item_id = 'id', $idKey = 'parent_id', $children_key = 'chi')
    {
        $fnBuilder = function ($res, $pid) use (&$fnBuilder, $f_array, $idKey, $children_key, $just_array, $item_id)
        {
            foreach ($f_array as $item)
            {
                if ($item[$idKey] == $pid)
                {
                    if ($just_array)
                    {
                        $res[] = $item[$item_id];
                    }
                    else
                    {
                        $res[] = $item;
                    }

                    $res = $fnBuilder($res, $item['id']);
                }
            }
            return $res;
        };
        $descendants = $fnBuilder([], $parent_id);
        return $descendants;
    }
}
if (!function_exists('buildTree'))
{

    /**
     * @param array $flat_array
     *     sometimes a boolean, sometimes a string (or, could have just used "mixed")
     * @param $pidKey
     * @param int $parent
     * @param string $idKey
     * @param string $children_key
     * @return mixed
     */
    function buildTree($flat_array, $pidKey, $parent = 0, $idKey = 'id', $children_key = 'children', $make_unique = false)
    {
        if (empty($flat_array))
        {
            return [];
        }

        if ($make_unique)
        {
            foreach ($flat_array as $v)
            {
                $uniques[$v['id']] = $v;
            }
            $unique = array_values($uniques);
            $flat_array = $unique;
        }

        $grouped = array();
        foreach ($flat_array as $sub)
        {
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key)
        {
            foreach ($siblings as $k => $sibling)
            {
                $id = $sibling[$idKey];
                if (isset($grouped[$id]))
                {
                    $sibling[$children_key] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };
        $tree = $fnBuilder($grouped[$parent]);
        return $tree;
    }

}
if (!function_exists('can'))
{

    /**
     * @param $permission String
     * @param int $code
     * @param string $message
     * @param array $headers
     */
    function can($permission, $code = 403, $message = '', array $headers = [])
    {
        abort_unless(Auth::user()->can($permission), $code, $message, $headers);
    }

}
if (!function_exists('apiCan'))
{

    /**
     * @param $permission string
     * @return bool
     */
    function apiCan($permission)
    {
        if (!Auth::user()->can($permission))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

}
if (!function_exists('sort_arr'))
{
    function sort_arr($items)
    {
        $count = count($items);
        $m = null;
        $key = null;
        $sorted_res = [];
        if (isset($items) && is_array($items) && !empty($items))
        {
            for ($i = 0; $i < $count; $i++)
            {
                $m = [];
                $first_item = true;
                foreach ($items as $k => $item)
                {

                    if ($first_item)
                    {
                        $m = $item;
                        $key = $k;
                    }
                    else
                    {
                        if ($item['order'] < $m['order'])
                        {
                            $m = $item;
                            $key = $k;
                        }
                    }
                    $first_item = false;
                }
                unset($items[$key]);
                $sorted_res[] = $m;
            }
        }
        return $sorted_res;
    }
}
