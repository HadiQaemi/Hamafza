<?php

namespace App\HamafzaPublicClasses;

use Illuminate\Support\Facades\DB;

class FunctionsClass {

    public static function CratePagelink($pid,$whttp=true) {
        $AllowPreCode = config('constants.AllowPreCode');
        $PreCode = config('constants.PreCode');
        if ($AllowPreCode)
            return ($whttp==true)?url('/') . "/$PreCode-$pid":"$PreCode-$pid";
        else
           return ($whttp==true)?url('/') . "/$pid":"$pid";
    }

    public function GetSiteMenu() {
        return DB::table('departments')->where('view', '1')->select('id', 'name as title', 'pid')->orderBy('orders')->get();
    }

    public static function JSON($data, $err) {

        return response()->json([
                    'error' => $err,
                    'data' => $data
        ]);
    }

    public static function Ostan() {
        $province = DB::table('province')->get();
        foreach ($province as $value) {
            $city = DB::table('city')->where('pid', $value->id)->get();
            $value->shahr = $city;
        }
        return $province;
    }

    public static function UserName2id($name) {
        $User = DB::table('user')->where('Uname', $name)->select('id')->first();
        if ($User)
            return $User->id;
        else
            return 0;
    }

}
