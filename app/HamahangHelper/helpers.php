<?php

use App\HamafzaServiceClasses\PageClass;
use App\HamafzaServiceClasses\PostsClass;
use App\HamafzaServiceClasses\SubjectsClass;
use App\HamafzaViewClasses\DesktopClass;
use App\HamafzaServiceClasses\UserClass;
use App\HamafzaViewClasses\PublicClass;
use App\HamahangCustomClasses\Widgets;
use App\Models\hamafza\Keyword;
use App\Models\hamafza\History;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\OrgChart\onet_ability;
use App\Models\Hamahang\OrgChart\onet_job;
use App\Models\Hamahang\OrgChart\onet_job_ability;
use App\Models\Hamahang\OrgChart\onet_job_knowledge;
use App\Models\Hamahang\OrgChart\onet_job_skill;
use App\Models\Hamahang\OrgChart\onet_knowledge;
use App\Models\Hamahang\OrgChart\onet_skill;
use App\Models\Hamahang\Score;
use App\Models\hamafza\Pages;
use App\User;
use App\Models\Hamahang\KeywordRelation;

//----------------Begin-------------- hlper / Hamafza variable generator / helper -------------------Begin---------------//
if (!function_exists('MyPortals'))
{

    function MyPortals()
    {
        $subjects['public'] = Subject::whereIn('kind', [20, 21, 22, 27])->where('ispublic', '1')->where('list', '1')->where('archive', '0');
        $subjects['private'] = Subject::whereIn('kind', [20, 21, 22, 27])->where('ispublic', '0')->where('admin', auth()->id());
        $subjects['public'] = $subjects['public']->select('id','title')->get();
        $subjects['private'] = $subjects['private']->select('id','title')->get();
//        dd($subjects);
        return $subjects;
    }
}
//----------------Begin-------------- hlper / Hamafza variable generator / helper -------------------Begin---------------//
if (!function_exists('MyOrganGroups'))
{

    function MyOrganGroups()
    {
        return DB::table('user_group as g')->join('user_group_member as u', 'u.gid', '=', 'g.id')
            ->where('u.uid', Auth::id())->groupBy('g.id')->select('g.id', 'g.name')
            ->get();
    }

}
if (!function_exists('isGroupMemeber'))
{

    function isGroupMemeber($gid)
    {
        return DB::table('user_group_member')->where('uid', Auth::id())->where('gid', $gid)->whereRaw("(relation='2')")->count();
    }

}

if (!function_exists('PageTabs'))
{

    /**
     * @param $type [subject,user,group]
     * @param $item integer item_id
     * @param $params []
     * @return $this
     */
    function PageTabs($type, $item = 0, $params = [])
    {
        switch ($type)
        {
            /* case 'portal_enquiry':
              {
              $res = [];
              $page_tabs = \App\Models\hamafza\Subject::page_tabs((int)$item);
              $res['link'] = (int)$item . '/forum';
              $res['href'] = $res['link'];
              $res['title'] = 'بحث';
              $res['selected'] = "false";
              array_push($page_tabs, $res);
              $res['link'] = (int)$item . '/desktop';
              $res['href'] = $res['link'];
              $res['title'] = 'میزکار';
              $res['selected'] = "false";
              array_push($page_tabs, $res);
              return json_decode(json_encode($page_tabs));
              break;
              } */
            case 'subject':
            {
                $res = [];
                $page_tabs = \App\Models\hamafza\Subject::page_tabs((int)$item);
                $res['link'] = (int)$item . '/forum';
                $res['href'] = $res['link'];
                $res['title'] = 'گفتگو';
                $res['selected'] = "false";
                array_push($page_tabs, $res);
                $res['link'] = (int)$item . '/desktop';
                $res['href'] = $res['link'];
                $res['title'] = 'میزکار';
                $res['selected'] = "false";
                array_push($page_tabs, $res);
                return json_decode(json_encode($page_tabs));
                break;
            }
            case 'user':
            {
                $user_tab = [];
                $user = User::findOrFail((int)$item);
                $user_tab[0]['title'] = 'معرفی';
                $user_tab[0]['link'] = 'intro';
                $user_tab[0]['href'] = $user->Uname . '';
                $user_tab[1]['title'] = 'مطالب';
                $user_tab[1]['link'] = 'contents';
                $user_tab[1]['href'] = $user->Uname . '\contents';
                if (intval($item) != 0 && $user->id == Auth::id())
                {
                    $user_tab[2]['title'] = 'دیوار';
                    $user_tab[2]['link'] = 'wall';
                    $user_tab[2]['href'] = $user->Uname . '\wall';
                    $user_tab[3]['title'] = 'میزکار';
                    $user_tab[3]['link'] = 'desktop';
                    $user_tab[3]['href'] = $user->Uname . '\desktop';
                }
                return $user_tab;
                break;
            }
            case 'group':
            {
                $group_tab = array();
                $groups['tabs']['name']['0'] = 'معرفی';
                $groups['tabs']['link']['0'] = 'intro';
                $groups['tabs']['name']['1'] = 'مطالب';
                $groups['tabs']['link']['1'] = 'contents';
                $groups['tabs']['name']['5'] = 'میزکار';
                $groups['tabs']['link']['5'] = 'desktop';
                $groups['tabs']['name']['6'] = 'گروه‌ها';
                $groups['tabs']['link']['6'] = 'groups';
                $groups['tabs']['name']['8'] = 'دیوار';
                $groups['tabs']['link']['8'] = 'wall';
                $groups['tabs']['name']['9'] = 'میزکار';
                $groups['tabs']['link']['9'] = 'desktop';
                $group = \App\Models\hamafza\Groups::find($item);
                $us = DB::table('user_group as ug')->join('user_group_member as ugm', 'ugm.gid', '=', 'ug.id')
                    ->where('ug.id', $item)->where('ugm.uid', Auth::id())->whereIn('ugm.relation', ['2'])->select('ug.id')->count();
                $Uname = $group->link;
                if ($group->id != '')
                {
                    $group_id = $group->id;
                    foreach ($groups['tabs']['name'] as $key => $val)
                    {
                        $Tab = array();
                        $link = $groups['tabs']['link'][$key];
                        $href = $Uname . '/' . $groups['tabs']['link'][$key];
                        $distance = ($key == 1 || $key == 5 || $key == 8) ? 1 : '';
                        $view = true;
                        $group->owner  = ($group->uid == auth()->id());
                        if (($key == 5) && ($group->owner || $us>0))
                        {
                            $view = true;
                        }
                        else
                        {
                            if (($key == 5) && (!$group->owner))
                            {
                                $view = false;
                            }
                        }
                        if (($key == 6 || $key == 7 || $key == 8 || $key == 9))
                        {
                            $view = false;
                        }
                        if ($view == true)
                        {
                            $Tab['link'] = $link;
                            $Tab['href'] = $href;
                            $Tab['title'] = $val;
                            array_push($group_tab, $Tab);
                        }
                    }
                }
                return $group_tab;
                break;
            }
            default :
            {
                return [];
            }
        }
    }

}
if (!function_exists('GetPublicKeyword'))
{

    /**
     * @return $this
     */
    function GetPublicKeyword()
    {
        $keys = Keyword::whereHas('subjects')->select('id', 'title AS text')->withCount('subjects')->get();
        $PC = new PublicClass();
        $e = array();
        foreach ($keys as $value)
        {
            $d['id'] = $value->id;
            $d['text'] = $value->text;
            $d['parent_id'] = '#';
            array_push($e, $d);
        }
        $newtree = $PC->CretaeTree1L($e, 'id', 'parent_id', 'text');
        $newtree = $PC->Json(0, $newtree);
        return $newtree;
    }

}
if (!function_exists('RightCol'))
{

    /**
     * @param $sid integers
     * @param $type string
     * @return $this
     */
    function RightCol($sid, $type)
    {
        $menus = array();
        $menusRet = array();
        $Ret = array();
        $res = array();
        $uid = Auth::id();
        if ($type == 'subjects')
        {
            if (Auth::check())
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[2] = 'wall';
                $PostsClass = new PostsClass();
                $res[1] = $PostsClass->UserWall($uid, 3);
                array_push($Ret, $res);
                $res[0] = trans('labels.rhightcol_pagewall_title');
                $PostsClass = new PostsClass();
                $Sw = $PostsClass->SubjectWall_rightCol($sid, $uid, 3);
                $res[1] = $PostsClass->SubjectWall_rightCol($sid, $uid, 3);
                $res[2] = 'desktop';
                array_push($Ret, $res);
            }
            else
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[1] = trans('labels.rhightcol_mywall_no_data');
                array_push($Ret, $res);
            }
        }
        elseif ($type == 'subjectwall')
        {
            if (Auth::check())
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[2] = 'wall';
                $PostsClass = new PostsClass();
                $res[1] = $PostsClass->UserWall($uid, 3);
                array_push($Ret, $res);
            }
            else
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[1] = trans('labels.rhightcol_mywall_no_data');
                array_push($Ret, $res);
            }
        }
        elseif ($type == 'userwall')
        {
            if (Auth::check())
            {
                $res[0] = 'آخرین رویدادها';
                $res[2] = 'alerts';
                $PostsClass = new UserClass();
                $res[1] = \App\HamafzaServiceClasses\Alerts::GetAlerts($uid);
                array_push($Ret, $res);
                $res[0] = trans('labels.rhightcol_mygroup_title');
                $res[2] = 'userwall';
                $res[1] = $PostsClass->MyGroupAdmin($uid, 50, 0);
                array_push($Ret, $res);
                $res[0] = trans('labels.rhightcol_mychannel_title');
                $res[1] = $PostsClass->MyGroupAdmin($uid, 50, 1);
                array_push($Ret, $res);
            }
            else
            {
                $res[0] = trans('labels.rhightcol_usernot_title');
                $res[1] = trans('labels.rhightcol_usernot_no_data');
                $res[2] = 'usernot';
                array_push($Ret, $res);
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[1] = trans('labels.rhightcol_mywall_no_data');
                array_push($Ret, $res);
            }
        }
        elseif ($type == 'groups_about')
        {
            if (Auth::check())
            {
                $res[0] = trans('labels.rhightcol_mygroup_title');
                $res[2] = 'userwall';
                $PostsClass = new UserClass();
                $res[1] = $PostsClass->MyGroupAdmin($uid, 50, 0);
                array_push($Ret, $res);
                $res[0] = trans('labels.rhightcol_mychannel_title');
                $res[1] = $PostsClass->MyGroupAdmin($uid, 50, 1);
                array_push($Ret, $res);
            }
            else
            {
                $res[0] = trans('labels.rhightcol_mywall_title');
                $res[1] = trans('labels.rhightcol_mywall_no_data');
                array_push($Ret, $res);
            }
        }
        else
        {
            if ($type == 'user_about')
            {
                if (Auth::check())
                {
                    $res[0] = trans('labels.rhightcol_mywall_title');
                    $res[2] = 'wall';
                    $PostsClass = new PostsClass();
                    $res[1] = $PostsClass->UserWall($uid, 3);
                    array_push($Ret, $res);
                }
                else
                {
                    $res[0] = trans('labels.rhightcol_mywall_title');
                    $res[1] = trans('labels.rhightcol_mywall_no_data');
                    array_push($Ret, $res);
                }
            }
        }
        return $Ret;
    }

}
//----------------END-------------- hlper / Hamafza variable generator / helper -------------------END---------------//

