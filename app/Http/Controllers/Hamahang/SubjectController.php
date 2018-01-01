<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Keyword;
use App\Models\hamafza\Pages;
use App\Models\hamafza\Subject;
use App\Models\hamafza\SubjectFieldValue;
use App\Models\hamafza\SubjectType;
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

        /*
        $subject_type_tab = DB::table('subject_type_tab')->where('stid', $request->id)->where('first', '1')->get()->first();
        $page = Pages::where('sid', $subject->get()->first()->id)->get()->toArray();
        if ($page)
        {
            $first = $page[$subject_type_tab->tid]['id'];
        } else
        {
            $first = $subject->get()->first()->id . '/desktop';
        }
        */
        return Datatables::eloquent($subject)
            //->addColumn('first', $first)
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

    static public function update(Request $request)
    {
        $messages = [
            'subject_title.required' => 'فیلد عنوان الزامی است',
        ];
        $validator = \Validator::make($request->all(), [
            'subject_title' => 'required',
        ], $messages);
        //DB::enableQueryLog();
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subject = Subject::find($request->sid);
            $subject->title = $request->subject_title;
            $subject->save();

            //$PS_keywords = explode(',', $request->PS_keywords);

            if ($subject)
            {
                if (!isset($request->PS_keywords))
                {
                    $PS_keywords = [];
                }
                else
                {
                    foreach ($request->PS_keywords as $key)
                    {
                        $PS_keywords[] = substr($key, 8);
                    }
                }

                $meta_fields = $request->input('meta_fields');

                //dd($meta_fields);

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
                                }
                                elseif ($val == 'checkbox')
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
                }
                else
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

