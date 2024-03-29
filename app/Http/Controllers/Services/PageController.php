<?php

namespace App\Http\Controllers\Services;

use App\HamafzaServiceClasses\PageClass;
use App\HamafzaViewClasses;
use App\Models\hamafza\Pages;
use Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Token;
use Illuminate\Support\Facades\DB;
use App\Models\Hamahang\Bookmark;
use App\User;
use Intervention\Image\Facades\Image;
use App\HamafzaServiceClasses\UserClass;

class PageController extends Controller {

    public function PageDetail() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }

        $pid = Request::input('page_id');
        $PgC = new HamafzaViewClasses\PageClass();
        $pc = new \App\HamafzaServiceClasses\PageClass();
        $page_new = $PgC->PageDetail($pid, 0, 0, '', 0, 0, 'local');
        $page = Pages::find($pid);
        $subject = $page->subject;
        $posts = $subject->posts;
        $Body = $page->body;
        $Tree = $pc->bodyList($Body);
        foreach ($page_new['Files'] as $file) {
            $file['downloadURL'] = route('FileManager.DownloadFile', ['type' => 'ID', 'id' => enCode($file->id)]) . '/?&fname=' . $file->originalName;
        }
        if (strlen($page_new['content']) > 0) {
            $page_new['content'] = view('api.views.content_html_text')->with('content_main', $page_new['content'])->render();
        } else {
            $sub_kind = $subject->sub_kind;
            $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
            $posts = \App\Models\hamafza\Post::where('type', 0 == $sub_kind ? 2 : $sub_kind)->where('portal_id', $subject->id)->orderBy('reg_date', 'desc')->get();
            $page_new['content'] = view('api.views.subcontent')
                    ->with('posts', $posts)
                    ->with('sid', $subject->id)
                    ->render();
        }
        $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $page_new['content'] = str_replace('src="../../', 'src="' . $base_url . '/', $page_new['content']);

        $sid = $subject->id;
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
                    'title' => 'پیوست ها',
                    'selected' => '1',
                    'type' => '6',
                    'data' => $page_new['Files']
                ],
                    [
                    'title' => 'فهرست',
                    'selected' => '0',
                    'type' => '7',
                    'data' => $Tree
                ],
                    [
                    'title' => 'گفتگو',
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
                            'title' => 'وظایف من',
                            'value' => \App\Models\Hamahang\Tasks\tasks::MyTasks($sid, $user->id, true) . "",
                        // 'url' => route('pgs.desktop.hamahang.tasks.my_tasks.list', ['sid' => $sid])
                        ],
                            [
                            'title' => 'یادداشت ها',
                            'value' => $user->Announces()->whereHas('page', function ($q) use ($sid) {
                                        $q->whereHas('subject', function ($q) use ($sid) {
                                                    $q->where('subjects.id', $sid);
                                                });
                                    })->get()->count() . "",
                        //'url' => route('page.desktop.announces', ['sid' => $sid])
                        ],
                            [
                            'title' => 'علامت گذاری ها',
                            'value' => $user->Highlights()->whereHas('page', function ($q) use ($sid) {
                                        $q->whereHas('subject', function ($q) use ($sid) {
                                                    $q->where('subjects.id', $sid);
                                                });
                                    })->get()->count() . "",
                        // 'url' => route('page.desktop.highlights', ['sid' => $sid])
                        ]
                    ]
                ]
            ]
        ];
        $uid = Token::where('token', Request::input('token'))->first()->user->id;
        $pageDet = DB::table('subject_member')
                        ->where('uid', $uid)->where('sid', $subject->id)->select('id', 'relation', 'follow', 'like')->first();

        if ($pageDet) {
            $res['like'] = $pageDet->like;
            $res['follow'] = $pageDet->follow;
            $res['relation'] = $pageDet->relation;
        } else {
            $res['like'] = '0';
            $res['follow'] = 0;
            $res['relation'] = 0;
        }
        return response()
                        ->json($res, 200)
                        ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function PageLike() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
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

        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;
        $sid = Request::input('sid');
        $type = Request::input('type');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->LikeADD($uid, $sid);
                return [
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
            case 'Post':
                \App\HamafzaServiceClasses\PostsClass::PostLike($uid, $sid, 0, 1);
                return [
                    'status' => "1",
                    'e_text' => 'به پسندیده ها اضافه گشت.'
                ];
        }
    }

    public function disLike() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;
        $sid = Request::input('sid');
        $type = Request::input('type');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->LikeRemove($uid, $sid);
                return [
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
            case 'Post':
                \App\HamafzaServiceClasses\PostsClass::PostLike($uid, $sid, 0, 0);
                return [
                    'status' => "1",
                    'e_text' => 'از پسندیده شده ها حذف گردید.'
                ];
        }
    }

    public function follow() {

        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;
        $sid = Request::input('sid');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->FollowADD($uid, $sid);
                return [
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
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;
        $sid = Request::input('sid');
        switch ($type) {
            case 'subject':
                $PageClass = new PageClass();
                $PageClass->FollowRemove($uid, $sid);
                return [
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

    public function newpost(Request $request) {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;

        $pid = Request::input('pid');
        $type = Request::input('type');
        $desc = Request::input('desc');
        $all = '1';
        $keys = Request::input('keys');
        $cids = "all";
        $gids = Request::input('gids');
        $title = Request::input('title');
        $portal_id = "null";
        $reward = $user->TotalScores;
        $sesid = 0;
        $file = Request::file('image');
        $tmpFileName = '';
        if ($file) {
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();
                $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                $img = Image::make($file->getRealPath());
                $img->resize(800, null, function ($constraint) {
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
        if ($menu) {
            $file = HFM_SaveMultiFiles('comment_file', '\App\Models\Hamahang\FileManager\Fileable', 'fileable_id', $menu, ['created_by' => $user->id, 'fileable_type' => 'App\Models\hamafza\Pages', 'type' => 2]);
        }
        return [
            'status' => "1",
        ];
        ;
    }

    public function bookmark_toggle() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $target_table = Request::input('type');
        $target_id = Request::input('id');
        $user_id = $user->id;
        switch ($target_table) {
            case 'page': {
                    $page = Pages::find($target_id);
                    if ($page->count()) {
                        $title = $page->subject->title;
                    } else {
                        return;
                    }
                    $target_type = 'App\Models\hamafza\Pages';
                    break;
                }
            case 'subject': {
                    /* $subject = Subject::find($target_id);
                      if ($subject->count()) { $title = $subject->title; } else { return; }
                      $target_type = 'App\Models\hamafza\Subject';
                      break; */
                }
            case 'user': {
                    $user = User::find($target_id);
                    if ($user->count()) {
                        $title = $user->FullName;
                    } else {
                        return;
                    }
                    $target_type = 'App\User';
                    break;
                }
        }

        $bookmark = Bookmark::where('target_table', $target_type)->where('target_id', $target_id)->where('user_id', $user_id);

        if ($bookmark->count()) {
            $bookmark->delete();
            $res = [
                'status' => "1",
                'message' => 'چوب الف با موفقیت حذف شد.'
            ];
            return response()->json($res);
        } else {
            Bookmark::create(['title' => $title, 'target_table' => $target_type, 'target_id' => $target_id, 'user_id' => $user_id,]);
            $res = [
                'status' => "2",
                'message' => 'چوب الف با موفقیت ثبت شد.'
            ];
            return response()->json($res);
        }
    }

    public function bookmark_delete() {

        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $id = Request::input('id');

        $bookmark = Bookmark::where('id', $id)->where('user_id', $user->id)->get()->first();
        if ($bookmark) {

            $bookmark->delete();
            $res = [
                'status' => "1",
                'message' => 'چوب الف با موفقیت حذف شد.'
            ];
            return response()->json($res);
        } else {
            $res = [
                'status' => "-1",
                'message' => 'یافت نشد'
            ];
            return response()->json($res);
        }
    }

    public function announce_add(Request $request) {

        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;
        $title = Request::input('title');

        $comment = Request::input('comment');

        //$moarefi = Request::input('moarefi');
        //$naghallow = Request::input('naghallow');

        $keywords = Request::input('keywords');
        $pid = Request::input('pid');

        // $select = Request::input('select');
        // $book_page = Request::input('bookpage');
        //$select = ($select == '') ? ' ' : $select;
        // $book_page = ($book_page == '') ? 0 : $book_page;

        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        /* if ($about != 'on') {
          $pid = 0;
          } */
        $announce_id = DB::table('announces')->insertGetId(
                [
                    'pid' => $pid,
                    'uid' => $uid,
                    'quote' => '',
                    'title' => $title,
                    'comment' => $comment,
                    'reg_date' => $reg_date,
                    'mostaghim' => '',
                    'bookpage' => ''
                ]
        );
        $myArray = explode(',', $keywords);
        $myArray = json_encode($myArray);
        $myArray = json_decode($myArray);

        foreach ($myArray as &$value) {
            DB::table('announce_keys')->insert(
                    [
                        'ann_id' => $announce_id,
                        'key_id' => $value
                    ]
            );
        }
        $res = [
            'status' => "1",
            'message' => trans('labels.ann_ok')
        ];

        return response()->json($res);
    }

    public function sendMessage() {
//        dd(Request::all());
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;

        //$sesid =  0;
        $title = Request::input('title');
        $comment = Request::input('comment');
        $user_edits = explode(",", Request::input('users'));

//            dd($user_edits);
//            $files = Request::file('file');
//            $filetitle = Request::input('ftitle');
        //$Slides = array();
//            $uploadcount = 0;
//            if (is_array($files) && count($files) > 0)
//            {
//                foreach ($files as $key => $file)
//                {
//                    if ($file)
//                    {
//                        if ($file->isValid())
//                        {
//                            $tmpFilePath = 'files/ticket/' . $uid . '/';
//                            if (!file_exists(public_path() . '/' . $tmpFilePath))
//                            {
//                                mkdir(public_path() . '/' . $tmpFilePath, 0777, true);
//                            }
//                            $extension = $file->getClientOriginalExtension();
//                            $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
//                            $file->move($tmpFilePath, $tmpFileName);
//                            $Slides[$uploadcount]['name'] = $uid . '/' . $tmpFileName;
//                            $Slides[$uploadcount]['title'] = $filetitle[$key];
//                        }
//                    }
//                    $uploadcount++;
//                }
//            }
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $tid = DB::table('tickets')->insertGetId(array('uid' => $uid, 'title' => $title, 'login' => '0', 'reg_date' => $reg_date));

        //$file = HFM_SaveMultiFiles('message_file', '\App\Models\Hamahang\FileManager\Fileable', 'fileable_id', $tid, ['created_by' => auth()->id(), 'fileable_type' => 'App\Models\hamafza\Ticket', 'type' => 1]);

        DB::table('ticket_answer')->insert(array('uid' => $uid, 'tid' => $tid, 'comment' => $comment, 'reg_date' => $reg_date));
        if (is_array($user_edits)) {
            foreach ($user_edits as $key => $val) {
                if (intval($val) != 0) {
                    DB::table('ticket_recieve')->insert(array('tid' => $tid, 'uid' => $val, 'del' => 0));
                    //  Alerts::Message($val, $uid);
                }
            }
        }
        /* if (is_array($Slides) && count($Slides) > 0) {
          foreach ($Slides as $value) {
          DB::table('ticket_file')->insert(array('aid' => $tid, 'name' => $value['name'], 'title' => $value['title']));
          }
          } */
        $res = [
            'status' => "1",
            'message' => trans('labels.SMSSEndOK')
        ];
        return response()->json($res);
    }

    public function newOrgan() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $uid = $user->id;
        $group_title = Request::input('group_title');
        $group_link = Request::input('group_link');
        $group_summary = Request::input('group_summary');
        $group_type = Request::input('group_type');
        $group_limit = Request::input('group_limit');
        $isorgan = Request::input('ischannel');
        $Groupkeywords = Request::input('Groupkeywords');
        $file = Request::file('pic');
        $tmpFileName = '';
        /* if ($file)
          {
          if ($file->isValid())
          {
          $tmpFilePath = 'pics/group/';
          $extension = $file->getClientOriginalExtension();
          $tmpFileName = $uid . time() . '.' . $extension; // renameing image
          $img = Image::make($file->getRealPath());
          $img->resize(450, null, function ($constraint)
          {
          $constraint->aspectRatio();
          $constraint->upsize();
          });
          $img->save('pics/group/' . $tmpFileName)->destroy();
          $tmpFileName = $tmpFileName;
          }
          } */
//            $SP = new UserClass();
//            $menu = $SP->newOrgGroup($group_title, $group_link, $group_summary, $group_type, $group_limit, $isorgan, $Groupkeywords, $tmpFileName, $sesid, $uid);
        $count = DB::table('user_group')->where('link', $group_link)->count();
        $count += DB::table('user')->where('Uname', $group_link)->count();
        $menu = $isorgan ? 'کانال' : 'گروه';
        if (ctype_digit($group_link)) {
            $message = 'نام' . $menu . 'نبایستی عدد باشد';
            $res = [
                'status' => "-1",
                'message' => $message
            ];
        } else if ($count == 0) {
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            $gid = DB::table('user_group')->insertGetId(array('uid' => $uid, 'name' => $group_title, 'link' => $group_link,
                'summary' => $group_summary, 'type' => $group_type, 'edit' => $group_limit, 'pic' => $tmpFileName, 'reg_date' => $reg_date, 'isorgan' => $isorgan));
            DB::table('user_group_member')->insert(array('uid' => $uid, 'gid' => $gid, 'follow' => '1',
                'admin' => '1', 'relation' => '2', 'reg_date' => $reg_date));
            $keywords = explode(',', $Groupkeywords);
            foreach ($keywords as &$value) {
                DB::table('user_group_key')->insert(array('gid' => $gid, 'kid' => $value));
            }

            $res = [
                'status' => "1",
                'message' => $menu . ' با موفقیت ثبت شد.'
            ];
            return response()->json($res);
        } else {
            $menu = 'این آدرس  تکراری است';
            $res = [
                'status' => "-1",
                'message' => $menu
            ];
            return response()->json($res);
        }
    }

    public function post_comment() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $postid = Request::input('postid');
        $uid = $user->id;
        $comment = Request::input('comment');
        $comment = json_encode($comment);
        $comment = str_replace("&", "[and]", $comment);
        $menu = \App\HamafzaServiceClasses\PostsClass::PostComment($uid, $postid, 0, $comment);

        $res = [
            'status' => "1",
            'message' => $menu
        ];
        return response()->json($res);
    }

    public function delete_comment() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $id = Request::input('id');
        \App\HamafzaServiceClasses\PostsClass::CommentDelete($id);
        $message = trans('labels.DelOK');
        $res = ['message' => $message];
        return response()->json($res);
    }

    public function delete_post() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $id = Request::input('id');
        $uid = $user->id;

        $page = 'Post';
        $a = DB::transaction(function () use ($uid, $page, $id) {
                    $post = \App\Models\hamafza\Post::find($id);
                    if ($post == FALSE) {
                        $status = -1;
                        $message = 'پست موجود نیست';
                    } else if ($post->accepted) {
                        $status = -1;
                        $message = 'پاسخ تائید شده، امکان حذف آن وجود ندارد.';
                    } else {
                        if ($post->answerCount > 0) {
                            $message = 'پاسخ داده شده، امکان حذف آن وجود ندارد.';
                        } else {
                            $SP = new \App\HamafzaServiceClasses\PublicsClass();
                            $menu = $SP->DeleteRow($page, $uid, 0, $id);

                            switch ($post->type) {
                                case '1':
                                    $score_id = config('score.9');
                                    break;
                                case '2':
                                    $score_id = config('score.10');
                                    break;
                                case '3':
                                    $score_id = config('score.11');
                                    break;
                                case '4':
                                    $score_id = config('score.12');
                                    break;
                                case '12':
                                    $score_id = config('score.13');
                                    break;
                                case '13':
                                    $score_id = config('score.14');
                                    break;
                            }
                            score_unregister('App\Models\hamafza\Post', $id, $score_id, $uid);

                            if (2 == $post->type) {
                                $reward = Reward::where('from_user_id', $uid)->where('target_table', 'App\Models\hamafza\Post')->where('target_id', $id);
                                if ($reward) {
                                    $reward->delete();
                                }
                            }
                            $message = trans('labels.DelOK');
                            $status = 1;
                        }
                    }
                    $res = ['status' => $status, 'message' => $message];
                    return response()->json($res);
                });
        return $a;
    }

    public function delete_announce() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $id = Request::input('id');
        \App\HamafzaServiceClasses\PageClass::DeleteAnnounces($id);
        $message = trans('labels.DelOK');
        $res = ['message' => $message];
        return response()->json($res);
    }

    public function delete_highlight() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $id = Request::input('id');
        \App\HamafzaServiceClasses\PageClass::DeleteHighlight($id);
        $message = trans('labels.DelOK');
        $res = ['message' => $message];
        return response()->json($res);
    }

    public function Sharepost() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $ShareGroup = Request::input("groups");
        $users = Request::input("users");
        $inmypage = Request::input('inmypage');
        $descr = Request::input('desc');
        $post_id = Request::input('post_id');
        $SP = new \App\HamafzaServiceClasses\PostsClass();
        $menu = $SP->Sharepost($user->id, 0, $ShareGroup, $users, '', $inmypage, $descr, $post_id, '');
//        return $menu;
//
//        $mes = AJAX::Sharepost($uid, $sesid, $ShareGroup, $users, $emails, $inmypage, $descr, $post_id, '');
        $res = [
            'status' => "1",
            'message' => 'بازنشر انجام شد'
        ];
        return response()->json($res);
    }

    function page_announces() {
        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $sid = Request::input('sid');
        $my_subject_highlights = $user->Announces()->whereHas('page', function ($q) use ($sid) {
                    $q->whereHas('subject', function ($q) use ($sid) {
                        $q->where('subjects.id', $sid);
                    });
                })->orderBy('id', 'desc')->get();
        return response()->json($my_subject_highlights);
    }

    function page_highlights() {

        $user = getUser();
        if (!isset($user->id)) {
            return $user;
        }
        $sid = Request::input('sid');
        $my_subject_highlights = $user->Highlights()->whereHas('page', function ($q) use ($sid) {
                    $q->whereHas('subject', function ($q) use ($sid) {
                        $q->where('subjects.id', $sid);
                    });
                })->get();
        return response()->json($my_subject_highlights);
    }

}
