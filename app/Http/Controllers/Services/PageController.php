<?php

namespace App\Http\Controllers\Services;

use App\HamafzaServiceClasses\PageClass;
use App\HamafzaViewClasses;
use App\HamafzaViewClasses\AJAX;
use App\Models\hamafza\Pages;
use App\Models\hamafza\Post;
use Request;
use Validator;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    public function PageDetail()
    {
        $validator = Validator::make(Request::all(), [
            'token'       => 'required',
            'page_id'    => 'required'
        ]);
        if ($validator->fails())
        {
            $error = validation_error_to_api_json($validator->errors());
            $res =
                [
                    'status'    => "-1",
                    'error'     => $error
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }
        if(!CheckToken(Request::input('token')) && !CheckTokenGustMode(Request::input('token')))
        {
            $res =
                [
                    'status'    => "-1",
                    'error'     =>  [ ['e_key'=>'token','e_values'=> ['e_text'=>'عبارت امنیتی معتبر نمی باشد.']] ]
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
        }

        $pid = Request::input('page_id');
        $PgC = new HamafzaViewClasses\PageClass();
        $page_new = $PgC->PageDetail($pid, 0, 0, '', 0, 0, 'local');
        $page_new['content'] = view('api.views.content_html_text')->with('content_main',$page_new['content'])->render();
        $page = Pages::find($pid);
        $subject = $page->subject;
        $posts = $subject->posts;
        $res =
            [
                'status' => '1',
                'page_title' => $subject->title,
                'type' => '4',
                'main'=>
                    [
                        [
                            'title' => 'متن',
                            'selected' =>'1',
                            'type' => '6',
                            'data' => $page_new['content']
                        ],
                        [
                            'title' => 'بحث',
                            'selected' =>'0',
                            'type' => '5',
                            'data' => $subject->ApiPosts
                        ],
                        [
                            'title' => 'میزکار',
                            'selected' =>'0',
                            'type' => '3',
                            'data' =>
                                [
                                    [
                                        'type' =>'tasks',
                                        'title' => 'وظایف',
                                        'order' => '1',
                                        'data'  =>
                                            [
                                                [
                                                    'type' =>'my_tasks',
                                                    'title'=>'وظایف من',
                                                    'new'=>'2',
                                                    'value'=>'31',
                                                    'order'=>'1',
                                                    'url'=>'#'
                                                ],
                                                [
                                                    'type' =>'my_assigned_task',
                                                    'title'=>'واگذاری های من',
                                                    'new'=>'-1',
                                                    'value'=>'14',
                                                    'order'=>'2',
                                                    'url'=>'#'
                                                ],
                                                [
                                                    'type' =>'drafts',
                                                    'title'=>'پیشنویس ها',
                                                    'new'=>'-1',
                                                    'value'=>'10',
                                                    'order'=>'3',
                                                    'url'=>'#'
                                                ]
                                            ]
                                    ],
                                    [
                                        'type' =>'announces_and_forms_and_marked',
                                        'title' => 'یادداشت ها، فرم ها',
                                        'order' => '2',
                                        'data'  =>
                                            [
                                                [
                                                    'type' =>'announces',
                                                    'title' =>'یادداشت ها',
                                                    'new'=>'-1',
                                                    'value'=>'15',
                                                    'order'=>'1',
                                                    'url'=>'#'
                                                ],
                                                [
                                                    'type' =>'marked',
                                                    'title' =>'علامت گذاری ها',
                                                    'new'=>'-1',
                                                    'value'=>'15',
                                                    'order'=>'2',
                                                    'url'=>'#'
                                                ],
                                                [
                                                    'type' =>'forms',
                                                    'title' =>'فرم ها',
                                                    'new'=>'-1',
                                                    'value'=>'15',
                                                    'order'=>'3',
                                                    'url'=>'#'
                                                ],
                                            ]
                                    ]
                                ]
                        ]
                    ]
            ];
        return response()
            ->json($res, 200)
            ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8' ]);
    }

    public function PageLike()
    {
        $validator = Validator::make(Request::all(), [
            'token' => 'required',
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
        if (!CheckToken(Request::input('token')))
        {
            $res =
                [
                    'status' => "-1",
                    'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
                ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if ($tar_val == '1') {
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $menu = $SP->Like($type, $userid, $tar_sid, $uid, 0);
            return $menu;
        } else if ($tar_val == '0') {
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $menu = $SP->DisLike($type, $user_id, $tar_sid, $uid, 0);
            return $menu;
        }
    }

    public function Like($type, $user_id, $sid, $uid, $session_id="") {

        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                return $PageClass->LikeADD($uid, $sid);
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->LikeADD($uid, $user_id);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->LikeADD($uid, $user_id);
                break;
        }
    }

    public function DisLike($type, $userid, $sid, $uid, $session_id) {
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                return $PageClass->LikeRemove($uid, $sid);
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->LikeRemove($uid, $userid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->LikeRemove($uid, $userid);
                break;
        }
    }

    public function pages_list()
    {
        $html = Request::input('html');
        $page = Request::input('page');
        $result = PageClass::pages_list($html, $page);
        return response()->json(['success' => true, 'result' => [$result[0], $result[1]]]);
    }
}
