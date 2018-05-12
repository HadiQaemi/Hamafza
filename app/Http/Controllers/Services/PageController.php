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
use App\Token;
use Illuminate\Support\Facades\DB;

class PageController extends Controller {

    public function PageDetail() {
        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
                    'page_id' => 'required'
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token')) && !CheckTokenGustMode(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => ['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }

        $pid = Request::input('page_id');
        $PgC = new HamafzaViewClasses\PageClass();
        $pc = new \App\HamafzaServiceClasses\PageClass();
        $page_new = $PgC->PageDetail($pid, 0, 0, '', 0, 0, 'local');
        $page_new['content'] = view('api.views.content_html_text')->with('content_main', $page_new['content'])->render();
        $page = Pages::find($pid);
        $subject = $page->subject;
        $posts = $subject->posts;
        $Body = $page->body;
        $Tree = $pc->bodyList($Body);
        $res = [
            'status' => '1',
            'page_title' => $subject->title,
            'type' => '4',
            'sid' => $subject->id,
            'main' =>
                [
                    [
                    'title' => 'متن',
                    'selected' => '1',
                    'type' => '6',
                    'data' => $page_new['content']
                ],
                    [
                    'title' => 'بحث',
                    'selected' => '0',
                    'type' => '5',
                    'data' => $subject->ApiPosts
                ],
                    [
                    'title' => 'میزکار',
                    'selected' => '0',
                    'type' => '3',
                    'data' =>
                        [
                            [
                            'type' => 'tasks',
                            'title' => 'وظایف',
                            'order' => '1',
                            'data' =>
                                [
                                    [
                                    'type' => 'my_tasks',
                                    'title' => 'وظایف من',
                                    'new' => '2',
                                    'value' => '31',
                                    'order' => '1',
                                    'url' => '#'
                                ],
                                    [
                                    'type' => 'my_assigned_task',
                                    'title' => 'واگذاری های من',
                                    'new' => '-1',
                                    'value' => '14',
                                    'order' => '2',
                                    'url' => '#'
                                ],
                                    [
                                    'type' => 'drafts',
                                    'title' => 'پیشنویس ها',
                                    'new' => '-1',
                                    'value' => '10',
                                    'order' => '3',
                                    'url' => '#'
                                ]
                            ]
                        ],
                            [
                            'type' => 'announces_and_forms_and_marked',
                            'title' => 'یادداشت ها، فرم ها',
                            'order' => '2',
                            'data' =>
                                [
                                    [
                                    'type' => 'announces',
                                    'title' => 'یادداشت ها',
                                    'new' => '-1',
                                    'value' => '15',
                                    'order' => '1',
                                    'url' => '#'
                                ],
                                    [
                                    'type' => 'marked',
                                    'title' => 'علامت گذاری ها',
                                    'new' => '-1',
                                    'value' => '15',
                                    'order' => '2',
                                    'url' => '#'
                                ],
                                    [
                                    'type' => 'forms',
                                    'title' => 'فرم ها',
                                    'new' => '-1',
                                    'value' => '15',
                                    'order' => '3',
                                    'url' => '#'
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
          $uid= Token::where('token', Request::input('token'))->first()->user->id;
         $pageDet = DB::table('subject_member')
                ->where('uid', $uid)->where('sid', $subject->id)->select('id', 'relation', 'follow', 'like')->first();
           
            if ($pageDet)
            {
                $res['like'] = $pageDet->like;
                $res['follow'] = $pageDet->follow;
                $res['relation'] = $pageDet->relation;
            }
            else
            {
                $res['like'] = '0';
                $res['follow'] = 0;
                $res['relation'] = 0;
            }
        return response()
                        ->json($res, 200)
                        ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function PageLike() {
        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
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

    public function like() {

        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $type=Request::input('type');
        $uid= Token::where('token', Request::input('token'))->first()->user->id;
        $sid= Request::input('sid');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->LikeADD($uid, $sid);
                return  [
                'status' => "1",
                'e_text' => 'به پسندیده ها اضافه گشت.'
            ];
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->LikeADD($uid, $sid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->LikeADD($uid, $sid);
                break;
        }
    }

    public function disLike() {
        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $type=Request::input('type');
        $uid= Token::where('token', Request::input('token'))->first()->user->id;
        $sid= Request::input('sid');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->LikeRemove($uid, $sid);
                 return  [
                'status' => "1",
                'e_text' => 'از پسندیده شده ها حذف گردید.'
            ];
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->LikeRemove($uid, $sid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->LikeRemove($uid, $sid);
                break;
        }
    }
    
    public function follow() {

        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $type=Request::input('type');
        $uid= Token::where('token', Request::input('token'))->first()->user->id;
        $sid= Request::input('sid');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->FollowADD($uid, $sid);
                return  [
                'status' => "1",
                'e_text' => 'به دنبال شده‌ها افزوده شد'
            ];
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->FollowADD($uid, $sid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->FollowADD($uid, $sid);
                break;
        }
    }

    public function unFollow() {
        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $type=Request::input('type');
        $uid= Token::where('token', Request::input('token'))->first()->user->id;
        $sid= Request::input('sid');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->FollowRemove($uid, $sid);
                 return  [
                'status' => "1",
                'e_text' => 'از دنبال شده‌ها حذف شد'
            ];
                break;
            case 'User':
                $UC = new UserClass();
                return $UC->FollowRemove($uid, $sid);
                break;
            case 'Group':
                $UC = new GroupsClass();
                return $UC->FollowRemove($uid, $sid);
                break;
        }
    }
    
    

    public function pages_list() {
        $html = Request::input('html');
        $page = Request::input('page');
        $result = PageClass::pages_list($html, $page);
        return response()->json(['success' => true, 'result' => [$result[0], $result[1]]]);
    }
    
    public function newpost(Request $request)
    {
        $validator = Validator::make(Request::all(), [
                    'token' => 'required',
        ]);
        if ($validator->fails()) {
            $error = validation_error_to_api_json($validator->errors());
            $res = [
                'status' => "-1",
                'error' => $error
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
       
        $user= Token::where('token', Request::input('token'))->first()->user;
     
        $uid = $user->id;
        
        $pid = Request::input('pid');
        $type = Request::input('type');
        $desc = Request::input('desc');
        $all = '1';
        $keys = Request::input('keys');
        $cids = "all";
        $gids = Request::input('gids');
        $title = Request::input('title');
        $portal_id ="null";
        $reward = $user->TotalScores;
        $sesid = 0;
        $file = Request::file('image');
        $tmpFileName = '';
        if ($file)
        {
            if ($file->isValid())
            {
                $extension = $file->getClientOriginalExtension();
                $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                $img = Image::make($file->getRealPath());
                $img->resize(800, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save('uploads/' . $tmpFileName)->destroy();
                $tmpFileName = $tmpFileName;
            }
        }
        $video = '';

        $SP = new \App\HamafzaServiceClasses\PostsClass();
        $time = time();
        $menu = $SP->NewPost($uid, $sesid, $pid, $type, $desc, $tmpFileName, $video, $time, $all, $keys, $cids, $gids, $title, $portal_id, $reward);
        if ($menu)
        {
            $file = HFM_SaveMultiFiles('comment_file', '\App\Models\Hamahang\FileManager\Fileable', 'fileable_id', $menu, ['created_by' => $user->id, 'fileable_type' => 'App\Models\hamafza\Pages', 'type' => 2]);
        }
        return  [
                'status' => "1",
               
            ];;
    }

}