if (!function_exists('userCalendarsWidget'))
{

    function userCalendarsWidget()
    {
        $wObj = new Widgets();
        return $wObj->userCalendarGrid();
    }

}

if (!function_exists('userProjectsWidget'))
{

    function userProjectsWidget()
    {
        $wObj = new Widgets();
        return $wObj->userProjectsWidget();
    }

}

//-------------Begin-------------- ACL -------------------Begin---------------//

if (!function_exists('tree_permissions_categories'))
{

    function tree_permissions_categories($with_array = ['_roles'])
    {
        //dd($with_array);
        $categories = \App\Models\Hamahang\ACL\AclCategory::with('permissions');
        foreach ($with_array as $with_item)
        {
            $categories = $categories->with('permissions.' . $with_item);
        }
        $categories = $categories->get()->toArray();
        $tree = buildTree($categories, 'parent_id');
        return $tree;
    }

}

if (!function_exists('draw_permissions_categories'))
{

    function draw_permissions_categories($tree_items, $type_id, $type = '_roles', $permissions = '')
    {

        $out = '';
        foreach ($tree_items as $item)
        {
//            dd($item['permissions'][0]['_roles']);
            if (array_key_exists('children', $item))
            {
                $children = draw_permissions_categories($item['children'], $type_id, $type, $permissions);
                $out .= view('hamahang.ACL.helper.permissions_categories_list')
                    ->with('item', $item)
                    ->with('children', $children)
                    ->with('type_id', $type_id)
                    ->with('type', $type)
                    ->with('permissions', $permissions)
                    ->render();
            }
            else
            {
                $out .= view('hamahang.ACL.helper.permissions_categories_list')
                    ->with('item', $item)
                    ->with('type_id', $type_id)
                    ->with('type', $type)
                    ->with('permissions', $permissions)
                    ->render();
            }
        }
        return $out;
    }

}

if (!function_exists('checked_permission'))
{

    function checked_permission($items, $item_id)
    {
        foreach ($items as $item)
        {
            if ($item['id'] == $item_id)
            {
                return 'checked = "checked"';
            }
        }
        return '';
    }

}

if (!function_exists('render_view'))
{
    function render_view($view, $params = [])
    {
        $view = view($view, $params);
        return $view;
    }
}


///JUST FOR Sample
/**
 * @param string $type
 * @param string $sub_type
 * @param bool $item
 * @param array $params
 * @return array
 */
