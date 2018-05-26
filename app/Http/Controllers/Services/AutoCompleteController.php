<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\hamafza\keyword;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\ACL\AclCategory;
use App\Models\Hamahang\OrgChart\org_chart_items;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\ProvinceCity\City;
use App\Models\Hamahang\ProvinceCity\Province;
use App\Models\Hamahang\Tasks\tasks;
use App\Role;
use Auth;
use Request;
use App\User;
use DB;


class AutoCompleteController extends Controller
{
    
    public function keywords()
    {
        $data = Request::input('term');
        if ($data == '...')
        {
            $res ['results'] = DB::table('keywords')
                ->select("id", "title as text")->get();
        }
        else
        {
            $res ['results'] = DB::table('keywords')
                ->select("id", "title as text")
                ->where("title", "LIKE", "%" . $data . "%")->get();
        }
        /*foreach ($res ['results'] as $keyword)
        {
            $keyword->id = ($request->exists('exist_in') ? $request->exist_in : 'exist_in') . $keyword->id;
        }*/
        return response()->json($res);
    }
    
    public function userslist()
    {
        $data = Request::input('term');
        if ($data == '...')
        {
            $data = User::all(["id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text')]);
        }
        else
        {
            $data2 = User::select("id", DB::raw('CONCAT(Name, " ", Family, " (", Uname, ")") AS text'))
                ->where("Name", "LIKE", "%" . $data . "%")
                ->Orwhere("Family", "LIKE", "%" . $data . "%")
                ->Orwhere("Uname", "LIKE", "%" . $data . "%")
                ->Orwhere("Email", "LIKE", "%" . $data . "%")
                ->get();
        }
        $data2 = array('results' => $data2);
        return response()->json($data2);
    }

   
}