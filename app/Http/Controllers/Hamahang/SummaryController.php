<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\BasicdataValue;
use App\Models\Hamahang\Score;
use Request;
use DB;
use Datatables;

class SummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // get
    public function index($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.Summary.index', $arr);
    }

    // post
    public function get_values_groups()
    {
        $eloquent = Score::where('uid', auth()->id())->with('default_value')->select('type_value_id', DB::raw('COUNT(*) AS count, SUM(hamahang_scores.value) AS total'))->groupBy('type_value_id');
        return Datatables::eloquent($eloquent)->addColumn('title', function(Score $score) { return $score->default_value->title; })->make(true);
    }

    public function get_values()
    {
        $type_value_id = Request::input('id');
        $eloquent = Score::where('uid', auth()->id())->where('type_value_id', $type_value_id)->with('default_value');
        return Datatables::eloquent($eloquent)
            ->addColumn('href', function($data)
            {
                $href = '-1';
                switch ($data->target_table)
                {
                    case 'App\Models\hamafza\Post':
                        $result = DB::table('posts')->where('id', $data->target_id)->first() ? : [];
                        $url = route('contents.UserContents', ['Uname' => auth()->user()->Uname]);
                        $href = $result ? "$url#$data->target_id" : $href;
                    break;
                    case 'App\Models\hamafza\Subject':
                        $href = url('/' . ($data->target_id * 10));
                    break;
                }
                return $href;
            })
            ->make(true);
    }

    public function get_values_jspanel()
    {
        $id = Request::input('id');
        $basicdata_value = BasicdataValue::find($id);
        $r = json_encode(
        [
            'header' => 'مشاهده جزئیات ' .  "<span style='color: #6ec565;'>$basicdata_value->title</span>",
            'content' => view('hamahang.Summary.helper.sublist')->with(['id' => $id])->render(),
            'footer' => view('hamahang.Summary.helper.sublist-footer')->render()
        ]);
        return $r;
    }

}