function variable_generator($type = "page", $sub_type = "desktop", $item = false, $params = [])
{
    $RightCol = array();
    switch ($type)
    {
        case 'page':
        {
            switch ($sub_type)
            {
                case 'forum':
                {
                    $sid = $item;
                    $uid = Auth::id();
                    $PageType = 'subject';
                    $subject = Subject::findOrFail($sid);
                    $pid = $subject->pages[0]->id;
                    $canView = policy_CanView($subject->id, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView', 403);
                    if(!$canView){
                        return 403;
                    }
                    $Title = $subject->title;
                    $current_tab = $item . '/forum';
                    $pc = new \App\HamafzaServiceClasses\PostsClass();
                    $content2 = json_encode($pc->SubjectWall($item, $uid, 0, ''));
                    $content2 = json_decode($content2);
                    $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title]], 1, 2, ['subject_id' => $sid, 'page_id' => $pid,'target_type'=>'subject','target_id'=>$sid]);
                    if (Auth::check())
                    {
                        $res = [
                            'viewname' => 'pages.contents',
                            'Tree' => '',
                            'Uname' => $item,
                            'PageTypes' => 'PageWall',
                            'PageType' => $PageType,
                            'sid' => $item,
                            'Small' => Auth::id(),
                            'current_tab' => $current_tab,
                            'content' => $content2,
                        ];
                        break;
                    }
                    else
                    {
                        $alert = 'برای دسترسی به این قسمت نیاز به عضویت دارید';
                        $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'forumWL')->select('a.comment')->first();
                        if ($alerts)
                        {
                            $alert = $alerts->comment;
                        }
                        $res = [
                            'viewname' => 'pages.publicwmr',
                            'PageType' => $PageType,
                            'Small' => $item,
                            'sid' => $item,
                            'current_tab' => $current_tab,
                            'content' => $alert,
                            'pid' => $item
                        ];
                        break;
                    }
                }
                case 'desktop':
                {
                    $sid = $item;
                    $subject = Subject::findOrFail($item);
                    $pid = $subject->pages[0]->id;
                    $canView = policy_CanView($subject->id, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView', 403);
                    if(!$canView){
                        return 403;
                    }
                    $auth_user = auth()->user();
                    $Title = $subject->title;
                    $PageType = 'subject';
                    $current_tab = $sid . '/desktop';
                    $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title]], 1, 3, ['subject_id' => $sid, 'page_id' => $pid,'target_type'=>'subject','target_id'=>$sid]);
                    if (auth()->check())
                    {
                        $res = [
                            'viewname' => 'pages.page_desktop_dashboard',
                            'desktop_sections' =>
                                [
                                    [
                                        'type' => 'tasks',
                                        'title' => 'وظایف',
                                        'order' => '1',
                                        'data' =>
                                            [
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'برنامه امروز',
                                                    'new' => '-1',
                                                    'value' => "0",
                                                    'icon' => 'fa-calendar',
                                                    'subData' => [
                                                        [
                                                            "title" => "روز",
                                                            "icon" => "",
                                                            "url" => ""
                                                        ],
                                                        [
                                                            "title" => "هفته",
                                                            "icon" => "",
                                                            "url" => ""
                                                        ],
                                                        [
                                                            "title" => "ماه",
                                                            "icon" => "",
                                                            "url" => route('ugc.desktop.hamahang.calendar.index',['username'=>$auth_user->Uname])
                                                        ]
                                                    ],
                                                    'url' => '#'
                                                ],
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'وظایف من',
                                                    'new' => '-1',
                                                    'value' => \App\Models\Hamahang\Tasks\tasks::MyTasks($pid, Auth::id(), 1),
                                                    'icon' => 'fa-tasks',
                                                    'url' => route('pgs.desktop.hamahang.tasks.my_tasks.list', ['sid' => $sid]),
                                                    'subData' => [
                                                        [
                                                            "title" => "",
                                                            "icon" => 'table-icon related-icons related-icons-desktop',
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_tasks.list',['sid' => $sid])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "priority-icon related-icons related-icons-desktop",
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_tasks.priority',['sid' => $sid])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "steps-icon related-icons related-icons-desktop",
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_tasks.state',['sid' => $sid])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "card-icon related-icons related-icons-desktop",
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_tasks.package',['sid' => $sid])
                                                        ]
                                                    ]
                                                ],
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'وظایف بدون وقت',
                                                    'new' => '-1',
                                                    'value' => "0",
                                                    'icon' => 'fa-list-alt',
                                                    'url' => '#',
                                                    'subData' => [
                                                        [
                                                            "title" => "",
                                                            "icon" => 'table-icon related-icons related-icons-desktop',
                                                            "url" => ''
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "priority-icon related-icons related-icons-desktop",
                                                            "url" => ''
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "steps-icon related-icons related-icons-desktop",
                                                            "url" => ''
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "card-icon related-icons related-icons-desktop",
                                                            "url" => ''
                                                        ]
                                                    ]
                                                ]
                                            ]
                                    ],
                                    [
                                        'type' => 'tasks',
                                        'title' => 'وظایف',
                                        'order' => '1',
                                        'data' =>
                                            [
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'واگذاری‌های من',
                                                    'new' => '-1',
                                                    'value' => \App\Models\Hamahang\Tasks\tasks::MyAssignedTasks(Auth::id(), $pid, true)->count(),
                                                    'icon' => 'fa-list-alt',
                                                    'subData' => [
                                                        [
                                                            "title" => "",
                                                            "icon" => 'table-icon related-icons related-icons-desktop',
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_assigned_tasks.list',['sid' => $sid])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "priority-icon related-icons related-icons-desktop",
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_assigned_tasks.priority',['sid' => $sid])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "steps-icon related-icons related-icons-desktop",
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_assigned_tasks.state',['sid' => $sid])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "card-icon related-icons related-icons-desktop",
                                                            "url" => route('pgs.desktop.hamahang.tasks.my_assigned_tasks.package',['sid' => $sid])
                                                        ]
                                                    ],
                                                    'url' => route('pgs.desktop.hamahang.tasks.my_assigned_tasks.list', ['sid' => $sid])
                                                ],
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'پیگیری‌ها',
                                                    'new' => '-1',
                                                    'value' => "0",
                                                    'icon' => 'fa-list-alt',
                                                    'url' => '#'
                                                ],
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'وظایف پیش‌نویس',
                                                    'new' => '-1',
                                                    'value' => "0",
                                                    'icon' => 'fa-pencil-square ',
                                                    'url' => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$auth_user->Uname]),
                                                    'subData' => [
                                                        [
                                                            "title" => "",
                                                            "icon" => 'table-icon related-icons related-icons-desktop',
                                                            "url" => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$auth_user->Uname])
                                                        ],
                                                        [
                                                            "title" => "",
                                                            "icon" => "priority-icon related-icons related-icons-desktop",
                                                            "url" => ''
                                                        ]
                                                    ]
                                                ]
                                            ]
                                    ],
                                    [
                                        'type' => 'tasks',
                                        'title' => 'وظایف',
                                        'order' => '1',
                                        'data' =>
                                            [
                                                [
                                                    'active' => '1',
                                                    'primary' => '1',
                                                    'title' => 'یادآوری‌ها',
                                                    'new' => '-1',
                                                    'value' => "0",
                                                    'icon' => 'fa fa-bell-o',
                                                    'url' => '#'
                                                ],
                                                [
                                                    'active' => '1',
                                                    'title' => 'یادداشت‌ها',
                                                    'new' => '-1',
                                                    'value' => auth()->user()->Announces()->whereHas('page', function ($q) use ($sid)
                                                        {
                                                            $q->whereHas('subject', function ($q) use ($sid)
                                                            {
                                                                $q->where('subjects.id', $sid);
                                                            });
                                                        })->get()->count() . "",
                                                    'icon' => 'fa-pencil',
                                                    'url' => route('page.desktop.announces', ['sid' => $sid])
                                                ],
                                                [
                                                    'active' => '1',
                                                    'title' => 'علامت گذاری‌ها',
                                                    'new' => '-1',
                                                    'value' => auth()->user()->Highlights()->whereHas('page', function ($q) use ($sid)
                                                        {
                                                            $q->whereHas('subject', function ($q) use ($sid)
                                                            {
                                                                $q->where('subjects.id', $sid);
                                                            });
                                                        })->get()->count() . "",
                                                    'icon' => 'fa-bookmark-o',
                                                    'url' => route('page.desktop.highlights', ['sid' => $sid])
                                                ],
                                            ]
                                    ],
                                ],
                            'PageType' => $PageType,
                            'sid' => $sid,
                            'pid' => $pid,
                            'current_tab' => $current_tab,
                            'uname' => $sid,
                            'keywords' => [],
                            'Files' => ''
                        ];
                        break;
                    }
                    else
                    {
                        $alert = 'برای دسترسی به این قسمت نیاز به عضویت دارید';
                        $res = [
                            'viewname' => 'pages.publicwmr',
                            'SiteTitle' => '',
                            'PageType' => $PageType,
                            'Small' => $item,
                            'sid' => $item,
                            'current_tab' => $current_tab,
                            'content' => $alert,
                            'keywords' => [],
                            'pid' => $item
                        ];
                        break;
                    }
                    break;
                }
                case 'edit':
                {
                    $uid = auth()->id();//(session('uid') != '') ? session('uid') : 0;
                    $sesid = (session('sesid') != '') ? session('sesid') : 0;
                    $PC = new \App\HamafzaViewClasses\PublicClass();
                    $menu = $PC->GetSiteMenu();
                    $pid = $item;
                    $PgC = new \App\HamafzaViewClasses\PageClass();
                    $page = $PgC->PageDetail($pid, $uid, $sesid, '', '1');
                    $page = str_ireplace('src="tinymce', 'src="/tinymce', $page);
                    $content = $page['Body'];
                    if ($content == 'EditNOK')
                    {
                        abort(403);//return redirect()->back()->with('message', 'شما اجازه ویرایش این صفحه را ندارید')->with('mestype', 'error');
                    }
                    $sid = $page['sid'];
                    $Type = $page['Type'];
                    $Title = $page['Title'];
                    $Description = $page['Description'];
                    $showDefimg = $page['showDefimg'];
                    $defimage = $page['defimage'];
                    $obj_defimage = \App\Models\Hamahang\FileManager\FileManager::find($defimage);
                    $page_id = $page['id'];
                    $tabname = $page['Tabname'];
                    $viewtext = $page['viewtext'];
                    $viewslide = $page['viewslide'];
                    $viewfilm = $page['viewfilm'];
                    $Title = "<span style='color:#000'>" . 'ویرایش زبانه ' . $tabname . ' در صفحه ' . "</span>" . $Title;
                    if ($page['editing'] == 1)
                    {
                        $Title .= '<div style="padding: 10px 20px 0 0;display: inline;  font-size:9pt">این صفحه از  ' . $page['last_date'] . ' توسط ' . $page['editUname'] . ' ' . $page['editUfamily'] . ' در حال ویرایش است ، شما نمی توانید ویرایش کنید .</div>';
                    }
                    $SiteLogo = config('constants.SiteLogo');
                    $tabs = $page['tabs'];
                    $keywords = $page['Keywords'];
                    $Files = $page['Files'];
                    /* $MyOrganGroups = '';
                      if (session('MyOrganGroups'))
                      {
                      $MyOrganGroups = session('MyOrganGroups');
                      } */
                    $Tree = $page['Tree'];
                    if (is_array($Tree) && count($Tree) > 0)
                    {
                        $newtree = $PC->CretaeTree1L($Tree, 'id', 'parent_id', 'url');
                        $newtree = $PC->Json(0, $newtree);
                    }
                    else
                    {
                        $newtree = '';
                    }
                    $PageTypes = 'subject';
                    $Slides = '';
                    //$Portals = []; // PageClass::GetProtals($uid, $sesid);
                    //$keywordTab = []; //KeywordClass::GetPublicKeyword($sesid, $uid);
                    $view = 'pages.PageEdit';
                    if ($params['PageType'] == 'text')
                    {
                        $Slides = '';
                        if ($Type == '7')
                        {
                            $view = 'pages.poodmanedit';
                        }
                        else
                        {
                            $view = 'pages.PageEdit';
                        }
                    }
                    elseif ($params['PageType'] == 'slide')
                    {
                        $Slides = $page['Slides'];
                        $view = 'pages.PageEditSlide';
                    }
                    elseif ($params['PageType'] == 'films')
                    {
                        $Slides = $page['Films'];
                        $view = 'pages.PageEditFilms';
                    }
                    if (!file_exists(public_path() . "/tinymce/upload-files/pages/" . $pid . "/"))
                    {
                        mkdir(public_path() . "/tinymce/upload-files/pages/" . $pid . "/", 0777, true);
                    }
                    $Upurl = "/tinymce/upload-files/pages/" . $pid . "/";
                    $UploadURL = url('/') . "/tinymce/upload-files/pages/" . $pid . "/";
                    $RightCol = '';
                    //$Rel = '';
                    if ($page['editing'] == 1)
                    {
                        $view = 'pages.public';
                        $PgC = new PageClass();
                        $RightCol = $PgC->GetRightCol($uid, $sesid, $sid, 'subjects');
                        //$Rel = $page['Rel'];
                    }
                    $tabs = json_encode($tabs);
                    $tabs = json_decode($tabs);
                    $tools = shortToolsGenerator('Page', $sid, ['uid' => Auth::id(), 'sessid' => 0, 'sid' => $sid], 0);
                    $tools_menu = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5,['subject_id' => $sid, 'page_id' => $pid,'target_type'=>'subject','target_id'=>$sid]);
                    $HFM_media = HFM_GenerateUploadForm(
                        [
                            ['page_file', ['zip', 'doc', 'docx', 'pdf', 'mpga', 'amr', 'xls', 'xlsx', 'ppt', 'pptx'], "Multi"],
                            ['page_file_edit', ['zip', 'doc', 'docx', 'pdf', 'mpga', 'amr', 'xls', 'xlsx', 'ppt', 'pptx'], "Multi"],
                        ]);
                    $res = [
                        'viewname' => $view,
                        'HFM_media' => $HFM_media,
                        //'MyOrganGroups' => $MyOrganGroups,
                        'PageType' => $PageTypes,
                        'SiteLogo' => $SiteLogo,
                        //'keywordTab' => $keywordTab,
                        //'Portals' => $Portals,
                        //'SiteTitle' => $SiteTitle,
                        'Title' => $Title,
                        'sid' => $sid,
                        //'Rel' => $Rel,
                        'RightCol' => $RightCol,
                        'viewtext' => $viewtext,
                        'viewslide' => $viewslide,
                        'viewfilm' => $viewfilm,
                        'pid' => $pid,
                        'menu' => $menu,
                        'content' => $content,
                        'showDefimg' => $showDefimg,
                        'defimage' => $defimage,
                        'item_id' => $page_id,
                        'image' => $obj_defimage,
                        'keywords' => $keywords,
                        'tabs' => $tabs,
                        'Tree' => $newtree,
                        'Slides' => $Slides,
                        'Files' => $Files,
                        'Description' => $Description,
                        'tools' => $tools,
                        'tools_menu' => $tools_menu,
                        'UploadURL' => $UploadURL,
                        'Upurl' => $Upurl,
                    ];
                    break;
                }
                case 'enquiry':
                {
                    $sid = $item / 10;
                    $sub_kind = Subject::find($sid)->sub_kind;
                    $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
                    $pid = $item;
                    $post_id = $params['post_id'];
                    $subject = Subject::findOrFail($sid);
                    $canView = policy_CanView($subject->id, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView', 403);
                    if(!$canView){
                        return 403;
                    }
                    $Title_page = $subject->title;
                    $pre_title = $subject->subject_type->pretitle;
                    $Title = $pre_title . ' ' . $Title_page;
                    $sid = $sid == false ? config('constants.default_enquiry_portal_id') : $sid;
                    $post = App\Models\hamafza\Post::where('portal_id', $sid)->findOrFail($post_id);
                    $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title]], 1, 5, ['subject_id' => $sid, 'page_id' => $pid,'target_type'=>'subject','target_id'=>$sid]);
                    $keywords = \App\Http\Controllers\Hamahang\EnquiryController::get_keywords($sid, config('constants.enquiry_sidebar_paginate'));
                    if (0)
                    {
                        view('hamahang.Enquiry.enquiry_view')->with(['sub_kind' => $sub_kind]);
                    }
					$PClass = new PageClass();
                    $files = $PClass->page_files($post_id);
                    $res =
                    [
                        'sub_kind' => $sub_kind,
                        'viewname' => 'hamahang.Enquiry.enquiry_view',
                        'PageType' => '',
                        'sid' => $sid,
                        'post' => $post,
                        'Title' => $Title,
                        'current_tab' => '',
                        'content' => '',
                        'uname' => $sid,
                        'keywords' => $keywords,
                        'Files' => $files
                    ];
                    break;
                }
                case 'history':
                {
                    $pageM = Pages::find($item);
                    if($pageM == null){
                        return 404;
                    }
                    if ($pageM)
                    {
                        $pid = $item;
                        $sid = $pageM->sid;
                        $subject = Subject::findOrFail($pageM->sid);
                        $canView = policy_CanView($subject->id, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView', 403);
                        if(!$canView){
                            return 403;
                        }
                        $Title_page = $pageM->subject->title;
                        $pre_title = $pageM->subject->subject_type->pretitle;
                        $Title = 'تاریخچه: ' . $pre_title . ' ' . $Title_page;
                        $PC = new \App\HamafzaViewClasses\PageClass();
                        $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title]], 1, 5, ['subject_id' => $sid, 'page_id' => $pid]);
                        $content = '';
                        $History = History::findOrFail($params['hid']);
                        if ($History)
                        {
                            $pc = new \App\HamafzaServiceClasses\PageClass();
                            $content = $History->body;
                            $content = $pc->modifyText($content, Auth::id(), $pid, $sid, '');
                        }
                        $res = [
                            'viewname' => 'pages.public',
                            'Alert' => '',
                            'view' => '',
                            'Descr' => '',
                            'Rel' => '',
                            'PageType' => 'subject',
                            'Title' => $Title,
                            'sid' => $sid,
                            'ContentType' => '',
                            'current_tab' => $pid,
                            'pid' => $pid,
                            'menu' => '',
                            'content' => $content,
                            'allowedittag' => '',
                            'allowdeltag' => '',
                            'keywords' => '',
                            'tabs' => '', //PageTabs('subject', $sid),
                            'Tree' => '',
                            'Files' => '',
                        ];
                    }
                    break;
                }
                case 'highlights':
                {
                    $res['viewname'] = 'pages.Desktop.highlights';
                    $subject = Subject::findOrFail($item);
                    $sid = $subject->id;
                    $my_subject_highlights = auth()->user()->Highlights()->whereHas('page', function ($q) use ($sid)
                    {
                        $q->whereHas('subject', function ($q) use ($sid)
                        {
                            $q->where('subjects.id', $sid);
                        });
                    })->get();
                    $Title = $subject->title;
                    $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $sid, 'title' => $Title]], 1, 3, ['subject_id' => $sid, 'page_id' => $sid]);
                    $res['PageType'] = 'subject';
                    $res['sid'] = $sid;
                    $res['current_tab'] = $sid . '/desktop';
                    $res['highlights'] = $my_subject_highlights;
                    break;
                }
                case 'announces':
                {
                    $res['viewname'] = 'pages.Desktop.announces';
                    $subject = Subject::findOrFail($item);
                    $sid = $subject->id;
                    $my_subject_highlights = auth()->user()->Announces()->whereHas('page', function ($q) use ($sid)
                    {
                        $q->whereHas('subject', function ($q) use ($sid)
                        {
                            $q->where('subjects.id', $sid);
                        });
                    })->orderBy('id', 'desc')->get();
                    $Title = $subject->title;
                    $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $sid, 'title' => $Title]], 1, 3, ['subject_id' => $sid, 'page_id' => $sid,'target_type'=>'subject','target_id'=>$sid,'target_type'=>'subject','target_id'=>$sid]);
                    $res['PageType'] = 'subject';
                    $res['sid'] = $sid;
                    $res['current_tab'] = $sid . '/desktop';
                    $res['highlights'] = $my_subject_highlights;
                    break;
                }
                default :
                {

                    $pageM = Pages::find($item);
                    if($pageM == null){
                        return 404;
                    }
                    $Type = $params['Type'];

                    if ($pageM)
                    {
                        $pid = $item;
                        $sid = $pageM->sid;
                        $subject = Subject::findOrFail($pageM->sid);
                        Session::put('subject_id',$subject->id);
                        $canView = policy_CanView($subject->id, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canView', 403);
                        if(!$canView){
                            return 403;
                        }
                        $Title_page = $pageM->subject->title;
                        $pre_title = isset($pageM->subject->subject_type->pretitle) ? $pageM->subject->subject_type->pretitle : '';
                        $Title = $pre_title . ' ' . $Title_page;
                        $PC = new \App\HamafzaViewClasses\PageClass();

                        $res = $PC->CreatPageView($pid, $params['Type'], $params['PreCode']);
                        $res = array_merge($res, ['keywords' => $pageM->subject->keywords()->with('synonym_relations')->with('synonym_relations_reverse')->get()]);
                        $keywords_relations = [];
                        foreach ($res['keywords'] as $res_keyword_key => $res_keyword)
                        {
                            foreach ($res_keyword->synonym_relations as $synonym_relations)
                            {
                                if ($temp = Keyword::find($synonym_relations->keyword_2_id))
                                {
                                    $keywords_relations[$temp->id] = $temp->title;
                                }
                            }
                            foreach ($res_keyword->synonym_relations_reverse as $synonym_relations_reverse)
                            {
                                if ($temp = Keyword::find($synonym_relations_reverse->keyword_1_id))
                                {
                                    $keywords_relations[$temp->id] = $temp->title;
                                }
                            }
                            $res['keywords'][$res_keyword_key]->keyword_has_relation = (bool) $keywords_relations;
                            $keywords_relations[$res_keyword->id] = $res_keyword->title;
                            $res['keywords'][$res_keyword_key]->keyword_and_relations_json = json_encode($keywords_relations);
                        }
                        $options[1] = ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title];
                        if(Auth::id())
                        {
                            $access_edit_in_user = in_array(Auth::id(), array_column($subject->user_policies_edit->toArray(), 'id'));
                            $user = User::where('id', Auth::id())->first();
                            $roles = $user->_roles->toArray();
                            foreach($roles as $Arole)
                            {
                                $access_edit_in_role = in_array($Arole['id'], array_column($subject->role_policies_edit->toArray(), 'id'));
                                if($access_edit_in_role)
                                    break;
                            }

                            if($access_edit_in_user || $access_edit_in_role)
                                $options[13] = [];
                            elseif($subject->toArray()['admin']==Auth::id())
                                $options[13] = [];

                        }

                        $tools_menu = toolsGenerator($options, 1, 5, ['subject_id' => $sid, 'page_id' => $pid,'target_type'=>'page','target_id'=>$pid]);
                        switch ($subject->kind)
                        {
                            case '99':
                            {
                                $job = onet_job::where('sid', '=', $sid)->with('skill', 'skill.skill', 'ability', 'ability.ability', 'knowledge', 'knowledge.knowledge')->first();
                                $res =
                                    [
                                        'viewname' => 'hamahang.OrgChart.jobItem',
                                        'pid' => $pid,
                                        'sid' => $sid,
                                        'job' => $job,
                                        'current_tab' => $pid
                                    ];
                                break;
                            }
                            case '20':
                            {
                                $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
                                if($subject->sub_kind == 5)
                                {
//                                    ini_set('max_execution_time', 300000);
//                                    ini_set('memory_limit','160M');
//                                    $cntId = 10584;
//                                    for($i=609;$i++;$i<=1135) {
//                                        $job = onet_job::where('id', '=', $i)->first();
//                                        $SP = new SubjectsClass();
//                                        $SP->AddSubject($cntId, null, [0=>1], null, [0=>3], null, 5089, 0, isset($job->title) ? $job->title : '', "on", "99", "", "1", null, null, null, 99, null);
//                                        $job->sid = $cntId++;
//                                        $job->save();
//                                    }
//                                    for($i=551;$i++;$i<=1135)
//                                    {
//                                        $job = \App\Models\hamahang\OrgChart\onet_job::where('id','=',$i)->first();
//                                        if(isset($job->lblKnowledge)){
//                                            $lblKnowledge = json_decode($job->lblKnowledge);
//                                            if(is_object($lblKnowledge))
//                                            {
//                                                foreach($lblKnowledge as $key => $value)
//                                                {
//                                                    if(stristr($key, 'FAElementNameLabel'))
//                                                    {
//                                                        $subs = preg_split('/_/', $key);
//                                                        $des_key = 'dlstKnowledge_FADescriptionLabel_'.$subs[2];
//                                                        $knowledge = onet_knowledge::where('label', '=', $value)->first();
//                                                        if(count($knowledge)==0){
//                                                            $knowledge = onet_knowledge::create([
//                                                                'label' => $value,
//                                                                'description' => $lblKnowledge->{$des_key}
//                                                            ]);
//                                                        }
//                                                        onet_job_knowledge::create([
//                                                            'knowledge_id' => $knowledge->id,
//                                                            'job_id' => $job->id
//                                                        ]);
//                                                    }
//                                                }
//                                            }
//                                        }
//                                        if(isset($job->lblSkill))
//                                        {
//                                            $lblSkill = json_decode($job->lblSkill);
//                                            if(is_object($lblSkill)){
//                                                foreach($lblSkill as $key => $value)
//                                                {
//                                                    if(stristr($key, 'FAElementNameLabel'))
//                                                    {
//                                                        $subs = preg_split('/_/', $key);
//                                                        $des_key = 'dlstSkills_FADescriptionLabel_'.$subs[2];
//                                                        $skill = onet_skill::where('label', '=', $value)->first();
//                                                        if(count($skill)==0){
//                                                            $skill = onet_skill::create([
//                                                                'label' => $value,
//                                                                'description' => $lblSkill->{$des_key}
//                                                            ]);
//                                                        }
//                                                        onet_job_skill::create([
//                                                            'skill_id' => $skill->id,
//                                                            'job_id' => $job->id
//                                                        ]);
//                                                    }
//                                                }
//                                            }
//
//                                        }
//                                        if(isset($job->lblAbility))
//                                        {
//                                            $lblAbility = json_decode($job->lblAbility);
//                                            if(is_object($lblAbility))
//                                            {
//                                                foreach($lblAbility as $key => $value)
//                                                {
//                                                    if(stristr($key, 'dlstAbilities_FAElementNameLabel'))
//                                                    {
//                                                        $subs = preg_split('/_/', $key);
//                                                        $des_key = 'dlstAbilities_FADescriptionLabel_'.$subs[2];
//                                                        $ability = onet_ability::where('label', '=', $value)->first();
//                                                        if(count($ability)==0){
//                                                            $ability = onet_ability::create([
//                                                                'label' => $value,
//                                                                'description' => $lblAbility->{$des_key}
//                                                            ]);
//                                                        }
//                                                        onet_job_ability::create([
//                                                            'ability_id' => $ability->id,
//                                                            'job_id' => $job->id
//                                                        ]);
//                                                    }
//                                                }
//                                            }
//                                        }
//                                    }
//
//                                    echo '<pre>';
//                                    print_r($lblKnowledge);
//                                    echo '</pre>';
//                                    dd($job, ($job->lblDescription), json_decode($job->lblKnowledge), json_decode($job->lblSkill), json_decode($job->lblAbility));
                                    $res =
                                        [
                                            'viewname' => 'hamahang.OrgChart.jobPortal',
                                            'pid' => $pid,
                                            'body' => $pageM->body,
                                            'sid' => $sid,
//                                            'job' => $job,
                                            'current_tab' => $pid,
                                        ];
                                }else{
                                    $sid = $sid == false ? config('constants.default_enquiry_portal_id') : $sid;
                                    $Title = $subject->title;
                                    $sub_kind = Subject::find($sid)->sub_kind;
                                    $sub_kind = 0 == $sub_kind ? 2 : $sub_kind;
                                    $posts = \App\Models\hamafza\Post::where('type', 0 == $sub_kind ? 2 : $sub_kind)->where('portal_id', $sid)->orderBy('reg_date', 'desc')->get();
                                    //$tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title]], 1, 5, ['subject_id' => $sid, 'page_id' => $pid]);
                                    $keywords = \App\Http\Controllers\Hamahang\EnquiryController::get_keywords($sid, config('constants.enquiry_sidebar_paginate'));
                                    Session::put('enquiry_body',$pageM->body);
                                    if (\Request::exists('tagid'))
                                    {
                                        $keyword = \App\Models\hamafza\Keyword::find(\Request::get('tagid'));
                                        $res =
                                            [
                                                'viewname' => 'hamahang.Enquiry.enquiry_index',
                                                'posts' => $posts,
                                                'pid' => $pid,
                                                'body' => $pageM->body,
                                                'sid' => $sid,
                                                'sub_kind' => $sub_kind,
                                                'keywords' => $keywords,
                                                'current_tab' => $pid,
                                                'keyword' => $keyword,
                                            ];
                                    } else
                                    {
                                        $res =
                                            [
                                                'viewname' => 'hamahang.Enquiry.enquiry_index',
                                                'posts' => $posts,
                                                'pid' => $pid,
                                                'body' => $pageM->body,
                                                'sid' => $sid,
                                                'sub_kind' => $sub_kind,
                                                'keywords' => $keywords,
                                                'current_tab' => $pid,
                                            ];
                                    }
                                }
                                break;
                            }
                            case '22':
                            {
                                $sid = $sid == false ? config('constants.news_default_portal_id') : $sid;
                                $Title = $subject->title;
                                $contents = \App\Models\hamafza\Subject::where('kind', '11')/*->where('portal_id', $sid)*/
                                ->orderBy('reg_date')->get();
                                $tools_menu = toolsGenerator([1 => ['uid' => Auth::id(), 'sid' => $sid, 'type' => 'subject', 'pid' => $pid, 'title' => $Title]], 1, 5, ['subject_id' => $sid, 'page_id' => $pid,'target_type'=>'subject','target_id'=>$sid]);
                                $keywords = \App\Http\Controllers\Hamahang\NewsController::get_keywords($sid, config('constants.news_sidebar_paginate'));
                                if (0)
                                {
                                    view('hamahang.news.news_index');
                                }
                                $res =
                                    [
                                        'viewname' => 'hamahang.news.news_index',
                                        'contents' => $contents,
                                        'pid' => $pid,
                                        'sid' => $sid,
                                        'current_tab' => $pid,
                                        'keywords' => $keywords,
                                    ];
                                if (\Request::exists('tagid'))
                                {
                                    $res['keyword'] = \App\Models\hamafza\Keyword::find(\Request::get('tagid'));
                                }
                                else
                                {

                                }
                                break;
                            }
                            // درخت کلیدواژه
                            case '68':
                            {
                                $keywords = $subject->thesaurus_keywords()->withPivot(['id'])->get(['keyword_id AS id', 'title AS text', ]);
                                foreach ($keywords as $k => $keyword)
                                {
                                    $keyword_relation_1 = KeywordRelation::whereRaw("keyword_1_id = $keyword->id AND relation_type IN ('1', '3', '5')")->with('keywords_1')->get(['id', 'keyword_1_id', 'keyword_2_id', 'relation_type'])->first();
                                    if ($keyword_relation_1)
                                    {
                                        $keyword->parent_id = $keyword_relation_1['keyword_2_id'];
                                    } else
                                    {
                                        $keyword_relation_2 = KeywordRelation::whereRaw("keyword_2_id = $keyword->id AND relation_type IN ('110', '310', '510')")->with('keywords_2')->get(['id', 'keyword_1_id', 'keyword_2_id', 'relation_type'])->first();
                                        if ($keyword_relation_2)
                                        {
                                            $keyword->parent_id = $keyword_relation_2['keyword_1_id'];
                                        } else
                                        {
                                            $keyword->parent_id = 0;
                                        }
                                    }
                                }
                                $flat_array = $keywords->toArray();
                                $trees = buildTree($flat_array, 'parent_id', 0, 'id', 'children', true);
                                $trees[0]['state'] = ['opened' => 'true', 'selected' => 'true'];
                                $Title = $subject->title;
                                $posts = \App\Models\hamafza\Post::where('type', '2')->where('portal_id', $sid)->orderBy('reg_date', 'desc')->get();
                                $res =
                                [
                                    'viewname' => 'hamahang.thesaurus',
                                    'trees' => json_encode($trees),
                                    'posts' => $posts,
                                    'pid' => $pid,
                                    'sid' => $sid,
                                    'current_tab' => $pid,
                                ];
                                break;
                            }
                        }
                    }
                }
            }
            return array_merge
            (
                [
                    'RightCol' => RightCol($sid, 'subjects'),
                    'tabs' => PageTabs('subject', $sid),
                    'Title' => $Title,
                    'SiteTitle' => config('constants.SiteTitle'),
                    'tools' => shortToolsGenerator('Page', $sid, ['uid' => Auth::id(), 'sessid' => 0, 'sid' => $sid], 0),
                    'tools_menu' => $tools_menu,
                    'desktop_menu' => menuGenerator(2, 'tree', $sid),
                    'ContentType' => (isset($params['Type']) && $params['Type'] == 'OnlyTree') ? 'OnlyTree' : ''
                ], $res
            );
            break;
        }
        case 'user':
        {
            $uid = Auth::id();
            $user = User::where('Uname', $item)->first();
            //dd($item,$user);
//            dd($user->works[0]->jalali_start_year);
//            foreach ($user->works as $work){
//                $work->jalali_start_year = HDate_GtoJ($work->start_year, 'Y/m/d');
//                $work->jalali_end_year = HDate_GtoJ($work->end_year, 'Y/m/d');
//            }
            $user_id = $user->id;
            $Title = $user->Name . ' ' . $user->Family;
            $PageType = 'desktop';
            $current_tab = 'desktop';
            $shortTools = shortToolsGenerator('User', $user_id, ['uid' => $uid, 'sessid' => $user->id, 'userid' => $user_id], ['pageid' => 0, 'tagname' => 0, 'id' => 0]); //$tools['abzar'];
            if ($user->id == $uid)
            {
                $MenuTools = toolsGenerator([5 => ['user_id' => $uid, 'uid' => $uid, 'sid' => 0]], 1, 5);
            }
            else
            {
                $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
            }
            $tabs = json_decode(json_encode(PageTabs('user', $user->id)));
            $viewname = 'pages.Desktop';
            $res = array();
            switch ($sub_type)
            {
                case 'asubadd':
                {
                    $SP = new \App\HamafzaServiceClasses\ConfigurationClass();
                    $s = $SP->GetSubjetData($uid, 0);
                    $FC = new \App\HamafzaServiceClasses\FormsClass();
                    $FieldType = $FC->FiledType();
                    $Fileds = $s['Fileds'];
                    $Fileds = json_encode($Fileds);
                    $Fileds = json_decode($Fileds);
                    $Process = $s['Process'];
                    $Process = json_encode($Process);
                    $Process = json_decode($Process);
                    $SecGroups = json_encode($s['SecGroups']);
                    $SecGroups = json_decode($SecGroups);
                    $Framework = json_encode($s['Framework']);
                    $Framework = json_decode($Framework);
                    $Departments = json_encode($s['Portals']);
                    $Departments = json_decode($Departments);
                    $Alerts = json_encode($s['Alerts']);
                    $Alerts = json_decode($Alerts);
                    //dd($params);
                    if ($params != [])
                    {
                        $from_menu = '1';
                    }
                    else
                    {
                        $from_menu = '';
                    }
                    $res =
                        [
                            'viewname' => 'pages.Desktop.ADD.AsubjectADD',
                            'FieldType' => $FieldType,
                            'Fileds' => $Fileds,
                            'SecGroup' => $SecGroups,
                            'Framework' => $Framework,
                            'Process' => $Process,
                            'Departments' => $Departments,
                            'Alerts' => $Alerts,
                            'from_menu' => $from_menu,
                        ];
                    break;
                }
                case 'bazaar_requirements':
                    $username = ['Uname' => auth()->user()->Uname];
                    $url_cart = route('ugc.desktop.hamahang.bazaar.cart', $username);
                    $url_shipping = route('ugc.desktop.hamahang.bazaar.shipping', $username);
                    $url_review = route('ugc.desktop.hamahang.bazaar.review', $username);
                    $url_payment = route('ugc.desktop.hamahang.bazaar.payment', $username);
                    $url_pay = route('ugc.desktop.hamahang.bazaar.pay', $username);
                    $url_invoices = route('ugc.desktop.hamahang.bazaar.invoices.index', $username);
                    $cart = Session::get('cart');
                    $cart_setting = Session::get('cart_setting');
                    $cart_coupons = Session::get('cart_coupons');
                    $cart_invoice = Session::get('cart_invoice');
                    $r =
                        [
                            'url_cart' => $url_cart,
                            'url_shipping' => $url_shipping,
                            'url_review' => $url_review,
                            'url_payment' => $url_payment,
                            'url_pay' => $url_pay,
                            'url_invoices' => $url_invoices,
                            'cart' => $cart,
                            'cart_setting' => $cart_setting,
                            'cart_coupons' => $cart_coupons,
                            'cart_invoice' => $cart_invoice,
                        ];
                    return $r;
                    break;
                case 'About':
                    if(isset($user->educations))
                    {
                        foreach ($user->educations as $education)
                        {
                            $education->jalali_s_year = HDate_GtoJ($education->s_year, 'Y/m/d');
                            $education->jalali_e_year = HDate_GtoJ($education->e_year, 'Y/m/d');
                        }
                    }
                    $alert = \App\Models\Hamahang\Alert::find(51);
                    if (session('NewUser') == 'NewUser')
                    {
                        $alerts = DB::table('function_alert as f')
                            ->join('alerts as a', 'a.id', '=', 'f.alertid')
                            ->where("functionname", 'Abouuser')
                            ->select('a.comment')->first();
                        if ($alerts)
                        {
                            $alert = $alerts->comment;
                        }
                        session(['NewUser' => '']);
                    }
                    $PageType = 'user';
                    $RightCol = RightCol($uid, 'user_about');
                    $user_comment = \App\Models\hamafza\UserProfile::where('uid', $uid)->pluck('Comment')->first();
                    $res = [
                        'alert' => $alert,
                        'user_education' => '',//$user_data['user_education'],
                        'Ostan' => '', //$Ostan,
                        'user_work' => '', //$user_data['user_work'],
                        'user_special' => '', //$user_data['user_special'],
                        //'specials' => $user->specials,
                        'preview' => '', //$user_data['preview'],
                        'user_comment' => $user_comment, //$user_data['preview'],
                        'PageType' => 'aboutuser',
                        'pid' => 'intro',
                        'content' => '', //$Ab
                        'provinces' => json_encode(\App\Models\Hamahang\ProvinceCity\Province::get(['id', 'name as text'])),
                        'cities' => json_encode(\App\Models\Hamahang\ProvinceCity\City::get(['id', 'name as text'])),
                    ];
                    $res['avatar'] = enCode($user->avatar);
                    $res['user'] = $user;
//                    $res['Alert'] = $alert;
                    $current_tab = 'intro';
                    $viewname = 'pages.about_user';
                    break;
                case 'wall':
                    $SN = new App\HamafzaViewClasses\SNClass();
                    $res = $SN->UserWall($item);
                    $current_tab = 'wall';
                    $RightCol = RightCol($uid, 'userwall');
                    $viewname = 'pages.contents';
                    break;
                case 'Content':
                    $SN = new App\HamafzaViewClasses\SNClass();
                    $res = $SN->UserContents($item);
                    $current_tab = 'contents';
                    $RightCol = RightCol($uid, 'userwall');
                    $viewname = 'pages.contents';
                    break;
                case 'DefDesktop':
                    $viewname = 'pages.user_desktop_dashboard';
                    $res = DesktopClass::DrawDashboard($user_id);
                    $auth_user = auth()->user();
                    if($auth_user==null){
                        return 403;
                    }
                    $res ['desktop_sections'] =
                        [
                            [
                                'type' => 'times',
                                'title' => 'برنامه امروز',
                                'order' => '1',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'برنامه امروز',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa-calendar',
                                            'subData' => [
                                                [
                                                    "title" => "روز",
                                                    "icon" => "",
                                                    "url" => ""
                                                ],
                                                [
                                                    "title" => "هفته",
                                                    "icon" => "",
                                                    "url" => ""
                                                ],
                                                [
                                                    "title" => "ماه",
                                                    "icon" => "",
                                                    "url" => route('ugc.desktop.hamahang.calendar.index',['username'=>$auth_user->Uname])
                                                ]
                                            ],
                                            'url' => '#'
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'وظایف من',
                                            'new' => '-1',
                                            'value' => $auth_user->MyTasksCount(),
                                            'icon' => 'fa-tasks',
                                            'url' => route('ugc.desktop.hamahang.tasks.my_tasks.list', ['username' => $auth_user->Uname]),
                                            'subData' => [
                                                [
                                                    "title" => "",
                                                    "icon" => 'table-icon related-icons related-icons-desktop',
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_tasks.list',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "priority-icon related-icons related-icons-desktop",
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_tasks.priority',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "steps-icon related-icons related-icons-desktop",
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_tasks.state',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "card-icon related-icons related-icons-desktop",
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_tasks.package',['username'=>$auth_user->Uname])
                                                ]
                                            ],
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'وظایف بدون وقت',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa-list-alt',
                                            'url' => '#',
                                            'subData' => [
                                                [
                                                    "title" => "",
                                                    "icon" => 'table-icon related-icons related-icons-desktop',
                                                    "url" => ''
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "priority-icon related-icons related-icons-desktop",
                                                    "url" => ''
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "steps-icon related-icons related-icons-desktop",
                                                    "url" => ''
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "card-icon related-icons related-icons-desktop",
                                                    "url" => ''
                                                ]
                                            ]
                                        ]
                                    ]
                            ],
                            [
                                'type' => 'tasks',
                                'title' => 'وظایف',
                                'order' => '1',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'جلسات',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa-tasks',
                                            'url' => '#',
                                            'subData' => [
                                                [
                                                    "title" => "",
                                                    "icon" => "fa fa-list-alt",
                                                    "url" => ''
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "fa fa-calendar",
                                                    "url" => ''
                                                ]
                                            ]
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'فرم‌های من',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa-wpforms',
                                            'url' => '#'
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'یادآوری‌ها',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa fa-bell-o',
                                            'url' => '#'
                                        ]
                                    ]
                            ],
                            [
                                'type' => 'tasks',
                                'title' => 'وظایف',
                                'order' => '1',
                                'data' =>
                                    [
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'واگذاری‌های من',
                                            'new' => '-1',
                                            'value' => $auth_user->MyAssignedTasksCount(),
                                            'icon' => 'fa-list-alt',
                                            'subData' => [
                                                [
                                                    "title" => "",
                                                    "icon" => 'table-icon related-icons related-icons-desktop',
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "priority-icon related-icons related-icons-desktop",
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.priority',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "steps-icon related-icons related-icons-desktop",
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.state',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "card-icon related-icons related-icons-desktop",
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.package',['username'=>$auth_user->Uname])
                                                ]
                                            ],
                                            'url' => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'پیگیری‌ها',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa-list-alt',
                                            'url' => '#'
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'وظایف پیش‌نویس',
                                            'new' => '-1',
                                            'value' => "$auth_user->MyDraftTasksCount",
                                            'icon' => 'fa-pencil-square ',
                                            'url' => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$auth_user->Uname]),
                                            'subData' => [
                                                [
                                                    "title" => "",
                                                    "icon" => 'table-icon related-icons related-icons-desktop',
                                                    "url" => route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    "icon" => "priority-icon related-icons related-icons-desktop",
                                                    "url" => ''
                                                ]
                                            ]
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
                                            'primary' => '1',
                                            'title' => 'دنبال شده‌ها',
                                            'new' => '-1',
                                            'value' => "0",
                                            'icon' => 'fa-bookmark',
                                            "url" => route('ugc.desktop.Hamahang.files.follow_ME',['username'=>$auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'پیام‌ها',
                                            'new' => "$auth_user->NewRecieveTicketsCount",
                                            'value' => "$auth_user->RecieveTicketsCount",
                                            'icon' => 'fa-inbox',
                                            'subData' => [
                                                [
                                                    "title" => "",
                                                    "icon" => "fa fa-inbox",
                                                    "url" => route('ugc.desktop.hamahang.tickets.inbox', ['username' => $auth_user->Uname])
                                                ],
                                                [
                                                    "title" => "",
                                                    'icon' => 'fa fa-paper-plane-o',
                                                    'url' => route('ugc.desktop.hamahang.tickets.outbox', ['username' => $auth_user->Uname])
                                                ]
                                            ],
                                            'url' => route('ugc.desktop.hamahang.tickets.inbox', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '0',
                                            'primary' => '1',
                                            'title' => 'خرید‌ها',
                                            'new' => '-1',
                                            'value' => '0',
                                            'icon' => 'fa-shopping-basket',
                                            'url' => '#'
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
                                            'primary' => '1',
                                            'title' => 'یادداشت‌ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->AnnouncesCount",
                                            'icon' => 'fa-pencil',
                                            'url' => route('ugc.desktop.announces', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'علامت گذاری‌ها',
                                            'new' => '-1',
                                            'value' => "$auth_user->HighlightsCount",
                                            'icon' => 'fa-bookmark-o',
                                            'url' => route('ugc.desktop.highlights', ['username' => $auth_user->Uname])
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '1',
                                            'title' => 'گروه ها و کانال ها',
                                            'new' => User::UserPostsOfGroupsANDChannelsCount(),
                                            'value' => "$auth_user->ApiUserGroupsCount",
                                            'icon' => 'fa-users',
                                            'url' => '/4'
                                        ]
                                    ]
                            ],
                            [
                                'type' => 'announces_and_forms_and_marked',
                                'title' => 'یادداشت‌ها، فرم‌ها',
                                'order' => '4',
                                'data' =>
                                    [
                                        [
                                            'active' => '0',
                                            'primary' => '0',
                                            'title' => 'شاید بشناسید',
                                            'new' => '-1',
                                            'value' => '0',
                                            'icon' => 'fa-user-o',
                                            'url' => '#'
                                        ],
                                        [
                                            'active' => '0',
                                            'primary' => '0',
                                            'title' => 'دفترچه تماس',
                                            'new' => '-1',
                                            'value' => '---',
                                            'icon' => 'fa-commenting ',
                                            'url' => '#'
                                        ],
                                        [
                                            'active' => '1',
                                            'primary' => '0',
                                            'title' => 'امتیاز‌ها',
                                            'new' => '-1',
                                            'value' => get_user_sumscores(),
                                            'icon' => 'fa-certificate ',
                                            'url' => route('ugc.desktop.hamahang.summary.index', ['username' => $auth_user->Uname])
                                        ]
                                    ]
                            ]
                        ];
                    $res['pid'] = 'desktop';
                    break;
                case 'subst':
                    $viewname = 'pages.Desktop';
                    $res = App\HamafzaViewClasses\substclass::show();
                    $res['pid'] = 'desktop';
                    break;
                case 'subst_edit':
                    $viewname = 'pages.Desktop.subst';
                    $res = App\HamafzaViewClasses\substclass::edit($params['id']);
                    break;
                case 'subst_add':
                    $viewname = 'pages.Desktop.subst';
                    $res['pid'] = 'desktop';
                    $res['id'] = 0;
                    $res['fist'] = '';
                    $res['second'] = '';
                    break;
                case 'Desktop_subjects':
                    $viewname = 'pages.Desktop';
                    $res['content'] = \App\HamafzaGrids\SubjectGrids::SubjectLists($uid);
                    $res['pid'] = 'desktop';
                    break;
                /*
                case 'Desktop_relations':
                    $viewname = 'pages.Desktop';
                    $res['content'] = \App\HamafzaGrids\SubjectGrids::GetRelations();
                    $res['pid'] = 'desktop';
                    break;
                case 'Desktop_relations_add':
                    $content = '';
                    $viewname = 'pages.Desktop.editrelations';
                    $res = App\HamafzaViewClasses\SubjectClass::relations_add($item);
                    break;
                case 'Desktop_relations_id':
                    $content = '';
                    $viewname = 'pages.Desktop.editrelations';
                    $res = App\HamafzaViewClasses\SubjectClass::relations_edit($item, $params['id']);
                    break;
                */
                case 'Desktop_subjects_id':
                    $content = '';
                    $viewname = 'pages.Desktop.editsubtype';
                    $res = App\HamafzaViewClasses\SubjectClass::subjects_edit($item, $params['subject_id']);
                    break;
                case 'Desktop_subject_field':
                    $res = App\HamafzaViewClasses\FormClass::GetFields($item);
                    $res['pid'] = 'desktop';
                    break;
                case 'Desktop_alerts':
                    $SP = new App\HamafzaServiceClasses\PublicsClass();
                    $res['content'] = \App\HamafzaGrids\UsersGrids::alertGroup($SP::Alerts());
                    $res['pid'] = 'desktop';
                    break;
                case 'alerts_edit':
                    $res = \App\HamafzaViewClasses\UsersClass::EditAlert($item);
                    $res['pid'] = 'desktop';
                    $viewname = 'pages.Desktop.ADD.alertadd';
                    break;
                case 'alerts_add':
                    $res = ['Comment' => '', 'id' => '0', 'name' => '', 'content' => ''];
                    $res['pid'] = 'desktop';
                    $viewname = 'pages.Desktop.ADD.alertadd';
                    break;
                case 'user_list':
                    $res['pid'] = 'desktop';
                    $viewname = 'hamahang.Users.index';
                    break;
                case 'user_list_edit':
                    $viewname = 'pages.Desktop';
                    $res = \App\HamafzaViewClasses\UsersClass::GetUserDetail($item);;
                    break;
                case 'showgroups':
                    $viewname = 'hamahang.Users.groups';
                    //$res = \App\HamafzaViewClasses\UsersClass::showgroupsList();
                    break;
                case 'notifications':
                    $viewname = 'pages.Desktop';
                    $res = \App\HamafzaViewClasses\UsersClass::Alerts();
                    break;
                case 'form_list':
                    $viewname = 'pages.Desktop';
                    $res = \App\HamafzaViewClasses\FormClass::SelectType($item, $params['sublink']);
                    break;
                case 'announces':
                    $viewname = 'pages.desktopcontents';
                    $res = \App\HamafzaViewClasses\UsersClass::Getannounces();
                    break;
                case 'highlights':
                    $viewname = 'pages.Desktop.highlights';
                    $my_highlights = auth()->user()->Highlights;
                    $res['highlights'] = $my_highlights;
                    break;
                case 'Files':
                {
                    $viewname = 'pages.desktopcontents';
                    //$res = \App\HamafzaViewClasses\SubjectClass::MyPages($params['type']);
                    $res =
                    [
                        'viewname' => 'pages.Desktop.showpages',
                        'PageType' => 'desktop',
                        'sid' => $uid,
                        'current_tab' => 'desktop',
                    ];
                    break;
                }
                case 'keywords':
                    //$res = \App\HamafzaViewClasses\KeywordClass::keywords($params['sublink']);
                    $res = [
                        'viewname' => 'pages.Desktop.keywords_list'
                    ];
                    break;
                case 'message_inbox':
                    /* $ret = DesktopClass::USER($item);
                     $M = new \App\HamafzaServiceClasses\MessageClass();
                     $s = $M->inbox(auth()->id(), 0);
                     $C = \App\HamafzaGrids\MessageDataGrid::inbox($s);
                     $uid = session('uid');
                     $res = [
                         'PageType' => 'desktop',
                         'SiteTitle' => $ret['SiteTitle'],
                         'sid' => $uid,
                         'Title' => $ret['Title'],
                         'Small' => $ret['Small'],
                         'uname' => $ret['uname'],
                         'pid' => 'desktop',
                         'menu' => $ret['menu'],
                         'content' => $C,
                     ];*/
                    break;
                case 'message_outbox':
                    /* $ret = DesktopClass::USER($item);
                      $M = new \App\HamafzaServiceClasses\MessageClass();
                      $s = $M->Outbox(auth()->id(), 0);
                      $C = \App\HamafzaGrids\MessageDataGrid::outbox($s);
                      $uid = session('uid');
                      $res = [
                          'PageType' => 'desktop',
                          'SiteTitle' => $ret['SiteTitle'],
                          'sid' => $uid,
                          'Title' => $ret['Title'],
                          'Small' => $ret['Small'],
                          'uname' => $ret['uname'],
                          'pid' => 'desktop',
                          'menu' => $ret['menu'],
                          'content' => $C,
                      ];*/
                    break;
                default:
                {
                    break;
                }
            }

            return array_merge(
                [
                    'Tree' => '',
                    'Title' => $Title,
                    'SiteTitle' => config('constants.SiteTitle'),
                    'current_tab' => $current_tab,
                    'viewname' => $viewname,
                    'PageType' => $PageType,
                    'Small' => $user_id,
                    'sid' => $user_id,
                    'uname' => $item,
                    'tabs' => $tabs,
                    'UserTabs' => $tabs,
                    'tools' => $shortTools,
                    'tools_menu' => $MenuTools,
                    'RightCol' => $RightCol
                ], $res
            );
            break;
        }
        case 'group':
        {
            $gname = $item;
            $uid = Auth::id();
            if ($sub_type != "edit"){
                $Group = \App\Models\hamafza\Groups::where('link', $item)->first();
            } else {
                $Group = \App\Models\hamafza\Groups::find($item);
            }
            $isMember = isGroupMemeber($Group->id);
            $isAdmin = (auth()->id() == $Group->uid);
            $option = 6;
            if ($isAdmin){
                if ($Group->isorgan == "1"){
                    $option = 10;
                } else {
                    $option = 7;
                }
            }
            else
            {
                 if ($Group->isorgan == "1"){
                    $option = 12;
                } else {
                    $option = 9;
                }
            }

            $PageType = 'group';
            $tabparam['uid'] = $uid;
            $viewname = 'pages.Desktop';
            $res = array();
            $current_tab = '';
            switch ($sub_type)
            {
                case 'About':
                {
                    $RightCol = RightCol($uid, 'userabout');
                    $SN = new \App\HamafzaViewClasses\GroupClass();
                    $res = $SN->about($gname);
                    $RightCol = RightCol($uid, 'groups_about');
                    $viewname = 'pages.public';
                    $current_tab = 'intro';
                    break;
                }
                case 'Persons':
                {
                    $SN = new \App\HamafzaViewClasses\GroupClass();
                    $res = $SN->Group_Persons($gname);
                    $RightCol = RightCol($uid, 'userwall');
                    $viewname = 'pages.groupperson';
                    $current_tab = 'desktop';
                    break;
                }
                case 'Content':
                {
                    $SN = new \App\HamafzaViewClasses\GroupClass();
                    $res = $SN->Group_Contents($item);
                    $RightCol = RightCol($uid, 'userwall');
                    $viewname = 'pages.contents';
                    $current_tab = 'contents';
                    break;
                }
                case 'edit':
                {

                    $SP = new \App\HamafzaServiceClasses\GroupsClass;
                    $json_a = $SP->about('', $uid, $item);
                    $GroupJSon = $json_a;
                    $Preview = $GroupJSon['preview'];
                    $admin = $Preview['adminid'];
                    $Title = 'ویرایش ' . $Preview['PreTitle'] . ' ' . $Preview['name'];
                    $isorgan = $Preview['isorgan'];
                    $gname = $Preview['link'];
                    $id = $Preview['id'];
                    $content = $Preview;
                    $PageType = 'group';
                    if ($isorgan == '1')
                    {
                        $type = 'Organ';
                    }
                    else
                    {
                        $type = 'group';
                    }
                    session('Gname', $gname);
                    if ($admin == $uid)
                    {
                        $arr['content'] = $content;
                    }
                    else
                    {
                        $arr['content'] = 'شما اجازه ویرایش ندارید';
                    }
                    $RightCol = RightCol($uid, 'userwall');
                    $res = [
                        'Rel' => '',
                        'PageType' => $PageType,
                        'Type' => $type,
                        'Title' => $Title,
                        'Small' => $id,
                        'gname' => $gname,
                        'pid' => 'intro',
                        'content' => $content,
                        'sid' => $id,
                    ];
                    break;
                }
                case 'desktop':
                {

                    $SN = new \App\HamafzaServiceClasses\GroupsClass();
                    $Preview = $SN->Group_Title($Group);
                    $Title = $Preview['PreTitle'] . ' ' . $Preview['name'];
                    $RightCol = RightCol($uid, 'userabout');
                    $viewname  = 'pages.page_desktop_dashboard';
                    $res = [
                        'Title' => $Title,
                        'desktop_sections' =>
                            [
                                [
                                    'type' => 'tasks',
                                    'title' => 'وظایف',
                                    'order' => '1',
                                    'data' =>
                                        [
                                            [
                                                'active' => '1',
                                                'title' => 'وظایف',
                                                'new' => '-1',
                                                'value' => '0 '. "",
                                                'icon' => 'fa-tasks',
                                                'url' =>'' //route('pgs.desktop.hamahang.tasks.my_tasks.list', ['sid' => $sid])
                                            ],
                                            [
                                                'active' => '1',
                                                'title' => 'یادداشت‌ها',
                                                'new' => '-1',
                                                'value' =>' 0'. "",
                                                'icon' => 'fa-pencil',
                                                'url' =>''// route('page.desktop.announces', ['sid' => $sid])
                                            ],
                                            [
                                                'active' => '1',
                                                'title' => 'اعضا',
                                                'new' => '-1',
                                                'value' => DB::table('user_group_member')->where('gid', $Group->id)->where('relation', '=', 2)->count() . "",
                                                'icon' => 'fa-bookmark-o',
                                                'url' => route('ugc.persons', ['$username' => $gname])
                                            ],
                                        ]
                                ],
                            ],

                        'current_tab' => 'desktop',
                    ];

                    break;
                }
            }
            $tabs = PageTabs('group', $Group->id);
            return array_merge(
                $res,[
                    'Tree' => isset($res['Tree']) ? $res['Tree'] : '',
                    'viewname' => $viewname,
                    'PageType' => $PageType,
                    'sid' => $Group->id,
                    'uname' => $gname,
                    'Files' => '',
                    'Small' => '',
                    'keywords' => '',
                    'SiteTitle' => config('constants.SiteTitle'),
                    'tabs' => $tabs,
                    'tools' => shortToolsGenerator('Group', $Group->id, ['uid' => Auth::id(), 'sessid' => 0, 'sid' => $Group->id], 0),
                    'tools_menu' => toolsGenerator([$option => ['gid'=> $Group->id]], 1, 5,['subject_id' => $Group->id, 'page_id' => '','member'=>$isMember]),
                    'current_tab' => $current_tab,
                    'RightCol' => $RightCol
                ]
            );
            break;
        }
        default:
            abort(404);
    }
}

