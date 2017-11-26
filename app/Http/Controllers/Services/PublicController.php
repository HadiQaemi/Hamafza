<?php

namespace App\Http\Controllers\Services;

use DB;
use Request;
use Validator;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{

    public function GetSites()
    {
        try
        {
            $sites = DB::table('sites')->select(DB::Raw('name,url'))->get();
            return response()->json(['sites' => $sites, 'status' => "1"], 200)->header('Content-Type', 'text/plain');
        } catch (JWTException $e)
        {
            return response()->json(['sites' => 'failed', 'status' => "-1"], 200)->header('Content-Type', 'text/plain');
        }
    }

    public function GetPortals()
    {
        $validator = Validator::make(Request::all(), [
            'token' => 'required'
        ]);
        if ($validator->fails())
        {
            $error = validation_error_to_api_json($validator->errors());
            $res =
                [
                    'status' => "-1",
                    'error' => $error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token')) && !CheckTokenGustMode(Request::input('token')))
        {
            $res =
                [
                    'status' => "-1",
                    'error' => [['e_key' => 'token', 'e_values' => ['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $res =
            [
                'status' => "1",
                'main' => ['type' => '15', 'url' => 'api/v43/get_page_detail', 'data' => Get_Portals()]
            ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

}
