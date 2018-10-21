<?php

namespace App\Http\Controllers\View;

use App\HamafzaViewClasses\KeywordClass;
use App\Models\hamafza\Keyword;
use App\Models\hamafza\Subject;
use App\Models\hamafza\SubjectType;
use App\Models\Hamahang\Basicdata;
use App\Models\Hamahang\BasicdataValue;
use App\Models\Hamahang\ProvinceCity\City;
use App\Models\Hamahang\ProvinceCity\Province;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses;
use App\HamafzaServiceClasses\UserClass;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        auth()->check();
        if (Auth::viaRemember()){
            $user = auth()->user();
            session(['uid' => $user->id]);
            session(['Uname' => $user->Uname]);
            session(['Summary' => $user->Summary]);
            session(['Name' => $user->Name]);
            session(['Family' => $user->Family]);
            session(['pic' => $user->Pic]);
            session(['Login' => 'TRUE']);
            session(['email' => $user->Email]);
            $UC = new UserClass();
            $OG = $UC->MyOrganGroups($user->id, 0);
            $OG = json_decode($OG);
            session(['MyOrganGroups' => $OG]);
            $dt = new \DateTime();
            $user->last_login = $dt->format('Y-m-d H:i:s');
            $user->device_type = '';
            $user->last_session_id = '';
            $user->save();
        }

        $news = '';
        $magh = '';
        $proj = '';
        $paya = '';
        $tarh = '';
        $ketab = '';
        $slides = '';
        $PC = new HamafzaViewClasses\PublicClass();
        $menu = $PC->GetSiteMenu();
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $uid = (session('uid') != '') ? session('uid') : 0;
        $mainSlide = DB::table('homepage_slide')->where('type', '1')->get();
        $otherSlide = DB::table('homepage_slide')->where('type', '2')->get();
        $dashboard = '';
        if ($uid != 0)
        {
            $SP = new UserClass();
            $dashboard = $SP->HomeDashboard($uid, 0, 'local');
        }
        $Portals = '';
        //$keywordTab = KeywordClass::GetPublicKeyword();
        $provinces = Province::all();
        $cities = City::all();
        $news = '';
        $index = (config('constants.IndexView') != '') ? config('constants.IndexView') : 'index';

        $articles_count = ($articles_count_temp = SubjectType::find(50)) ? $articles_count_temp = $articles_count_temp->subjects->count() : 0;
        $books_count = ($books_count_temp = SubjectType::find(42)) ? $books_count_temp = $books_count_temp->subjects->count() : 0;
        $thesis_count = ($thesis_count_temp = SubjectType::find(45)) ? $thesis_count_temp = $thesis_count_temp->subjects->count() : 0;
        $research_count = ($research_count_temp = SubjectType::find(91)) ? $research_count_temp = $research_count_temp->subjects->count() : 0;
        $invent_count = ($invent_count_temp = SubjectType::find(76)) ? $invent_count_temp = $invent_count_temp->subjects->count() : 0;
        $published = SubjectType::where('id', 42)->withCount(['subjects' => function ($s)
        {
            $s->whereHas('fieldsValue', function ($query)
            {
                $query->where('field_value', 'انتشارات سازمان بنادر و دریانوردی');
            });
        }])->first();

        if ($published && $published->subjects_count)
        {
            $published = $published->subjects_count;
        }
        else
        {
            $published = 0;
        }

        $mag = ($mag_temp = SubjectType::find(54)) ? $mag_temp = $mag_temp->subjects->count() : 0;


        $chart_feed = [$articles_count, $books_count, $thesis_count, $published, $research_count, $mag, $invent_count];
        $index_view = '';
        $data = [];

        switch ($index)
        {
            case 'hamafza':
            {
                if (config('constants.DefIndexView') == 'hamafza_1')
                {
                    $index_view = 'layouts.homepages.hamafza_1';
                }
                elseif (config('constants.DefIndexView') == 'hamafza_2')
                {
                    $index_view = 'layouts.homepages.hamafza_2';
                    $news = DB::table('pages as p')
                        ->join('subjects as s', 's.id', '=', 'p.sid')
                        ->where('kind', '64')
                        ->select('s.title', 'p.defimage', 'p.id')
                        ->distinct()
                        ->take(5)
                        ->get();
                }
                break;
            }
            case 'general':
            {
                if (config('constants.DefIndexView') == 'general')
                {
                    $index_view = 'layouts.homepages.general';
                }
                break;
            }
            case 'behzisti':
            {
                if (config('constants.DefIndexView') == 'behzisti')
                {
                    $index_view = 'layouts.homepages.behzisti';
                }
                break;
            }
            case 'banader':
            {
                $index_view = 'layouts.homepages.banader';
                $paya = SubjectType::find(45)->subjects()->take(4)->get();
                /*DB::table('pages as p')
                    ->join('subjects as s', 's.id', '=', 'p.sid')
                    ->where('kind', '45')
                    ->select('s.title', 'p.defimage', 'p.id', 'p.description')
                    ->orderby('id', 'desc')
                    ->distinct()
                    ->take(4)
                    ->get();*/
                $tarh = SubjectType::find(91)->subjects()->take(4)->get();
//                $news = DB::table('pages as p')
//                    ->join('subjects as s', 's.id', '=', 'p.sid')
//                    ->where('kind', '65')
//                    ->select('s.title', 'p.defimage', 'p.id', 'p.description', 's.kind')
//                    ->orderby('id', 'desc')
//                    ->take(5)
//                    ->get();
//                dd($news);
                $news_tabs = BasicdataValue::where('parent_id', 8)->get();
//                dd($news_tabs);
                $proj = DB::table('pages as p')
                    ->join('subjects as s', 's.id', '=', 'p.sid')
                    ->where('kind', '5')
                    ->select('s.title', 'p.defimage', 'p.id', 'p.description')
                    ->orderby('id', 'desc')
                    ->distinct()
                    ->take(5)
                    ->get();
                $Groups = DB::table('user_group as g')
                    ->where('type', '1')
                    ->select('name', 'link', 'pic')
                    ->orderby('id')
                    ->distinct()
                    ->take(9)
                    ->get();
                $Orgs = DB::table('user_group as g')
                    ->where('type', '2')
                    ->select('name', 'link', 'pic')
                    ->orderby('id')
                    ->distinct()
                    ->take(9)
                    ->get();
                $Coms = DB::table('user_group as g')
                    ->where('type', '3')
                    ->select('name', 'link', 'pic')
                    ->orderby('id')
                    ->distinct()
                    ->take(9)
                    ->get();
                $Channels = DB::table('user_group as g')
                    ->where('isorgan', '1')
                    ->select('name', 'link', 'pic')
                    ->orderby('id')
                    ->distinct()
                    ->take(9)
                    ->get();
                $List_Tabs = BasicdataValue::where('parent_id', config('basicdata.social_attr_link'))->get();
                foreach ($List_Tabs as $list_tab)
                {
                    $list_tab->items = BasicdataValue::where('value', $list_tab->id)->where('parent_id', config('basicdata.social_attr_image'))->with(['attrs' => function ($q)
                    {
                        $q->withPivot(['value']);
                    }])->take(9)->get();

                }
                $research = BasicdataValue::where('parent_id', config('basicdata.research_attr_link'))->get();

                foreach ($research as $list_tab_research)
                {
                    $list_tab_research->items = BasicdataValue::where('value', $list_tab_research->id)
                        ->where('parent_id', config('basicdata.research_attr_image'))
                        ->with(
                            [
                                'attrs' => function ($q)
                                {
                                    $q->withPivot(['value']);
                                }
                            ]
                        )->take(9)->get();
                }

                /*$Users = DB::table('user as u')
                    ->join('users as us', 'u.user_id', '=', 'us.id')
                    ->where('us.state', '1')
                    ->select('u.id', 'u.uname', 'u.Name', 'u.Family', 'u.Pic', 'u.Summary')
                    ->orderBy('id', 'desc')
                    ->take(9)
                    ->get();*/
                $Users = \App\User::orderBy('id', 'asc')->take(9)->get();

//                $user_by_cookie = User::where('remember_token', $_COOKIE['remember_token'])->first();
//                dd($user_by_cookie);
//                dd($_COOKIE['remember_token']);
//                if (isset($_COOKIE['remember_token']))
//                {
//                    Auth::loginUsingId($user_by_cookie->id);
//                }

                return view($index_view, array(
                    'SiteLogo' => $SiteLogo,
                    'PageType' => 'home',
                    'provinces' => $provinces,
                    'cities' => $cities,
                    'news_tabs' => $news_tabs,
                    'paya' => $paya,
                    'tarh' => $tarh,
                    'slides' => $slides,
                    'magh' => $magh,
                    'proj' => $proj,
                    'ketab' => $ketab,
                    'menu' => $menu,
                    'SiteTitle' => $SiteTitle,
                    'Title' => 'صفحه اول',
                    'sid' => '1',
                    'pid' => '1',
                    'uid' => $uid,
                    'content' => '1',
                    'mainSlide' => $mainSlide,
                    'otherSlide' => $otherSlide,
                    'Portals' => $Portals,
                    'Users' => $Users,
                    'Orgs' => $Orgs,
                    'Coms' => $Coms,
                    'List_Tabs' => $List_Tabs,
                    'Groups' => $Groups,
                    'Channels' => $Channels,
                    'dashboard' => $dashboard,
                    'Uname' => session('Uname'),
                    //'keywordTab' => $keywordTab,
                    'chart_feed' => $chart_feed,
                    'List_tabs_research' => $research,
                    'client_ip' => $request->ip()
                ));
                break;
            }
            case 'itrac':
                $index_view = 'layouts.homepages.itrac';
                break;
            case 'shazand':
                $index_view = 'layouts.homepages.shazand';
                break;
            case 'kmkz':
                $index_view = 'layouts.homepages.kmkz';
                $data_links = Basicdata::find(config('basicdata.kmkz.homepage_link_group_id', 9))->items()->where('inactive', 0)->get();
                if ($data_links)
                {
                    foreach ($data_links as $data_link)
                    {
                        $data_links_ready[] = "<a href='{$data_link->value}' target='_blank'>{$data_link->title}</a>";
                    }
                    $data_links_ready = implode(' | ', $data_links_ready);
                } else
                {
                    $data_links_ready = trans('app.no_result');
                }
                $data =
                [
                    //'links' => $data_links,
                    'links_ready' => $data_links_ready,
                ];
                break;

        }
        $with =
        [
            'SiteLogo' => $SiteLogo,
            'PageType' => 'home',
            'news' => $news,
            'menu' => $menu,
            'SiteTitle' => $SiteTitle,
            'meta_description' => '«در هم‌افزا، علم و عمل نظم بهتری می‌یابند، «فهم» کامل‌تر و دقیق‌تری پدید می‌آید و مدیریت زمان بهبود می‌یابد. با هم‌افزا مدت و کیفیت زندگی را افزایش می‌یابد!»',
            'Title' => 'صفحه اول',
            'sid' => '1',
            'pid' => '1',
            'uid' => $uid,
            'content' => '1',
            'mainSlide' => $mainSlide,
            'otherSlide' => $otherSlide,
            'Portals' => $Portals,
            'dashboard' => $dashboard,
            'Uname' => session('Uname'),
            //'keywordTab' => $keywordTab,
            'client_ip' => $request->ip(),
            'data' => $data,
            'provinces' => $provinces,
            'cities' => $cities
        ];
        \Session::put('provinces',$provinces);
        \Session::put('cities',$cities);
        $r = view($index_view, $with);
        return $r;
    }

}