function enquiry_get_sum_rewards($reward)
{
    return (array_sum(array_column($reward->toArray(), 'score')));
}

function h_human_date($timestamp)
{
    $r = null;
    $t = abs(time() - $timestamp) / 60;
    switch (true)
    {
        case $t > 548 * 24 * 60;
            $r = false;
            break;
        case $t > 12 * 30 * 24 * 60;
            $r = '1 ' . trans('enquiry.year'); //'1 سال';
            break;
        case $t > 9 * 30 * 24 * 60;
            $r = '9 ' . trans('enquiry.month'); //'9 ماه';
            break;
        case $t > 6 * 30 * 24 * 60;
            $r = '6 ' . trans('enquiry.month'); //'6 ماه';
            break;
        case $t > 3 * 30 * 24 * 60;
            $r = '3 ' . trans('enquiry.month'); //'3 ماه';
            break;
        case $t > 31 * 24 * 60;
            $r = '1 ' . trans('enquiry.month'); //'1 ماه';
            break;
        case $t > 7 * 24 * 60;
            $r = '1 ' . trans('enquiry.week'); //'1 هفته';
            break;
        case $t > 24 * 60;
            $r = '1 ' . trans('enquiry.day'); //'1 روز';
            break;
        case $t > 12 * 60;
            $r = '12 ' . trans('enquiry.hour'); //'12 ساعت';
            break;
        case $t > 60;
            $r = '12 ' . trans('enquiry.hour'); //'ساعت';
            break;
        case $t > 30;
            $r = trans('enquiry.halfhour'); //'نیم ساعت';
            break;
        case $t > 15;
            $r = trans('enquiry.aquarter'); //'یک ربع';
            break;
        case $t > 1;
            $r = trans('enquiry.daghayeghi'); //'دقایقی';
            break;
        case $t > 0;
            $r = trans('enquiry.lahazati'); //'لحظاتی';
            break;
    }
    //$debug = config('app.debug') ? '(' . HDate_GtoJ(date('Y-m-d H:i:s', $timestamp), "H:i - Y/m/d") . ')' : null;
    return ($r);
}

