<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Keyword;
use App\Models\hamafza\Pages;
use App\Models\hamafza\Subject;
use App\Models\hamafza\SubjectFieldValue;
use App\Models\hamafza\SubjectType;
use App\Models\Hamahang\SubjectRel;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Datatables;
use Validator;

class SubjectController extends Controller
{

    public function index($name)
    {
        $uid = Auth::id();
        $res = variable_generator('user', 'Desktop_subjects', $name);
        return view('hamahang.Subjects.index', $res);
//        return view($res['viewname'], $res);
    }

    public function get_subjects()
    {
        $subjectType = DB::table('subject_type')
//            ->leftJoin('subjects','subject_type.id','=','subjects.kind')
            ->select('subject_type.id','subject_type.name','subject_type.comment','subject_type.created_at'
//                ,
//                DB::raw('COUNT(subjects.kind) as get_subject_count')
            )
            ->whereNull('subject_type.deleted_at')
//            ->groupBy('subjects.kind')
//            ->orderBy('subject_type.id')
            ->get();
//        dd($subjectType);
        return \Datatables::of($subjectType)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->addColumn('jdate', function ($data)
            {
                if ($data->created_at != '')
                {
                    return HDate_GtoJ($data->created_at);
                }
                else
                {
                    return '';
                }
            })
            ->addColumn('get_subject_count', function ($data)
            {
//                $subjectType = DB::table('subjects')
//                    ->select(DB::raw('COUNT(subjects.kind) as get_subject_count'))
//                    ->where('subjects.kind','=',$data->id)
//                    ->whereNull('deleted_at')
//                    ->get();
                $subjectType = Subject::where('kind', $data->id)->with('pages')->whereHas('pages')->select(DB::raw('COUNT(subjects.kind) as get_subject_count'))->get();
                return $subjectType[0]->get_subject_count;
            })
            ->make(true);

        $subjectType = SubjectType::with('subjects');
        return Datatables::eloquent($subjectType)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->addColumn('get_subject_count', function ($data)
            {
                return $data->subjects->count();
            })
            ->addColumn('jdate', function ($data)
            {
                if ($data->created_at != '')
                {
                    return HDate_GtoJ($data->created_at);
                }
                else
                {
                    return '';
                }
            })
            ->make(true);
    }

    public function get_subjects_jsPanel(Request $request)
    {
        $subject = Subject::where('kind', $request->id)->with('pages')->whereHas('pages');
        return Datatables::eloquent($subject)
            ->addColumn('first', function($data) use ($request)
            {
                $r = '[desktop]';
                $subject_type_tab = DB::table('subject_type_tab')->where('stid', $request->id)->where('first', '1')->select(['tid', 'name'])->get();
                $pages = Pages::where('sid', $data->id)->get();
                if ($subject_type_tab->count() && $pages->count())
                {
                    $tid = $subject_type_tab->first()->tid;
                    $r = isset($pages[$tid]) ? $pages[$tid]->id : isset($pages[0]) ? $pages[0]->id : $r;
                }
                return $r;
            })
            ->addColumn('jdate', function ($data)
            {
                if ($data->created_at != '')
                {
                    return HDate_GtoJ($data->created_at);
                }
                else
                {
                    return '';
                }
            })
            ->make(true);
    }


