<?php

namespace App\HamafzaGrids;

use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;

class MessageDataGrid
{

    public static function inbox($data)
    {
        //dd($data);
        $GC = new GridClass();
        $GC->AddHidenCol("ss", 'uname');
        $GC->AddHidenCol("tid", 'tid');
        $GC->AddColPopMEs('فرستنده', 'Fname', 'tid', 'title', '50', false, 'viewmessage', 'right','sid','','پیام دریافتی');
        $GC->AddColPopMEs('عنوان', 'title', 'tid', 'title', '200', false, 'viewmessage', 'right','sid','','پیام دریافتی');
        $GC->AddAtachCol("پیوست", 'attach', '15');
        $GC->AddCol("تاریخ", 'reg_date', '35');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }


    public static function outbox($data)
    {
        //dd($data);
        $GC = new GridClass();
        $GC->AddHidenCol("ss", 'uname');
        $GC->AddHidenCol("tid", 'tid');
         $GC->AddColPopMEs('فرستنده', 'Fname', 'tid', 'title', '50', false, 'viewmessage', 'right','sid','','پیام ارسالی');
        $GC->AddColPopMEs('عنوان', 'title', 'tid', 'title', '200', false, 'viewmessage', 'right','sid','','پیام ارسالی');
        $GC->AddAtachCol("پیوست", 'attach', '15');
        $GC->AddCol("تاریخ", 'reg_date', '35');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

}