function get_user_sumscores()
{
    return auth()->user()->TotalScores;
}

/**
 * usage:
 *  score_register('App\Models\hamafza\Post', $target_id, config('score.?'))
 *
 */
function score_register($target_table = 'App\Models\hamafza\Post', $target_id = 0, $score_id = 0, $uid = -1)
{
    Score::register($target_table, $target_id, $score_id, $uid);
}

/**
 * Alias of score_register
 *
 * usage:
 *  score_unregister('App\Models\hamafza\Post', $target_id, config('score.?'))
 *
 */
function score_unregister($target_table = 'App\Models\hamafza\Post', $target_id = 0, $score_id = 0, $uid = -1)
{
    //score_register($target_table, $target_id, $score_id);
    Score::register($target_table, $target_id, $score_id, $uid);
}

function score_real_unregister($target_table = 'App\Models\hamafza\Post', $target_id = 0, $uid = -1)
{
    Score::real_unregister($target_table, $target_id, $uid);
}

function between($subject, $min, $max)
{
    return min($max, max($min, $subject));
}

if (!function_exists('SIUFormGenerator'))
{
    function SIUFormGenerator($item_id, $image, $save_route, $rename_route, $remove_route ,$showDefimg=0 , $params = ['save_route' => [], 'rename_route' => [], 'remove_route' => []])
    {
        $result = view('hamahang.helper.SingleImageUploader.upload_content', compact('item_id', 'image', 'save_route', 'rename_route', 'remove_route', 'showDefimg', 'params'));
        return $result;
    }
}

