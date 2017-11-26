<?php

namespace App\HamafzaGrids;

use App\HamafzaPublicClasses\GridClass;
use Illuminate\Support\Facades\DB;

class UsersGrids {

    public static function Alerts($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("ss", 'uname');
        $GC->AddHidenCol("id", 'id');
        $GC->AddColPop('عنوان', 'subject2', 'id', 'title', '200', false, 'notification', 'right');

        $GC->AddCol("تاریخ", 
                'sendate', '50');
        $GC->AddColDelete('حذف', 'id', 'alert', '20', false, 'right');

        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function UsersAc($data) {
        $GC = new GridClass('pop');
        $GC->AddHidenCol("id", 'id');
        $GC->AddHidenCol("id", 'uname');
        $GC->AddCol('نام و نام خانوادگی', 'FullNaME', '200', false, 'right');

        $GC->AddCol('تاریخ عضویت', 'reg_date', '35', false, 'right');
        $s = $GC->popGrid(json_encode($data));
        return $s;

        $grid = \DataGrid::source($data)->paginate(300)->getSet();
        $grid->add('sortid', 'ردیف')->style("width:100px");
        $grid->add('id', 'ID', true)->style("display:none");

        $grid->add('FullNaME', 'نام و نام خانوادگی');
        $grid->add('reg_date', 'تاریخ عضویت');
        $grid->add('edit', 'ویرایش');
        $grid->paginate(300);
        $grid->row(function ($row) {
            $uname = Session::get('Uname');
            $uname = $uname['0'];
//            $row->cell('edit')->value = '<div style="height:10px;"><a href="user_list/edit?id=' . $row->cell('id')->value . '"><span class="fonts icon-alamatgozari" ></span> </a></div>';
            $row->cell('edit')->value = '<div style="height:10px;"><a href="'. route('ugc.desktop.hamahang.user_list.edit',[]) . '?id' .'"><span class="fonts icon-alamatgozari" ></span> </a></div>';
            $row->cell('id')->style("display:none");
        });

        return $grid;
    }

    public static function AnnoGrid($data) {
        $res = '';
        foreach ($data as $row) {
            $title = $row['title'];
            $title1 = $row['title'];
            if ($row['kind'] != 3 && $row['kind'] != 4)
                $title1 .= '- در صفحه';
            $title2 = $title . ' : در صفحه';
            $page_url = "/" . $row['pid'] . "/" . $title1 . "/";
            $quote = '';
            $link = '<a rel="canonical" href="' . $page_url . '" target="_blank">' . $title . '</a>';
            if ($row['quote'] != '') {
                $quote = '<span style="color:red;"> « ' . $row['quote'] . ' » </span>';
            }
            $comment = '<br/>' . $row['comment'];
            $delname = 'حذف';
            $res.= '<div class="addcomment"><div class="comment-contain"><div class="comment-box"><div class="name"><a target="_blank" href="' . $link . '">' . $title2 . '</a></div>';
            $res.= '<div class="text">' . $quote . $comment . '<div style="margin:5px; "></div></div> <div class="clear"></div> </div><div class="like-box40"><div class="firstRow"> <div class="pull-left left-detail PostDate"><span class="FloatLeft fonts icon-hazv  PostDelicn" page="Post" action="delete" id="471"></span></div></div></div></div></div></div>';
        }
        return $res           // echo '<tr id="Anndelete_'.$row['id'].'"><td>'.$i.'</td><td>'.$comment.'</td><td>'.$link.'</td><td>'.$admins->tep_hejri1($row['reg_date']).'</td><td><span class="FontIcons DelIcon checks" data-icon="&#xe6bb"  page="user_announces" action="delete" id="'.$row['id'].'" name="'.$delname.'" style="border:0px; cursor:pointer"></span></td></tr>' ;
        ;
    }

    public static function Users($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("ss", 'uname');
        $GC->AddColLink('نام و نام خانوادگی', 'Fullname', 'name', 'Fullname', '200', false, '_blank', 'right');
        $GC->AddCol('نام کاربری', 'name', '50');
        $GC->AddCol('تاریخ عضویت', 'Reg_date', '50');
        $GC->AddHidenCol("id", 'id');
        $GC->AddColEdit('ویرایش', 'id', route('ugc.desktop.hamahang.user_list.edit') . '?id=', '20', false, 'right');
        $GC->AddColDelete('حذف', 'id', 'user_list', '20', false, 'right');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function UserSecurity($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddCol("نام سطح دسترسی", 'name', '200');
        $GC->AddColPop('کاربران', 'cnt', 'id', 'name', '35', false, 'getaccessusers', 'center');
        $GC->AddCol('پیش فرض', 'defualt', '50');
                $GC->AddColEdit('ویرایش', 'id', 'user_security/edit?id=', '20', false, 'right');

        $GC->AddColDelete('حذف', 'id', 'alert', '20', false, 'right');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function UserGroup($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddColLink('نام گروه', 'name', 'link', 'name', '200', false, '_blank', 'right');
        $GC->AddCol('تاریخ ایجاد', 'reg_date', '50');
        $GC->AddCol('تعداد اعضا', 'memcount', '50');
        $GC->AddCol('تعداد پست‌ها', 'postcount', '50');
        $GC->AddColDelete('حذف', 'id', 'alert', '20', false, 'right');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function UserOrgan($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddColLink('نام کانال', 'name', 'name', 'name', '200', false, '_blank', 'right');
        $GC->AddCol('تاریخ ایجاد', 'reg_date', '50');
        $GC->AddCol('تعداد اعضا', 'memcount', '50');
        $GC->AddCol('تعداد پست‌ها', 'postcount', '50');
        $GC->AddColDelete('حذف', 'id', 'alert', '20', false, 'right');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

    public static function alertGroup($data) {
        $GC = new GridClass();
        $GC->AddHidenCol("id", 'id');
        $GC->AddCol('عنوان', 'name', '150');
        $GC->AddColEdit('ویرایش', 'id', 'alerts/edit?id=', 20, false, 'right');
        $GC->AddColDelete('حذف', 'id', 'Alert', '20', false, 'right');
        $s = $GC->Grid(json_encode($data));
        return $s;
    }

}
