<?php

namespace App\Http\Controllers\Hamahang;

use Request;
use Validator;
use Datatables;
use App\Models\Hamahang\Score;
use App\Models\hamafza\Keyword;
use App\Models\Hamahang\Basicdata;
use App\Models\Hamahang\BasicdataValue;
use App\Models\Hamahang\BasicdataAttributesValues;
use App\Http\Controllers\Controller;

class BasicdataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function aaa()
    {
        $id = Request::get('id');
        $items = Basicdata::find($id)->items();
        return Datatables::eloquent($items)->make(true);
    }

    public function index($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.Basicdata.index', $arr);
    }

    public function items()
    {
        return view('hamahang.Basicdata.items');
    }

    public function get_groups()
    {
        $r = null;
        $results = Basicdata::/*where('inactive', '0')->*/
        select(['id', 'parent_id', 'title', 'dev_title', 'inactive'])->get();
        foreach ($results as $result) {
            $id = $result['id'];
            $parent_id = $result['parent_id'];
            $title = $result['title'];
            $dev_title = $result['dev_title'];
            $inactive = $result['inactive'];
            $r[] = json_encode(
                [
                    'id' => $id,
                    'parent' => '0' == $parent_id ? '#' : $parent_id,
                    'text' => '<span data-custom="' . ($dev_title ? true : false) . '" data-dev-title="' . $dev_title . '" data-id="' . $id . '" style="' . ($inactive ? 'color: lightgray; ' : null) . '">' . $title . '</span>',
                ]);
        }
        return response()->json(['success' => true, 'result' => [$r]]);
    }

    public function get_items()
    {
        $target = Request::input('target');
        /*
        $custom = $request->input('custom');
        $dev_title = $request->input('dev_title');
        */
        $id = Request::input('id');
        switch ($target) {
            case 'scores':
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-scores')->with(['data' => $data])->render();
                break;
            case 'medals':
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-medals')->with(['data' => $data])->render();
                break;
            case 'postmethods':
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-postmethods')->with(['data' => $data])->render();
                break;
            case 'adssetting':
                $HFMAd = HFM_GenerateUploadForm(
                    [
                        ['ad_image', ['jpg', 'png', 'jpeg', 'gif'], "Single"],
                    ]);
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-adssetting')->with(['data' => $data])->with('HFMAd', $HFMAd)->render();
                break;
            case 'sliderssetting':
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-sliderssetting')->with(['data' => $data])->render();
                break;
            case 'socialnetworks':
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items_socialnetworks')->with(['data' => $data])->render();
                break;
            case 'newssetting':

                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-newssetting')->with(['data' => $data])->render();
                break;
            case 'research_items':
                $data = BasicData::where('id', $id)->first();
                $r = view('hamahang.Basicdata.items-research')->with(['data' => $data])->render();
                break;
            default:
                $data = BasicData::where('id', $id)->first();
                $r = view("hamahang.Basicdata.items")->with(['data' => $data])->render();
                break;
        }
        return response()->json(['success' => true, 'result' => [$r,],]);
    }

    public function load_items()
    {
        $id = Request::get('id');
        $basicdata_items_find = Basicdata::find($id);
        if (null == $basicdata_items_find) {
            $basicdata_items = [];
        } else {
            $basicdata_items = $basicdata_items_find->items();
        }
        switch ($basicdata_items_find->dev_title) {
            case 'scores':
                $r = Datatables::eloquent($basicdata_items)
                    ->addColumn('a', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[0]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('b', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[1]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('c', function ($data)
                    {
                        if ($data->attrs)
                        {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[2]->id)->withPivot('value')->first();
                            $r = $r ? BasicdataValue::find($r->pivot->value) ? BasicdataValue::find($r->pivot->value)->title : '0' : '0';
                        } else
                        {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('c_value', function ($data)
                    {
                        if ($data->attrs)
                        {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[2]->id)->withPivot('value')->first();
                            $r = $r ? BasicdataValue::find($r->pivot->value) ? BasicdataValue::find($r->pivot->value)->id : '0' : '0';
                        } else
                        {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('max_medal', function ($data)
                    {
                         return '';
                    })
                    ->addColumn('d', function ($data)
                    {
                        $score = Score::where('type_value_id', $data->id);
                        $r = $score ? $score->count() : 0;
                        return $r;
                    })
                    ->addColumn('e', function ($data)
                    {
                        $score = Score::where('type_value_id', $data->id);
                        $r = $score ? $score->sum('value') : 0;
                        return $r;
                    })
                    ->addColumn('total_medals', function ($data)
                    {
                        return '';
                    })
                    ->make(true);
                break;
            case 'medals':
                $r = Datatables::eloquent($basicdata_items)
                    ->addColumn('a', function ($data) {
                        return '';
                    })
                    ->addColumn('b', function ($data) {
                        return '';
                    })
                    ->addColumn('c', function ($data) {
                        return '';
                    })
                    ->make(true);
                break;
            case 'postmethods':
                $r = Datatables::eloquent($basicdata_items)
                    ->addColumn('a', function ($data) {
                        return 'car';
                    })
                    ->make(true);
                break;
            case 'adssetting':
                $r = Datatables::eloquent($basicdata_items)
//                    ->editColumn('id', function ($data)
//                    {
//                        return enCode($data->id);
//                    })
                    ->addColumn('ad_image', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[1]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return enCode($r);
                    })
                    ->addColumn('url_address', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[0]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->make(true);
                break;
            case 'socialnetworks':
                $r=Datatables::of($basicdata_items)
                    ->addColumn('item_image', function ($data) {
                        if ($item=$data->attrs()->withPivot('value')->where('hamahang_basicdata_attributes.id',config('basicdata.social_attr_image'))->first() )
                        {
                            $r = $item->pivot->value ;
                            $r = $r ? $r : '';
                        } else {
                            $r = '';
                        }
                        return enCode($r);
                    })
                    ->addColumn('item_url', function ($data) {
                        if ($item=$data->attrs()->withPivot('value')->where('hamahang_basicdata_attributes.id',config('basicdata.social_attr_link'))->first() )
                        {
                            $r = $item->pivot->value ;
                            $r = $r ? $r : '';
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('related_tab', function ($data) {
                       return BasicdataValue::find($data->value)->title;
                    })
                    ->make(true);
                break;
            case 'sliderssetting':
                $r = Datatables::eloquent($basicdata_items)
//                    ->editColumn('id', function ($data)
//                    {
//                        return enCode($data->id);
//                    })
                    ->addColumn('slider_image', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[1]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return enCode($r);
                    })
                    ->addColumn('slider_url', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[0]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->make(true);
                break;
            case 'newssetting':
                $r = Datatables::eloquent($basicdata_items)
//                    ->editColumn('id', function ($data)
//                    {
//                        return enCode($data->id);
//                    })
                    ->addColumn('keywords', function ($data) {
                        if ($data->attrs) {
                            $keywords_titles = unserialize($data->value);
                            $titles_string = '';
                            foreach ($keywords_titles as $kt)
                            {
                                $keyword = Keyword::find($kt);
                                if($keyword)
                                {
                                    $titles_string .= $keyword->title . '-';
                                }
                            }
                            $r = rtrim($titles_string, '-');
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('default', function ($data) {
                        if ($data->attrs) {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[0]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        } else {
                            $r = '';
                        }
                        return $r;
                    })
                    ->make(true);
                break;
            case 'research_items':
                $r = Datatables::eloquent($basicdata_items)
//                    ->editColumn('id', function ($data)
//                    {
//                        return enCode($data->id);
//                    })
                    ->addColumn('slider_image', function ($data)
                    {
                        if ($data->attrs)
                        {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[1]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        }
                        else
                        {
                            $r = '';
                        }
                        return enCode($r);
                    })
                    ->addColumn('slider_url', function ($data)
                    {
                        if ($data->attrs)
                        {
                            $r = $data->attrs()->where('hamahang_basicdata_attributes.id', $data->BasicdatasAttributes[0]->id)->withPivot('value')->first();
                            $r = $r ? $r = $r->pivot->value : '';
                        }
                        else
                        {
                            $r = '';
                        }
                        return $r;
                    })
                    ->addColumn('related_tab', function ($data) {
                        return BasicdataValue::find($data->value)->title;
                    })

                    ->make(true);
                break;
            default:
                $r = Datatables::eloquent($basicdata_items)->make(true);
        }
        return $r;
    }

    public function updateAdSetting()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $basic_data_value = BasicdataValue::find(Request::input('item_id'));
            $basic_data_value->title = Request::input('title');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->save();

            $basic_data_attribute_url = $basic_data_value->attrs()->where('basicdata_attribute_id', 7)->withPivot('value')->first();
            $basic_data_attribute_url = BasicdataAttributesValues::where('basicdata_value_id', $basic_data_attribute_url->pivot->basicdata_value_id)
                ->where('basicdata_attribute_id', $basic_data_attribute_url->pivot->basicdata_attribute_id)->first();
            $basic_data_attribute_url->value = Request::input('url_address');
            $basic_data_attribute_url->save();

            $basic_data_attribute_image = $basic_data_value->attrs()->where('basicdata_attribute_id', 8)->withPivot('value')->first();
            $basic_data_attribute_image = BasicdataAttributesValues::where('basicdata_value_id', $basic_data_attribute_image->pivot->basicdata_value_id)
                ->where('basicdata_attribute_id', $basic_data_attribute_image->pivot->basicdata_attribute_id)->first();
            HFM_SaveSingleFile('ad_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_image->id);

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function addAdSetting()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $basic_data_value = new BasicdataValue();
            $basic_data_value->parent_id = Request::input('parent_id');
            $basic_data_value->title = Request::input('title');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->save();

            $basic_data_attribute_value = new BasicdataAttributesValues();
            $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
            $basic_data_attribute_value->basicdata_attribute_id = 7;
            $basic_data_attribute_value->value = Request::input('url_address');
            $basic_data_attribute_value->save();

            $basic_data_attribute_value = new BasicdataAttributesValues();
            $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
            $basic_data_attribute_value->basicdata_attribute_id = 8;
            $basic_data_attribute_value->save();
            $basic_data_attribute_value->value = HFM_SaveSingleFile('ad_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_value->id);

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function addSliderSetting()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
        ]);


        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
//            $basic_data_value = Basicdata::where('id', Request::input('parent_id'))->with('attrs')->get();

            $basic_data_value = new BasicdataValue();
            $basic_data_value->parent_id = Request::input('parent_id');
            $basic_data_value->title = Request::input('title');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->save();

            $basic_data_attribute_value = new BasicdataAttributesValues();
            $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
            $basic_data_attribute_value->basicdata_attribute_id = 5;
            $basic_data_attribute_value->value = Request::input('url_address');
            $basic_data_attribute_value->save();

            $basic_data_attribute_value = new BasicdataAttributesValues();
            $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
            $basic_data_attribute_value->basicdata_attribute_id = 6;
            $basic_data_attribute_value->save();
            $basic_data_attribute_value->value = HFM_SaveSingleFile('slider_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_value->id);


            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function updateSliderSetting()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $basic_data_value = BasicdataValue::find(Request::input('item_id'));
            $basic_data_value->title = Request::input('title');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->save();

            $basic_data_attribute_url = $basic_data_value->attrs()->where('basicdata_attribute_id', 5)->withPivot('value')->first();
            $basic_data_attribute_url = BasicdataAttributesValues::where('basicdata_value_id', $basic_data_attribute_url->pivot->basicdata_value_id)
                ->where('basicdata_attribute_id', $basic_data_attribute_url->pivot->basicdata_attribute_id)->first();
            $basic_data_attribute_url->value = Request::input('url_address');
            $basic_data_attribute_url->save();

            $basic_data_attribute_image = $basic_data_value->attrs()->where('basicdata_attribute_id', 6)->withPivot('value')->first();
            $basic_data_attribute_image = BasicdataAttributesValues::where('basicdata_value_id', $basic_data_attribute_image->pivot->basicdata_value_id)
                ->where('basicdata_attribute_id', $basic_data_attribute_image->pivot->basicdata_attribute_id)->first();
            HFM_SaveSingleFile('slider_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_image->id);

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }
    public function updateItemSocial()
    {
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
            'group_id'=>'required',
        ]);
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {

            $basic_data_value = BasicdataValue::find(Request::input('item_id'));
            $basic_data_value->title = Request::input('title');
            $basic_data_value->parent_id=Request::input('parent');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->value = Request::input('group_id');
            $basic_data_value->comment= Request::input('comment');
            $basic_data_value->save();
            $basic_data_attribute_url = $basic_data_value->attrs()->where('basicdata_attribute_id', config('basicdata.social_attr_link'))->withPivot('value')->first();
            $basic_data_attribute_url = BasicdataAttributesValues::where('basicdata_value_id', $basic_data_attribute_url->pivot->basicdata_value_id)
             ->where('basicdata_attribute_id', $basic_data_attribute_url->pivot->basicdata_attribute_id)->first();
            $basic_data_attribute_url->value = Request::input('url_address');
            $basic_data_attribute_url->save();
            $basic_data_attribute_image = $basic_data_value->attrs()->where('basicdata_attribute_id', config('basicdata.social_attr_image'))->withPivot('value')->first();
            $basic_data_attribute_image = BasicdataAttributesValues::where('basicdata_value_id', $basic_data_attribute_image->pivot->basicdata_value_id)
            ->where('basicdata_attribute_id', $basic_data_attribute_image->pivot->basicdata_attribute_id)->first();
            HFM_SaveSingleFile('edit_item_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_image->id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }
    public function addItemSocial(){

        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
            'group_id'=>'required',
        ]);
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        $basic_data_value = new BasicdataValue();

        $basic_data_value->parent_id=Request::input('parent');
        $basic_data_value->title = Request::input('title');

        $basic_data_value->inactive = Request::input('inactive');
        $basic_data_value->value = Request::input('group_id');
        $basic_data_value->comment= Request::input('comment');
        $basic_data_value->save();

        $basic_data_attribute_value = new BasicdataAttributesValues();
        $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
        $basic_data_attribute_value->basicdata_attribute_id = config('basicdata.social_attr_link');
        $basic_data_attribute_value->value = Request::input('url_address');
        $basic_data_attribute_value->save();

        $basic_data_attribute_value = new BasicdataAttributesValues();
        $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
        $basic_data_attribute_value->basicdata_attribute_id = config('basicdata.social_attr_image');
        $basic_data_attribute_value->save();
        $basic_data_attribute_value->value = HFM_SaveSingleFile('add_item_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_value->id);


        $result['message'][] = trans('app.operation_is_success');
        $result['success'] = true;
        return json_encode($result);
    }
    public function updateNewsSetting()
    {
        $validator = Validator::make(Request::all(), [
            'item_id' => 'required',
            'title' => 'required',
            'news_tabs_list' => 'required',
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $news_tabs = BasicdataValue::find(Request::input('item_id'));
            $news_tabs->title = Request::input('title');
            $news_tabs->value = serialize(Request::input('news_tabs_list'));
            $news_tabs->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function addNewsSetting()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'news_tabs_list' => 'required',
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $news_tabs = new BasicdataValue();
            $news_tabs->parent_id = 8;
            $news_tabs->title = Request::input('title');
            $news_tabs->value = serialize(Request::input('news_tabs_list'));
            $news_tabs->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function addItemResearch()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
//            $basic_data_value = Basicdata::where('id', Request::input('parent_id'))->with('attrs')->get();

            $basic_data_value = new BasicdataValue();
            $basic_data_value->parent_id = Request::input('parent_id');
            $basic_data_value->title = Request::input('title');
            $basic_data_value->value = Request::input('research_tab');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->save();

            $basic_data_attribute_value = new BasicdataAttributesValues();
            $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
            $basic_data_attribute_value->basicdata_attribute_id = config('basicdata.research_attr_link');
            $basic_data_attribute_value->value = Request::input('url_address');
            $basic_data_attribute_value->save();

            $basic_data_attribute_value = new BasicdataAttributesValues();
            $basic_data_attribute_value->basicdata_value_id = $basic_data_value->id;
            $basic_data_attribute_value->basicdata_attribute_id = config('basicdata.research_attr_image');
            $basic_data_attribute_value->save();

            $HFM_SaveSingleFile = HFM_SaveSingleFile('research_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_value->id);
            $basic_data_attribute_value->value =$HFM_SaveSingleFile;
            $basic_data_attribute_value->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }
    public function addItemResearchSelect2()
    {
        $data = BasicdataValue::where('parent_id',config('basicdata.research_attr_link'))->select("id", 'title as text')->get();
        return response()->json($data);
    }
    public function updateItemResearch()
    {
//        dd(Request::all());
        $validator = Validator::make(Request::all(), [
            'title' => 'required',
            'url_address' => 'required',
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $basic_data_value = BasicdataValue::find(Request::input('item_id'));
            $basic_data_value->title = Request::input('title');
            $basic_data_value->inactive = Request::input('inactive');
            $basic_data_value->value = Request::input('research_tab');
            $basic_data_value->save();


            $basic_data_attribute_url =  BasicdataAttributesValues::where('basicdata_value_id',$basic_data_value->id)->where('basicdata_attribute_id','12')->first();
            $basic_data_attribute_url->value = Request::input('url_address');
            $basic_data_attribute_url->save();

            if (session()->has('Files'))
            {
                $files = session('Files');
                if (isset($files['research_image']) && is_array($files['research_image']))
                {
                    $basic_data_attribute_image =  BasicdataAttributesValues::where('basicdata_value_id',$basic_data_value->id)->where('basicdata_attribute_id','13')->first();
                    $basic_data_attribute_image->value = HFM_SaveSingleFile('research_image', 'App\Models\Hamahang\BasicdataAttributesValues', 'value', $basic_data_attribute_image->id);
                    $basic_data_attribute_image->save();
                }
            }

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }

    }


}