if (!function_exists('SIUSaveImage'))
{
    function SIUSaveImage($request, $valid_ext, $model, $field = 'image_id', $custom_path = '')
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:' . $valid_ext . '|max:1024',
        ]);
        if ($validator->fails())
        {
            $res = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $upload = HFM_Upload($request->file('image'), $custom_path);
        $model->$field = $upload['ID'];
        $model->save();
        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
            'img_id' => enCode($upload['ID']),
            'image_name' => \App\Models\Hamahang\FileManager\FileManager::orderBy('id', 'desc')->first()->originalName
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }
}

if (!function_exists('SIURenameImage'))
{
    function SIURenameImage($request)
    {
        $validator = Validator::make($request->all(), [
            'image_name' => 'required|max:200',
            'image_file_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $res = [
                'success' => false,
                'result' => $validator->errors()
            ];
            return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
        }
        $file = \App\Models\Hamahang\FileManager\FileManager::find(deCode($request->input('image_file_id')));
        $file->originalName = $request->input('image_name');
        $file->save();
        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }
}

if (!function_exists('SIURemoveImage'))
{
    function SIURemoveImage($model, $field = 'image_id')
    {
        $model->$field = null;
        $model->save();

        $res = [
            'success' => true,
            'result' => ['message' => trans('app.operation_is_success')],
        ];
        return response()->json($res, 200)->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8']);
    }
}

