<?php

namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;

class Alerts {

    public static function GetAlerts($uid) {

        return DB::table('emails')->where('uid', $uid)->Orderby("id", 'desc')->take(5)->get();
    }

    public static function Message($uid, $cuid) {
        $user = Alerts::User($cuid);
        $ugname = $user->Name . ' ' . $user->Family;
        $Type = "SMS_NEW";
        $userH = Alerts::User($uid);
        $uemail = $userH->email;
        $links = $userH->Uname;
        $subject2 = " پیام جدید";
        $subject = "$ugname یک پیام جدید برای شما ارسال کرده است.";
        $body = "برای شما یک پیام جدیدارسال شده است جهت بررسی آن می توانید به لینک زیر مراجعه نمایید.";
        $link = config('constants.SiteAddress') . $links . '/desktop/inbox';
        Alerts::InsertDB($uid, $subject2, $body, $Type, $subject, $link);
        return Alerts::Email($subject, $body, $link, $uemail);
    }

    public static function Measure($uid, $cuid, $bc) {

        $user = Alerts::User($cuid);
        $ugname = $user->Name . ' ' . $user->Family;
        $Type = "Eghdam_NEW";
        $userH = Alerts::User($uid);
        $uemail = $userH->email;
        $links = $userH->Uname;
        if ($bc == '1') {
            $subject2 = " وظیفه جدید";
            $subject = "$ugname یک وظیفه جدید به شما ارجاع داده است.";
            $body = "برای شما یک وظیفه جدید تعرف شده است جهت بررسی آن می توانید به لینک زیر مراجعه نمایید.";
        } else {
            $subject2 = "رونوشت - وظیفه جدید";
            $subject = "$ugname یک وظیفه جدید به شما رونوشت کرده است.";
            $body = "برای شما یک وظیفه جدید رونوشت شده است جهت بررسی آن می توانید به لینک زیر مراجعه نمایید.";
        }
        $link = config('constants.SiteAddress') . $links . '/desktop/user_measures_ME';
        Alerts::InsertDB($uid, $subject2, $body, $Type, $subject, $link);
        return Alerts::Email($subject, $body, $link, $uemail);
    }

    public static function endors($pecialid, $cuid) {
        $user = Alerts::User($cuid);
        $special = DB::table('user_special')->where('id', $pecialid)->select('name', 'user_id')->first();
        $username = $user->Name . ' ' . $user->Family;


        if ($special) {
            $uid = $special->uid;
            $userH = Alerts::User($uid);
            $uemail = $userH->email;

            $jobTitle = $special->name;
            $desc = "$username  تخصص  ($jobTitle)  شما را صحه گذاری کرده است.";
        }
        $desc = "$username  تخصص  ($jobTitle)  شما را صحه گذاری کرده است.";
        $Type = "Endorse_Add";
        $subject = $desc;
        $subject2 = "صحه گذاری تخصص های من";
        $user = Alerts::User($uid);
        $links = $user->Uname;
        $link = config('constants.SiteAddress') . '/' . $links;
        $body = "$desc جهت مشاهده آن می توانید به لینک زیر مراجعه نمایید.";
        Alerts::InsertDB($uid, $subject2, $body, $Type, $subject, $link);

        return Alerts::Email($subject, $body, $link, $uemail);
    }

    public static function endorsremove($pecialid, $cuid) {
        $user = Alerts::User($cuid);
        $special = DB::table('user_special')->where('id', $pecialid)->select('name', 'user_id')->first();
        $username = $user->Name . ' ' . $user->Family;
        if ($special) {
            $uid = $special->uid;
            $userH = Alerts::User($uid);
            $uemail = $userH->email;
            $jobTitle = $special->name;
            $desc = "$username صحت تخصص($jobTitle) شما را حذف کرد";
        }
        $desc = "$username صحت تخصص($jobTitle) شما را حذف کرد";
        $Type = "Endorse_Remove";
        $subject = $desc;
        $subject2 = "حذف صحه گذاری تخصص های من";
        $user = Alerts::User($uid);
        $links = $user->Uname;
        $link = config('constants.SiteAddress') . '/' . $links;
        $body = "$desc جهت مشاهده آن می توانید به لینک زیر مراجعه نمایید.";
        Alerts::InsertDB($uid, $subject2, $body, $Type, $subject, $link);
        return Alerts::Email($subject, $body, $link, $uemail);
    }

    public static function User($uid) {
        $user = DB::table('user as u')->join('users as s', 's.id', '=', 'u.user_id')->where('u.id', $uid)->select('u.Name', 'u.Family', 'u.Uname', 's.email')->first();
        return $user;
    }

    public static function InsertDB($uid, $subject2, $body, $Type, $subject, $link) {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);

        DB::table('emails')->Insert(array('uid' => $uid, 'subject' => $subject2, 'body' => $body
            , 'sendate' => $reg_date, 'type' => $Type, 'subject2' => $subject, 'link' => $link));
    }

    public static function Email($subject, $body, $link, $email) {

        return Mail::send('emails.alerts', array('body' => $body, 'title' => $subject, 'link' => $link), function($message) use ($email, $subject) {
                    $message->to($email)->subject($subject);
                });
    }

}
