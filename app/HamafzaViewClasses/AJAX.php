<?php

namespace App\HamafzaViewClasses;

use Illuminate\Support\Facades\DB;
use Auth;
use App\HamafzaServiceClasses\SubjectsClass;

class AJAX {
    public static function GetUserContentPaging($content) {
        $res = '';
        if (is_array($content) && count($content) > 0) {
            foreach ($content as $item) {
                $res.='<div class="comment-contain" postid="' . $item['id'] . '">';
                $res.='<div class="comment-box">';
                if (array_key_exists('OrganPic', $item) && $item['OrganPic'] != '') {
                    $pic = 'pics/group/Groups.png';
                    if (trim($item['OrganPic']) != '' && file_exists('pics/group/' . $item['gid'] . '-' . $item['OrganPic']))
                        $pic = 'pics/group/' . $item['gid'] . '-' . $item['OrganPic'];
                    else if (trim($item['OrganPic']) != '' && file_exists('pics/group/' . $item['OrganPic']))
                        $pic = 'pics/group/' . $item['OrganPic'];
                    $name = $item['OrganName'];
                    $link = $item['Organlink'];
                }
                else {
                    $pic = 'pics/user/Users.png';
                    if (trim($item['Pic']) != '' && file_exists('pics/user/' . $item['uid'] . '-' . $item['Pic']))
                        $pic = 'pics/user/' . $item['uid'] . '-' . $item['Pic'];
                    else if (trim($item['Pic']) != '' && file_exists('pics/user/' . $item['Pic']))
                        $pic = 'pics/user/' . $item['Pic'];
                    $name = $item['Name'] . ' ' . $item['Family'];
                    $link = $item['Uname'];
                }

                $res.=' <img src="' . url('/') . '/' . $pic . '" class="avatar"  title="' . $name . '" data-placement="top" data-toggle="tooltip">
            <div class="name"><a href="' . url('/') . '/' . $link . '" target="_blank">' . $name . '</a></div>';
                $res.='<div class="text">';
                if ($item['title'] != '') {
                    $res.= $item['type'] . ': ' . $item['title'] . '<br>';
                }
                if (!array_key_exists('OrganPic', $item) && ($item['InsertedGroup'] != '' || $item['InsertedOrgan'] || $item['InsertedSubject'] )) {
                    $res.=' درج شده در';
                    if ($item['InsertedGroup'] != '')
                        $res.='     گروه  <a target="_blank" href="' . url('/') . '/' . $item['InsertedGrouplink'] . '">' . $item['InsertedGroup'] . '</a>،';
                    if ($item['InsertedOrgan'] != '')
                        $res.='  کانال   <a target="_blank" href="' . url('/') . '/' . $item['InsertedOrganlink'] . '">' . $item['InsertedOrgan'] . '</a>، ';

                    if ($item['InsertedSubject'] != '')
                        $res.=' صفحه   <a target="_blank" href="' . url('/') . '/' . $item['InsertedSubjectlink'] . '">' . $item['InsertedSubject'] . '</a>';
                    $res.=' <br>';
                }
                if ($item['pic'] != '')
                    $res.='  <img src="' . url('/') . '/uploads/' . $item['pic'] . '" style="max-width: 600px"><br>';
                $res.=$item['desc'];

                $res.='  <div style="margin:5px; ">';
                if (array_key_exists("keywords", $item) && is_array($item['keywords']))
                    foreach ($item['keywords'] as $items)
                        $res.='<div class="FaqTags" id="Key_' . $items['id'] . '">' . $items['keyword'] . '</div>';
                $res.='</div>';
                $res.=' </div><div class="clear"></div></div>';
                if ($item['likes'] != '0')
                    $res.='<div class="like-box">';
                else
                    $res.='  <div class="like-box40">';
                $res.='   <div class="firstRow">';
                if ($item['islike'])
                    $res.=' <span class="PostLike" like="0" postid="' . $item['id'] . '">حذف پسند </span>';
                else
                    $res.='  <span class="PostLike" like="1"  postid="' . $item['id'] . '">پسند </span>';

                $res.='  - <span  postid="Comment_' . $item['id'] . '" class="Comment_Foc" >اظهار نظر</span> - <span>بازنشر</span>
                    <div class="pull-left left-detail PostDate">';
                if (session('uid') == $item['uid'])
                    $res.=' <span  id="' . $item['id'] . '" action="delete" page="Post" class="FloatLeft fonts icon-hazv  PostDelicn"></span>';
                $res.=$item['reg_date'] . ' </div></div>';

                if ($item['likes'] != '0') {
                    $res.='  <div class="secondRow">
                    <span id="LikeCounter_' . $item['id'] . '">' . $item['likes'] . ' </span> نفر این مطلب را ';
                    if ($item['likes'] != '1')
                        $res.='     پسندیده‌اند';
                    else
                        $res.='   پسندید';
                    $res.='   </div>';
                }


                $res.='   </div>';
                if (is_array($item['comments'])) {
                    foreach ($item['comments'] as $items) {
                        $res.='   <div class="addcomment commentShow">
                <input class="Postid" value="' . $items['id'] . '" type="hidden" >';

                        $pics = 'pics/user/Users.png';
                        if (trim($items['Pic']) != '' && file_exists('pics/user/' . $items['uid'] . '-' . $items['Pic']))
                            $pics = 'pics/user/' . $items['uid'] . '-' . $items['Pic'];
                        else if (trim($items['Pic']) != '' && file_exists('pics/user/' . $items['Pic']))
                            $pics = 'pics/user/' . $items['Pic'];

                        $res.=' <a target="_blank" href="' . $items['Uname'] . '"> <img class="imgContain" title="' . $items['Name'] . ' ' . $items['Family'] . '" data-placement="top" data-toggle="tooltip" src="' . url('/') . '/' . $pics . '"></a>';
                        $res.=' <div class="txtContain">' . $items['comment'] . '</div><span class="CommentTime">' . $items['reg_date'];

                        if (session('uid') == $items['uid'])
                            $res.='<span class="FloatLeft fonts icon-hazv CommentDelicn" page="comment" action="delete" id="' . $items['id'] . '"></span>';

                        $res.=' </span></div>';
                    }
                }



                if (session('Login') && session('Login') == 'TRUE')
                    $res.='<div class="addcomment">
                <input class="Postid" value="' . $item['id'] . '" type="hidden" >
                <img class="imgContain" src="' . url('/') . '/' . session('pic') . '">
                <div class="txtContain"><input Class="CommentSend" postid="' . $item['id'] . '" id="Comment_' . $item['id'] . '" type="text" placeholder="نظرتان را بنویسید"></div>
            </div>';
                $res.=' </div>';
            }
        }
        return $res;
    }

}