if (!function_exists('check_captcha'))
{
    function check_captcha($section, $value)
    {
        $session_name = 'captcha_' . $section;
        if (session()->has($session_name))
        {
            if (session($session_name) == $value)
            {
                session()->forget($session_name);
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('user_notifications_count'))
{
    function user_notifications_count($mod = 'desktop', $user_id = 0)
    {
        if ($user_id > 0)
        {
            $user = User::find($user_id);
        }
        else
        {
            if (auth()->check())
            {
                $user = auth()->user();
            }
            else
            {
                return false;
            }
        }

        if ($mod == 'wall')
        {
            return '..';
        }
        elseif ($mod == 'bazaar')
        {
            return '..';
        }
        else
        {
            return '..';
        }

        return false;
    }
}

if (!function_exists('index_view_style'))
{
    function index_view_style($index)
    {
        $index_style = '';
        if ($index == 'hamafza')
        {
            $index_style = '';
        }
        elseif ($index == 'banader')
        {
            $index_style = '<link rel="stylesheet" type="text/css" href="' . url('layouts/banader/css/banader_style.css') . '"/>';
        }
        return $index_style;
    }
}

if (!function_exists('PermittedOfficialSubjectTypes'))
{
    function PermittedOfficialSubjectTypes()
    {
        return \App\Models\hamafza\SubjectType::PermittedOfficialSubjectTypes();
    }
}

if (!function_exists('PermittedPersonalSubjectTypes'))
{
    function PermittedPersonalSubjectTypes()
    {
        return \App\Models\hamafza\SubjectType::PermittedPersonalSubjectTypes();
    }
}

function explode_ex($delimiter, $string, $limit = null)
{
    $explode = $limit ? explode($delimiter, $string, $limit) : explode($delimiter, $string);
    if (1 == count($explode))
    {
        if (isset($explode[0]))
        {
            $r = trim($explode[0]) ? $explode : [];
        }
        else
        {
            $r = $explode;
        }
    }
    else
    {
        $r = $explode;
    }
    return $r;
}

function value_selector($selector, array $values)
{
    return isset($values[$selector]) ? $values[$selector] : false;
}