    static public function update_new_(Request $request){
        ////
        ///  update
        $messages =
            [
                'subject_title.required' => 'فیلد عنوان الزامی است',
            ];
        $validator = \Validator::make($request->all(),
            [
                'subject_title' => 'required',
            ], $messages);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else
        {
            ////
            ///  informations
            ///
            $subject = Subject::find($request->sid);
            $subject->title = $request->subject_title;
            if (-1 != $subject->sub_kind)
            {
                $subject->sub_kind = $request->sub_kind;
            }
            $subject->save();
            if ($subject)
            {
                if (!isset($request->PS_keywords))
                {
                    $PS_keywords = [];
                } else
                {
                    foreach ($request->PS_keywords as $key)
                    {
                        $PS_keywords[] = substr($key, 8);
                    }
                }
                $meta_fields = $request->input('meta_fields');
                if ($meta_fields)
                {
                    foreach ($meta_fields as $meta_field_key => $meta_field)
                    {
                        $meta_fields[$meta_field_key] = ['field_value' => $meta_field];
                    }
                    $subject->listfields()->sync($meta_fields);
                }
                $subject->keywords()->sync($PS_keywords);
                if ($subject->keywords()->sync($PS_keywords))
                {
                    $field = $request->field;
                    $type = $request->type;
                    $field_type = $request->type;
                    if (is_array($field_type))
                    {
                        SubjectFieldValue:: where('sid', $subject->id)->delete();
                        foreach ($field_type as $key => $val)
                        {
                            if (!empty($val))
                            {
                                if ($val == 'text' || $val == 'textarea' || $val == 'select' || $val == 'radio' || $val == 'keyword')
                                {
                                    $value = (array_key_exists($key, $field)) ? $field[$key] : '';
                                    $subject_fields_report = new SubjectFieldValue();
                                    $subject_fields_report->sid = $subject->id;
                                    $subject_fields_report->field_id = $key;
                                    $subject_fields_report->field_value = $value;
                                    $subject_fields_report->save();
                                } elseif ($val == 'checkbox')
                                {
                                    if (isset($field[$key]) && is_array($field[$key]))
                                    {
                                        foreach ($field[$key] as $k => $v)
                                        {
                                            $subject_fields_report = new SubjectFieldValue();
                                            $subject_fields_report->sid = $subject->id;
                                            $subject_fields_report->field_id = $key;
                                            $subject_fields_report->field_value = '1';
                                            $subject_fields_report->check_id = $k;
                                            $subject_fields_report->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $message[] = 'با موفقیت ویرایش شد';
                } else
                {
                    $message[] = 'متن مورد نظر ویرایش نشد';
                }
            }

//            return json_encode($message);

            ////
            ///  informations
            ///

            if (!Auth::check())
            {
                return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
            }
            else
            {
                ////
                ///  relations
                ///
                ///
                $sid = $request->input('rel_sid');
                $relations = $request->input('relations');
                $subject_rel = $request->input('subject_rel');
                //DB::table('subjects_rel')->where('sid1', $sid)->orWhere('sid2', $sid)->delete();
                SubjectRel::where('sid1', $sid)->orWhere('sid2', $sid)->delete();
                if(isset($subject_rel)){
                    foreach ($subject_rel as $key => $value)
                    {
                        if (!empty($value))
                        {
                            if (isset($relations[$key]))
                            {
                                $relate = $relations[$key];
                                if ($relate != '')
                                {
                                    if (substr($relate[0], 0, 1) == "D")
                                    {
                                        $relate = str_replace("D", '', $relate[0]);
                                        //DB::table('subjects_rel')->insert(array('sid1' => $sid, 'sid2' => $sid2, 'rel' => $relate));
                                        foreach ($value as $val)
                                        {
                                            $sid2 = $val;
                                            $check = SubjectRel::where('sid1', $sid)
                                                ->Where('sid2', $sid2)
                                                ->Where('rel', $relate)
                                                ->first();
                                            if (count($check) == 0)
                                            {
                                                $subjectRel = new SubjectRel();
                                                $subjectRel->sid1 = $sid;
                                                $subjectRel->sid2 = $sid2;
                                                $subjectRel->rel = $relate;
                                                $subjectRel->save();
                                            }
                                        }
                                    }
                                    elseif (substr($relate[0], 0, 1) == "I")
                                    {
                                        $relate = str_replace("I", '', $relate[0]);
                                        //DB::table('subjects_rel')->insert(array('sid1' => $sid2, 'sid2' => $sid, 'rel' => $relate));
                                        foreach ($value as $val)
                                        {
                                            $sid2 = $val;
                                            $check = SubjectRel::where('sid1', $sid2)
                                                ->Where('sid2', $sid)
                                                ->Where('rel', $relate)
                                                ->first();

                                            if (count($check) == 0)
                                            {
                                                $subjectRel = new SubjectRel();
                                                $subjectRel->sid1 = $sid2;
                                                $subjectRel->sid2 = $sid;
                                                $subjectRel->rel = $relate;
                                                $subjectRel->save();
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }else{
                    $message[] = 'روابط با موفقیت ویرایش شد';
                }

                $result=[];
                if(isset($subjectRel)){
                    $message[] = 'روابط با موفقیت ویرایش شد';
                }else{
                    $message[] = 'ویرایش روابط با مشکل مواجه شد . دوباره امتحان کنید.';
                }
                //return Redirect()->back()->with('message', $user)->with('mestype', 'success');
            }
            ////
            ///  relations
            ///



            ////
            ///  access
            ///
            $show = $request->input('show');
            $sid = $request->input('access_sid');
            $pid = $request->input('access_pid');
            $subject_view = $request->input('subject_view');
            $subject_search = $request->input('subject_search');
            $admin_change = $request->input('admin_change');

            $user = User::find($admin_change);
            if ($user)
            {
                $subject = Subject::find($sid);
                if ($subject)
                {
                    $subject->admin = $admin_change;
                    $subject->save();
                }
            }


            DB::table('tab_view')->where('sid', $sid)->delete();
            if (is_array($show) && count($show) > 0)
            {
                foreach ($show as $key => $value)
                {
                    DB::table('tab_view')->insert(array('tabid' => $value, 'sid' => $sid));
                }
            }
//            $subject = Subject::find($sid);
            $subject->list = $subject_view;
            $subject->search = $subject_search;
            $subject->save();


            if ($subject)
            {

                if ($request->input('users_list_setting_view'))
                {
                    $users_list_setting_view = $request->input('users_list_setting_view');
                    foreach ($users_list_setting_view as $key => $value)
                    {
                        $users_list_setting_view_array[$value] = ['type' => '1'];
                    }

                    $subject->user_policies_view()->sync($users_list_setting_view_array);
                }
                else
                {
                    $subject->user_policies_view()->sync([]);
                }

                if ($request->input('roles_list_setting_view'))
                {
                    $roles_list_setting_view = $request->input('roles_list_setting_view');
                    foreach ($roles_list_setting_view as $key => $value)
                    {
                        $roles_list_setting_view_array[$value] = ['type' => '1'];
                    }
                    $subject->role_policies_view()->sync($roles_list_setting_view_array);
                }
                else
                {
                    $subject->role_policies_view()->sync([]);
                }


                if ($request->input('users_list_setting_edit'))
                {
                    $users_list_setting_edit = $request->input('users_list_setting_edit');
                    foreach ($users_list_setting_edit as $key => $value)
                    {
                        $users_list_setting_edit_array[$value] = ['type' => '2'];
                    }
                    $subject->user_policies_edit()->sync($users_list_setting_edit_array);
                }
                else
                {
                    $subject->user_policies_edit()->sync([]);
                }

                if ($request->input('roles_list_setting_edit'))
                {
                    $roles_list_setting_edit = $request->input('roles_list_setting_edit');
                    foreach ($roles_list_setting_edit as $key => $value)
                    {
                        $roles_list_setting_edit_array[$value] = ['type' => '2'];
                    }
                    $subject->role_policies_edit()->sync($roles_list_setting_edit_array);
                }
                else
                {
                    $subject->role_policies_edit()->sync([]);
                }
            }
            $message[] = trans('labels.subjectAccessOK');
            ////
            ///  access
            ///

            ////
            ///  help
            ////

            $help_ids = [];
            $target_type = $request->input('target_type');
            $target_id = $request->input('target_id');
            $help_items = $request->input('help_id');
            if(is_array($help_items))
            {
                foreach ($help_items as $help_item)
                {
                    //$get_id = str_replace(['help_relation_add[', ']'], null, $help_item['name']);
                    $help_ids[/*$get_id*/] = $help_item['value'];
                }
            }

            $get_page = Pages::find($target_id);
            if ($get_page)
            {
                if ($get_page->subject)
                {
                    $get_subject_id = $get_page->subject->id;
                    $pages = Pages::where('sid', $get_subject_id)->select('id')->get();
                    if ($pages)
                    {
                        foreach ($pages as $page_k => $page)
                        {
                            if (isset($help_ids[$page_k]))
                            {
                                if ($help_ids[$page_k])
                                {
                                    DB::table('hamahang_help_relations')
                                        ->where('target_type', 'App\Models\hamafza\Pages')
                                        ->where('target_id', $page->id)->delete();
                                    DB::table('hamahang_help_relations')->insert
                                    ([
                                        'target_type' => 'App\Models\hamafza\Pages',
                                        'target_id' => $page->id,
                                        'help_id' => $help_ids[$page_k],
                                        'created_by' => auth()->id(),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            ///
            ///  help
            ///

            ////
            ///  bazzar
            ///

            $rfs = $request->responsible_for_sales_id;
            $request->merge(['responsible_for_sales_id' => $rfs[0]]);
            $validator = Validator::make
            (
                $request->all(),
                [
                    'id' => 'required',
                    'subject_id' => 'required',
                    'price' => 'required|integer|min:0',
                    'discount' => 'required|integer|min:0',
                    'tax' => 'required|integer|min:0|max:100',
                    'responsible_for_sales_id' => 'required|integer',
                    'weight' => 'required|integer|min:0',
                    'size' => 'required|string',
                    'shipping_cost' => 'required|integer|min:0',
                    'maximum_delivery_time' => 'required|integer|min:0',
                    'how_to_send' => 'required|integer',
                    'count' => 'required|integer|min:0',
                    'payment_methods' => 'required|array',
                    //'ready_to_supply' => 'required',
                    //'created_by' => 'required',
                ]
            );

            if ($validator->fails())
            {
                $message[] = 'ویرایش اظلاعات بازار با عدم موفقیت همراه است';
            }else{

                $id = $request->input('id');
                $subject_id = $request->input('subject_id');
                $price = $request->input('price');
                $discount = $request->input('discount');
                $tax = $request->input('tax');
                $responsible_for_sales_id = $request->input('responsible_for_sales_id');
                $weight = $request->input('weight');
                $size = $request->input('size');
                $shipping_cost = $request->input('shipping_cost');
                $maximum_delivery_time = $request->input('maximum_delivery_time');
                $how_to_send = $request->input('how_to_send');
                $count = $request->input('count');
                $payment_methods = $request->input('payment_methods');
                $description = $request->input('description');
                $ready_to_supply = $request->input('ready_to_supply');

                $spi = SubjectsProductInfo::find($id);
                if (null == $spi)
                {
                    $spi = new SubjectsProductInfo();
                }

                $spi->subject_id = $subject_id;
                $spi->price = $price;
                $spi->discount = $discount;
                $spi->tax = $tax;
                $spi->responsible_for_sales_id = $responsible_for_sales_id;
                $spi->weight = $weight;
                $spi->size = $size;
                $spi->shipping_cost = $shipping_cost;
                $spi->maximum_delivery_time = $maximum_delivery_time;
                $spi->how_to_send = $how_to_send;
                $spi->count = $count;
                $spi->payment_methods = implode(',', $payment_methods);
                $spi->description = $description;
                $spi->ready_to_supply = $ready_to_supply;
                $spi->created_by = auth()->id();
                $result = $spi->save();
            }
        }
        $res['success'] = true;
        $res['message'] = $message;
        return json_encode($res);
    }
    static public function update(Request $request)
    {
        $messages =
        [
            'subject_title.required' => 'فیلد عنوان الزامی است',
        ];
        $validator = \Validator::make($request->all(),
        [
            'subject_title' => 'required',
        ], $messages);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else
        {
            $subject = Subject::find($request->sid);
            $subject->title = $request->subject_title;
            if (-1 != $subject->sub_kind)
            {
                $subject->sub_kind = $request->sub_kind;
            }
            $subject->save();
            if ($subject)
            {
                if (!isset($request->PS_keywords))
                {
                    $PS_keywords = [];
                } else
                {
                    foreach ($request->PS_keywords as $key)
                    {
                        $PS_keywords[] = substr($key, 8);
                    }
                }
                $meta_fields = $request->input('meta_fields');
                if ($meta_fields)
                {
                    foreach ($meta_fields as $meta_field_key => $meta_field)
                    {
                        $meta_fields[$meta_field_key] = ['field_value' => $meta_field];
                    }
                    $subject->listfields()->sync($meta_fields);
                }
                $subject->keywords()->sync($PS_keywords);
                if ($subject->keywords()->sync($PS_keywords))
                {
                    $field = $request->field;
                    $type = $request->type;
                    $field_type = $request->type;
                    if (is_array($field_type))
                    {
                        SubjectFieldValue:: where('sid', $subject->id)->delete();
                        foreach ($field_type as $key => $val)
                        {
                            if (!empty($val))
                            {
                                if ($val == 'text' || $val == 'textarea' || $val == 'select' || $val == 'radio' || $val == 'keyword')
                                {
                                    $value = (array_key_exists($key, $field)) ? $field[$key] : '';
                                    $subject_fields_report = new SubjectFieldValue();
                                    $subject_fields_report->sid = $subject->id;
                                    $subject_fields_report->field_id = $key;
                                    $subject_fields_report->field_value = $value;
                                    $subject_fields_report->save();
                                } elseif ($val == 'checkbox')
                                {
                                    if (isset($field[$key]) && is_array($field[$key]))
                                    {
                                        foreach ($field[$key] as $k => $v)
                                        {
                                            $subject_fields_report = new SubjectFieldValue();
                                            $subject_fields_report->sid = $subject->id;
                                            $subject_fields_report->field_id = $key;
                                            $subject_fields_report->field_value = '1';
                                            $subject_fields_report->check_id = $k;
                                            $subject_fields_report->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $message[] = 'با موفقیت ویرایش شد';
                    return json_encode($message);
                } else
                {
                    $message[] = 'متن مورد نظر ویرایش نشد';
                    return json_encode($message);
                }
            }
        }
    }

    public function edit_subject_type(Request $request)
    {

        if ($request->exists('username'))
        {
            $username = $request->username;
            $param = ['username' => $username, 'subject_id' => deCode($request->id)];
        }
        else
        {
            $username = 'amgh';
            $param = ['username' => 'amgh', 'subject_id' => deCode($request->id)];
        }
        $res = variable_generator('user', 'Desktop_subjects_id', $username, $param);
        if (false) { view('pages.Desktop.editsubtype'); }
        return view($res['viewname'], $res);
    }

    public function add_subject_type(Request $request)
    {
        if ($request->exists('username'))
        {
            $username = $request->username;
        }
        else
        {
            $username = 'amgh';
        }
        $arr = variable_generator('user', 'asubadd', $username, '1');
        if (false) { view('pages.Desktop.ADD.AsubjectADD'); }
        return view($arr['viewname'], $arr);
    }

    public function destroy_subject_type(Request $request)
    {
        $SubjectType = subjectType::destroy(deCode($request->id));
        if ($SubjectType)
        {
            $result['message'][] = 'آیتم با موفقیت حذف شد';
            $result['success'] = true;
            return json_encode($result);
        }
        else
        {
            $result['message'][] = 'آیتم حذف نشد . دوباره امتحان کنید !';
            $result['success'] = false;
            return json_encode($result);
        }
    }

}

