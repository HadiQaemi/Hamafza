<?php

namespace App\Http\Controllers\Services;

use App\HamafzaPublicClasses;
use App\Models\hamafza\Post;
use App\Token;
use Request;
use App\Http\Controllers\Controller;
use App\HamafzaServiceClasses\UserClass;
use Validator;
use App\Models\hamafza\Subject;
use App\HamafzaViewClasses\DesktopClass;

class UserController extends Controller {

    public function AboutUser() {
        $username = Request::input('unmae');
        $uids = HamafzaPublicClasses\FunctionsClass::UserName2id($username);
        $uid = '0';
        $UC = new UserClass();
        $user_data = $UC->About($uids, $uid, 'service');
        return $user_data;
    }

    public function desktop() {
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
        $auth_user = Token::where('token', Request::get('token'))->first()->user;

        $res ['desktop_sections'] =
                        [
                            [
                                'type' => 'tasks',
                                'title' => 'وظایف',
                                'order' => '1',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'title' => 'وظایف من',
                                            'new' => '-1',
                                            'value' => "$auth_user->MyTasksCount",
                                            //'icon' => 'fa-tasks',
                                            //'url' => route('ugc.desktop.hamahang.tasks.my_tasks.list', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'واگذاری های من',
                                            'new' => '-1',
                                            'value' => "$auth_user->MyAssignedTasksCount",
                                           // 'icon' => 'fa-list-alt',
                                            //'url' => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'پیشنویس ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->MyDraftTasksCount",
                                          ///  'icon' => 'fa-pencil-square ',
                                            //'url' => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts', ['username' => $auth_user->Uname])
                                        ]
                                    ]
                            ],
                            [
                                'type' => 'persons',
                                'title' => 'اشخاص',
                                'order' => '2',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'title' => 'افراد',
                                            'new' => '-1',
                                            'value' => "$auth_user->UserPersonsCount",
                                            //'icon' => 'fa-user',
                                            //'url' => '#'
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'گروه ها و کانال ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->ApiUserGroupsCount",
                                           /// 'icon' => 'fa-users',
                                            //'url' => '#'
                                        ],
                                        [
                                            'active' => '0',
                                            'title' => 'شاید بشناسید',
                                            'new' => '-1',
                                            'value' => '0',
                                           // 'icon' => 'fa-user-o',
                                           // 'url' => '#'
                                        ]
                                    ]
                            ],
                            [
                                'type' => 'messages',
                                'title' => 'پیغام',
                                'order' => '3',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'title' => 'دریافتی ها',
                                            'new' => "$auth_user->NewRecieveTicketsCount",
                                            'value' => "$auth_user->RecieveTicketsCount",
                                          //  'icon' => 'fa-inbox',
                                            //'url' => route('ugc.desktop.hamahang.tickets.inbox', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'ارسالی ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->SendTicketsCount",
                                         //   'icon' => 'fa-paper-plane-o',
                                            //'url' => route('ugc.desktop.hamahang.tickets.outbox', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '0',
                                            'title' => 'مکالمه ها',
                                            'new' => '-1',
                                            'value' => '---',
                                         //   'icon' => 'fa-commenting ',
                                            //'url' => '#'
                                        ],
                                    ]
                            ],
                            [
                                'type' => 'announces_and_forms_and_marked',
                                'title' => 'یادداشت ها، فرم ها',
                                'order' => '4',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'title' => 'یادداشت ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->AnnouncesCount",
                                            //'icon' => 'fa-pencil',
                                            //'url' => route('ugc.desktop.announces', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'علامت گذاری ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->HighlightsCount",
                                          //  'icon' => 'fa-bookmark-o',
                                           /// 'url' => route('ugc.desktop.highlights', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'فرم ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->FormsCount",
                                           // 'icon' => 'fa-wpforms',
                                           // 'url' => route('ugc.desktop.form_list.me', ['username' => $auth_user->Uname])
                                        ],
                                    ]
                            ],
                            [
                                'type' => 'user_account',
                                'title' => 'حساب کاربری',
                                'order' => '5',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'title' => 'هشدار ها',
                                            'new' => "$auth_user->NewEmailsCount",
                                            'value' => "$auth_user->EmailsCount",
                                          //  'icon' => 'fa-clock-o',
                                           // 'url' => route('ugc.desktop.notifications', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'title' => 'امتیاز ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->TotalScores",
                                          //  'icon' => 'fa-certificate ',
                                           // 'url' => route('ugc.desktop.hamahang.summary.index', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '0',
                                            'title' => 'خرید ها',
                                            'new' => '-1',
                                            'value' => '---',
                                          //  'icon' => 'fa-shopping-basket',
                                           // 'url' => '#'
                                        ],
                                    ]
                            ],
                        ];
        return $res;
    }

    public function get_persons() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '7',
                'data' => $user->ApiUserPersons
            ]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function get_people_you_may_know() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '8',
                'data' =>
                    [
                        [
                        'user_id' => '3',
                        'username' => 'ali_taghavi',
                        'first_name' => 'علی',
                        'last_name' => 'تقوی',
                        'pic' => 'http://hamafza.ir/pics/user/43661473067619.jpg',
                    ],
                        [
                        'user_id' => '123',
                        'username' => 'rastegar_moghaddam',
                        'first_name' => 'ایمان',
                        'last_name' => '-رستگار مقدم',
                        'pic' => 'http://hamafza.ir/pics/user/a393548221e95f9bbd96eef92f80eabc.jpg',
                    ],
                        [
                        'user_id' => '543',
                        'username' => 'nader_gholami',
                        'first_name' => 'نادر',
                        'last_name' => 'غلامی',
                        'pic' => ''
                    ],
                        [
                        'user_id' => '34',
                        'username' => 'mohsen_nami',
                        'first_name' => 'محسن',
                        'last_name' => 'نامی',
                        'pic' => ''
                    ],
                ]
            ]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function get_my_posts() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        $posts = $user->ApiPosts;
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '9',
                'data' => $posts
            ]
        ];
        return $res;
    }

    public function get_my_wall() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;

        $res = [
            'status' => "1",
            'main' =>
                [
                
                'data' => Get_User_Wall($user->id, Request::input('limit'), Request::input('offset'))
            ]
        ];
        return $res;
    }

    public function get_about_me() {
        if (!CheckToken(Request::get('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        $posts_count = $user->posts->count();
        $follower_persons_count = $user->follower_persons->count();
        $followed_persons_count = $user->followed_persons->count();
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '10',
                'data' =>
                    [
                        [
                        'section' => 'name',
                        'title' => 'نام',
                        'type' => '0',
                        'data' => "$user->Name $user->Family"
                    ],
                        [
                        'section' => 'summary',
                        'title' => 'عنوان',
                        'type' => '0',
                        'data' => "$user->Summary"
                    ],
                        [
                        'section' => 'posts',
                        'title' => 'پست ها',
                        'type' => '0',
                        'data' => "$posts_count"
                    ],
                        [
                        'section' => 'followers',
                        'title' => 'دنبال کنندگان',
                        'type' => '0',
                        'data' => "$follower_persons_count"
                    ],
                        [
                        'section' => 'followed',
                        'title' => 'دنبال شوندگان',
                        'type' => '0',
                        'data' => "$followed_persons_count"
                    ],
                        [
                        'section' => 'expertise',
                        'title' => 'تخصص ها',
                        'type' => '1',
                        'data' => $user->api_specials
                    ],
                        [
                        'section' => 'responsibility',
                        'title' => 'مسئولیت ها',
                        'type' => '2',
                        'data' => $user->ApiWorks
                    ],
                        [
                        'section' => 'educations',
                        'title' => 'تحصیلات ها',
                        'type' => '3',
                        'data' => $user->ApiEducations
                    ],
                        [
                        'section' => 'effects',
                        'title' => 'آثار',
                        'type' => '4',
                        'data' =>
                            [
                                [
                                'field' => 'title',
                                'title' => 'عنوان',
                                'value' => 'اثر یک',
                            ],
                                [
                                'field' => 'title',
                                'title' => 'عنوان',
                                'value' => 'اثر دو',
                            ],
                                [
                                'field' => 'title',
                                'title' => 'عنوان',
                                'value' => 'اثر سه',
                            ],
                        ]
                    ],
                ]
            ]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function get_my_notes() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '12',
                'data' => $user->ApiAnnounces
            ]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function get_my_groups() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '13',
                'data' => $user->ApiUserGroups
            ]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function get_bookmarks() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        $data = $user->getApiBookmarksAttribute(Request::get('term'), $user->id);
        $res = [
            'status' => "1",
            'main' =>
                [
                'type' => '13',
                'data' => $data
            ]
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }

    public function portals() {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }



        $subject_types = ['public' => 'رسمی', 'private' => 'شخصی',];
        $term = trim(Request::input('term'));
        $subjects['public'] = Subject::whereIn('kind', [20, 21, 22, 27])->where('ispublic', '1')->where('list', '1')->where('archive', '0');
        $subjects['private'] = Subject::whereIn('kind', [20, 21, 22, 27])->where('ispublic', '0')->where('admin', auth()->id());
        $subjects['public'] = $term ? $subjects['public']->where('title', 'like', "%$term%") : $subjects['public'];
        $subjects['private'] = $term ? $subjects['private']->where('title', 'like', "%$term%") : $subjects['private'];
        $subjects['public'] = $subjects['public']->get();
        $subjects['private'] = $subjects['private']->get();
        $r = [
            'subject_types' => $subject_types,
            'term' => $term,
            'subjects' => $subjects
        ];
        return $r;
    }
    
    function MyGroups()
    {
        if (!CheckToken(Request::input('token'))) {
            $res = [
                'status' => "-1",
                'error' => [['e_key' => 'token', 'e_values' => [['e_text' => 'عبارت امنیتی معتبر نمی باشد.']]]]
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $user = Token::where('token', Request::get('token'))->first()->user;
        return \Illuminate\Support\Facades\DB::table('user_group as g')->leftjoin('user_group_member as u', 'u.gid', '=', 'g.id')
            ->where('u.uid', $user->id)->select('g.id', 'g.name')
            ->get();
    }

}
