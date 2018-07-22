<?php
namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\SubjectType;
use App\Models\Hamahang\LogRequest;
use App\Models\Hamahang\OrgChart\org_chart_items;
use App\Models\Hamahang\OrgChart\org_charts;
use App\Models\Hamahang\OrgChart\org_charts_items_posts;
use App\Models\Hamahang\OrgChart\org_organs;
use DB;
use Datatables;
use Validator;
use Request;

class ChartsController extends Controller
{

    public function chartCountry(Request $request)
    {

        $countris = LogRequest::groupBy('iso_code')->select('iso_code', DB::raw('count(*) as total'))->get();
//        dd($countris);
        foreach ($countris as $country)
        {
            $arr['country'][] = array('name' => $country->country_name, 'y' => $country->total, 'drilldown' => $country->country_name);
        };

        foreach ($countris as $country)
        {
            $citis = LogRequest::where('iso_code', $country->iso_code)->groupBy('city')->select('city', DB::raw('count(*) as total'))->get();
            $data = [];
            foreach ($citis as $city)
            {
                $cus_city = $city->city;
                if($city->city == 'Ahvaz')
                    $cus_city= 'Khuzestan';
                $data[] = [$cus_city, $city->total];

            }
            $arr['city'][] = array('name' => $country->country_name, 'id' => $country->country_name, 'data' => $data);
        };
//$arr[][] = array($city->city,$country->total,'drilldown'=>$country->country);
        return json_encode($arr);
    }

    public function getCharts($username)
    {
        $arr= variable_generator('user','desktop',$username);
        return view('hamahang.Chart.chart',$arr);
    }

    public function subjectsChart()
    {
        $subject_types = SubjectType::whereHas('subjects')->withCount('subjects')->get();
        foreach ($subject_types as $subject_type)
        {
            $arr['subjects'][] = array('name' => $subject_type->name, 'y' => $subject_type->subjects_count);
        };
        return json_encode($arr);
    }
    public function InsertChart(Request $request)
    {
        $validator = Validator::make(Request::all(),
            [
                'chart_name' => 'required',
                'organs_id'=>'required|exists:hamahang_org_organs,id'
            ],
            [],
            [
                'chart_name' => 'نام چارت ',
                'organs_id' => 'سازمان '
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $chart_name = Request::get('chart_name');
            $chart_description = Request::get('chart_description');
            $organs_id=Request::get('organs_id');
            org_charts::create([
                'uid' => auth()->id(),
                'org_organs_id' => $organs_id,
                'title' => $chart_name,
                'description' => $chart_description,

            ]);
            $result['success'] = true;
        }
        return json_encode($result);
    }
    public function ListCharts(Request $request)
    {
        $validator = Validator::make(Request::all(),
            [
                'org_id' => 'required|exists:hamahang_org_organs,id',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
        $charts = org_charts::with('creator')->where('org_organs_id',Request::get('org_id'));
        return Datatables::eloquent($charts)->make(true);
        }
    }
    public function ListPost(Request $request)
    {
        $validator = Validator::make(Request::all(),
            [
                'chart_item_id' => 'required|exists:hamahang_org_charts_items,id',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $charts_post_item = org_charts_items_posts::with('Employee')->where('chart_item_id',Request::get('chart_item_id'));
            return Datatables::eloquent($charts_post_item)->make(true);
        }
    }
    public function ListOrganChartItem()
    {
        $validator = Validator::make(Request::all(),
            [
                'chart_item_id' => 'required|exists:hamahang_org_charts_items,id',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $charts_item = org_chart_items::where('parent_id',Request::get('chart_item_id'));
            return Datatables::eloquent($charts_item)->make(true);
        }
    }
    public function deletechart()
    {

        $validator = Validator::make(Request::all(),
            [
                'chart_id' => 'required|exists:hamahang_org_charts,id',
            ]
        );
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else{
            $chart=org_charts::destroy(Request::input('chart_id'));
            $result['success'] = true;
            return json_encode($result);
        }
    }
}