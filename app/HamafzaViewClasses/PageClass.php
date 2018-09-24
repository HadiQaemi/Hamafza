<?php

namespace App\HamafzaViewClasses;

use App\Models\hamafza\Pages;
use App\Models\hamafza\Relations;
use App\Models\hamafza\Subject;
use App\Models\Hamahang\SubjectsProductInfo;
use App\User;
use Illuminate\Support\Facades\DB;
use App\HamafzaServiceClasses\PagesClass;
use App\HamafzaServiceClasses\PublicsClass;
use App\HamafzaGrids\SubjectGrids;
use Auth;

class PageClass
{

    public function CreatPageForumView($params)
    {
        $uid = Auth::id();
        $sesid = 0;
        $sid = $params['id'];
        $pc = new \App\HamafzaServiceClasses\PostsClass();
        $content2 = json_encode($pc->SubjectWall($sid, $uid, $sesid, ''));
        $content2 = json_decode($content2);
        if ($uid != 0)
        {
            $PageType = 'subject';
            return [
                'viewname' => 'pages.contents',
                'Uname' => $sid,
                'PageTypes' => 'PageWall',
                'PageType' => $PageType,
                'sid' => $sid,
                'Small' => $uid,
                'pid' => $sid . '/forum',
                'content' => $content2,
                'Tree' => ''
            ];
        }
        else
        {
            //$PC = new PublicClass();
            //$menu = $PC->GetSiteMenu();
            //$PgC = new PageClass();
            //$page = $PgC->SubjectTabs($sid);
            //$Title = $page['Title'];
            //$tools = $PgC->Tools($sid, 0, $uid, $sesid, 'publicpage', 'subjectwall');
            //$shortTools = $tools['abzar'];
            //$SiteTitle = config('constants.SiteTitle');
            //$SiteLogo = config('constants.SiteLogo');
            //$tabs = $page['tabs'];
            //$keywords = '';
            //$Files = '';
            //$Portals = $PgC->GetProtals($uid, $sesid);
            //$keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
            $PageType = 'subject';
            $Tree = '';
            $alert = 'برای دسترسی به این قسمت نیاز به عضویت دارید';
            $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'forumWL')->select('a.comment')->first();
            if ($alerts)
            {
                $alert = $alerts->comment;
            }
            $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);

            return [
                'viewname' => 'pages.publicwmr',
                'PageType' => $PageType,
                //'SiteLogo' => $SiteLogo,
                //'MyOrganGroups' => '',
                //'SiteTitle' => $SiteTitle,
                //'Title' => $Title,
                'Small' => $sid,
                'sid' => $sid,
                'pid' => 'forum/' . $sid,
                //'menu' => $menu,
                'content' => $alert,
                //'keywords' => $keywords,
                //'tabs' => $tabs,
                //'Tree' => $newtree,
                //'Portals' => $Portals,
                //'Files' => $Files,
                //'tools' => $shortTools,
                //'menutools' => $MenuTools,
                //'keywordTab' => $keywordTab
            ];
        }
    }

    public function CreatPageView($id, $Type, $PreCode)
    {
        $pc = new \App\HamafzaServiceClasses\PageClass();
        $Descr = '';
        $thesarus = false;
        session('list', '');
        $uid = Auth::id();
        $sesid = '0';
        $ContentType = $Type;
        $viewname = 'pages.public';
        $menu = '';
        $pid = $id;
        $object_page = Pages::find($pid);
        $subject = DB::table('subjects')
            ->join('pages', 'pages.sid', '=', 'subjects.id')
            ->where('pages.id', $pid)
            ->select('subjects.*')
            ->first();
        if ($subject)
        {
            $sid = $subject->id;
            $UC = new PagesClass();
            $ISView = 1;//$UC->pageView('view', $sid, $pid, $uid);
            $page = DB::table('pages as p')
                ->join('subjects as s', 's.id', '=', 'p.sid')
                ->leftJoin('subject_type as sa', 's.kind', '=', 'sa.id')
                ->leftJoin('subject_type_tab as st', function ($join)
                {
                    $join->on('s.kind', '=', 'st.stid');
                    $join->on('p.type', '=', 'st.tid');
                })
                ->where('p.id', $pid)
                ->select('s.ispublic', 'st.type as tabtype', 'sa.pretitle', 'p.viewslide', 'p.viewfilm', 'p.viewtext', 'p.defimage', 'p.showDefimg', 'p.id', 'p.sid', 'p.body', 'p.description', 'p.form', 'p.view', 'p.edit', 'p.ver_date', 's.title as Title', 's.kind', 's.archive', 'p.type as type')
                ->first();
            $tabtypes = $page->tabtype;
            $subjectTypeTab = DB::table('subject_type_tab')
                ->where('stid', $page->kind)
                ->where('tid', $page->type)
                ->first();
            $pAGETabname = $subjectTypeTab->name;
            $first = 1;
            $pAGEtYPE = $subjectTypeTab->type;
            $thesarus = false;
            $tabtype = ($tabtypes == '20') ? true : false;
            if ($pAGEtYPE == '7')
            {
                if ($ContentType == 'OnlyTree')
                {
                    $pc = new \App\HamafzaServiceClasses\PageClass();
                    $Trees = $pc->tree_bodyOnlyTree($pid);
                    $Tree = $Trees['list'];
                    $Body = $Trees['body'];
                }
                else
                {
                    $pc = new \App\HamafzaServiceClasses\PageClass();
                    $Trees = $pc->tree_bodyOnlyList($pid);
                    $Tree = $Trees['list'];
                    $Body = $Trees['body'];
                }
            }
            else
            {
                $Body = $page->body;
                $Tree = $pc->bodyList($Body);
            }


            $pattern = "/<span class=\"ThesaurusCLS.*/";
            $array = array();
            if ($num1 = preg_match_all($pattern, $Body, $array))
            {
                $tabtype = true;
            }
            $IsPublic = $page->ispublic;
            $data['Alert'] = '';
            $data['IsPublic'] = $IsPublic;
            if ($IsPublic == '0')
            {
                $alert = DB::table('function_alert as f')
                    ->join('alerts as a', 'a.id', '=', 'f.alertid')
                    ->where('functionname', 'Ispublic')->select('a.comment')->first();
                $data['Alert'] = ($alert)?$alert->comment:"";
            }
            $Description = $page->description;
            $PreTitle = $page->pretitle;
            $Title = $PreTitle . ' ' . $page->Title;
            $sid = $page->sid;
            DB::table('subjects')->where('id', $sid)->increment('visit', 1);
            $defimage = $page->defimage;
            $showDefimg = $page->showDefimg;
            $viewtext = $page->viewtext;
            $viewslide = $page->viewslide;
            $viewfilm = $page->viewfilm;
            $kind = $page->kind;
            $archive = $page->archive;
            if ($first == '1')
            {
                $pFields = \App\HamafzaServiceClasses\PageClass::page_field($pid, $sid, $kind);
            }
            else
            {
                $pFields = '';
            }

            $tabs = $pc->page_tabs($sid, $kind, $pid);
            //$Proccess = $pc->Proccess($pid, $uid, $sesid, $sid);
            $keys = $pc->PageKeywords($sid);
            //$user = false;
            $data['id'] = $pid;
            $data['sid'] = $sid;
            if ($ISView == 1)
            {
                //add by hadi
                //orginal $page = $pc->modifyText($Body, $uid, $pid, $sid, $tabtype);
                if($subject->kind == 3 && strlen($Body) > 500000)
                    $page = $Body;
                else
                    $page = $pc->modifyText($Body, $uid, $pid, $sid, $tabtype);
                //
                $files = $pc->page_files($pid);
                $slides = $pc->page_slides($pid);
                $films = $pc->page_films($pid);
                $page = $pc->bodyPara($page);
                $data['content'] = $page;
                $data['Tree'] = $Tree;
                $SR = new \App\HamafzaServiceClasses\SubjectRelation();
                $Rel = $SR->Rel($pid, $sid, $Title);
                $data['Rel'] = $Rel;
                $data['Keywords'] = $keys;
                $data['Title'] = $Title;
                $data['Tabname'] = $pAGETabname;
                $data['tabs'] = $tabs;
            }
            elseif ($ISView == 0)
            {
                $data['Tabname'] = '';
                $data['Title'] = 'عدم دسترسی به صفحه';
                $alert = DB::table('function_alert as f')
                    ->join('alerts as a', 'a.id', '=', 'f.alertid')
                    ->where('functionname', 'pageaccess')->select('a.comment')->first();
                if ($alert)
                {
                    $data['content'] = $alert->comment;
                }
                else
                {
                    $data['content'] = 'شما اجازه مشاهده این صفحه را ندارید';
                }
                $data['Tree'] = '';
                $data['Rel'] = array();
                $files = array();
                $slides = array();
                $films = array();
                $data['Keywords'] = array();
                $data['tabs'] = array();
            }
            $data['Description'] = $Description;
            $data['archive'] = $archive;
            $data['defimage'] = $defimage;
            $data['showDefimg'] = $showDefimg;
            $data['Type'] = $pAGEtYPE;
            //$data['Proccess'] = $Proccess;
            $data['viewtext'] = $viewtext;
            $data['viewslide'] = $viewslide;
            $data['viewfilm'] = $viewfilm;
            $data['Files'] = $files;
            $data['Slides'] = $slides;
            $data['Films'] = $films;
            $data['Fields'] = $pFields;
            $data['Thesarus'] = $thesarus;

            $page = $data;
            if (is_array($data))
            {
                $Sid = $page['sid'];
                $sid = $page['sid'];
                $archive = $page['archive'];
                session(['SubjectArchive' => $archive]);
                $Alert = $page['Alert'];
                $Title = $page['Title'];
                $content = '' .
                    '<div id="report-loading" class="loading">' .
                    '   <img src="/Content/images/ajax-loader.gif" width="32" height="32" /><br />' .
                    '   <strong>Loading</strong>' .
                    '</div>
                        <style>
                            #new-fehrest .panel-heading {
                                border-bottom: 1px solid #7dca75 !important;
                                border-top: none !important;
                                background: #FFF !important;
                            }
                        </style>' .
                    '<div id="TextSection" style="display: inline-block;">' .
                    '<div class="col-xs-12">'.
                        '<div id="buttoninfullscreen" class="buttoninfullscreen deactive hidden" style="margin-right: -2.4%">
                            <div class="right-new">
                                <i class="fa fa-angle-double-left" aria-hidden="true" onclick="openNav00()"></i>
                                <i class="fa fa-angle-double-right deactive hidden" aria-hidden="true" onclick="closeNav00()"></i>
                                <div id="new-fehrest" class="hidden">
                                    <div id="mySidenav00" class="sidenav0 hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                        '.
                        '<div class="col-xs-12" id="new-content" style="direction: rtl">
                            <a href="#BtnScrollBottom" class="btn-scroll fa fa-arrow-down" id="BtnScrollTop"></a>
                            <div class="mixed-scroll hidden">
                                <a href="#BtnScrollTop" class="btn-scroll fa fa-chevron-up"></a>
                                <a href="#BtnScrollBottom" class="btn-scroll fa fa-chevron-down"></a>
                            </div>
                                '.$page['content'] . '
                            <a href="#BtnScrollTop" class="btn-scroll btn-scroll fa fa-arrow-up" id="BtnScrollBottom"></a>
                        </div>'.
                    '</div>
                            
                    <script>
                        if($("#new-content").height()<1000){
                            $(".btn-scroll").css("display","none");
                        }
                         $(".btn-scroll").on("click", function(event) {
                            
                            var target = $(this.getAttribute("href"));
                        
                            if( target.length ) {
//                                event.preventDefault();
                                $("html, body").stop().animate({
                                    scrollTop: target.offset().top
                                }, 1000);
                            }
                        
                        });
                        function openNav00() {
                            $(".fa-angle-double-left").addClass("hidden");
                            $(".fa-angle-double-left").addClass("deactive");
                            $(".fa-angle-double-right").removeClass("hidden");
                            $(".fa-angle-double-right").removeClass("deactive");
                            $("#new-fehrest").removeClass("hidden");
                            $("#new-fehrest").css("margin-top","-100px");
                            $("#new-fehrest li").css("margin-right","8px !important");
                            $("#new-fehrest .jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none !important");
                            $(".jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none !important");
                            $("#mySidenav00").removeClass("hidden");
                            $("#buttoninfullscreen").addClass("col-xs-3");
//                            $("#new-fehrest").addClass("col-xs-3");
                            $(".buttoninfullscreen").css("width","25%");
                            $(".buttoninfullscreen").css("right","0px");
                            $(".buttoninfullscreen").css("top","-15px");
                            $(".buttoninfullscreen").css("height","100v");
                            $(".buttoninfullscreen").css("position","relative");
                            $("#new-content").addClass("col-xs-9");
                            $("#new-content").removeClass("col-xs-12");
                            
                        }
                        function closeNav00() {
                            $("#new-fehrest li").css("margin-right","8px !important");
                            $("#new-fehrest .jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none");
                            $(".jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none !important");
                            $(".fa-angle-double-right").addClass("hidden");
                            $(".fa-angle-double-right").addClass("deactive");
                            $(".fa-angle-double-left").removeClass("hidden");
                            $(".fa-angle-double-left").removeClass("deactive");
                            $("#new-fehrest").css("margin-top","-100px");
                            $("#new-fehrest").addClass("hidden");
//                            $("#new-fehrest").removeClass("col-xs-3");
                            $(".buttoninfullscreen").css("width","1.5%");
                            $(".buttoninfullscreen").css("position","fixed");
                            $(".buttoninfullscreen").css("right","15px");
                            $(".buttoninfullscreen").css("height","100%");
                            $(".buttoninfullscreen").css("top","2px");
                            $("#buttoninfullscreen").removeClass("col-xs-3");
                            $("#new-content").removeClass("col-xs-9");
                            $("#new-content").addClass("col-xs-12");
                            
                        }
                    </script>';
                ?>
                <?php
                $tabs = $page['tabs'];
                //dd($tabs);
                $keywords = $page['Keywords'];
                $Descr = $page['Description'];
                $Files = $page['Files'];
                $Fields = $page['Fields'];
                $Type = $page['Type'];
                $Rel = $page['Rel'];
                $thesarus = $page['Thesarus'];
                $view['film'] = $page['viewfilm'];
                $view['slide'] = $page['viewslide'];
                $view['text'] = $page['viewtext'];
                if ($page['viewslide'] == '1')
                {
                    $content .= $this->IntroSlide($page['Slides']);
                }
                if ($page['viewfilm'] == '1')
                {
                    $content .= $this->IntroFilms($page['Films']);
                }
                $viewname = ($thesarus == true || $Type == '20') ? 'pages.thesarus' : 'pages.public';
                $Fields = PageClass::PageFields($Fields, $page['showDefimg'], $page['defimage']);
                $Tree = $page['Tree'];
                if (count($Tree) > 1)
                {
                    $PC = new PublicClass();
                    $newtree = $PC->CretaeTree3L($Tree, 'id', 'parent_id', 'url', 'x');
                    $newtree = $PC->Json(0, $newtree);
                }
                else
                {
                    $newtree = '';
                }
                $uid = '0';
                $Alert = '';
            }
            else
            {
                $content = $page;
                $pid = 0;
                $Sid = 0;
                $newtree = '';
                $view['film'] = '';
                $view['slide'] = '';
                $view['text'] = '';
                $Rel = '';
                $Title = $page;
                $keywords = '';
                $tabs = '';
                $Files = '';
                $Alert = '';
            }
            $allowedittag = false;
            $allowdeltag = false;
            $PageType = 'subject';
            if ($thesarus == true || $Type == '20')
            {
                $allowedittag = ($uid != 0 && UsersClass::permission('edittag', $uid) == '1') ? true : false;
                $allowdeltag = ($uid != 0 && UsersClass::permission('deltag', $uid) == '1') ? true : false;
            }
            $subject = Subject::find($sid);
            $fields = $subject->listfields()->withPivot(['field_value'])->get()->toArray();
            if ($fields)
            {
                foreach ($fields as $field_k => $field)
                {
                    if (empty(trim($field['pivot']['field_value'])))
                    {
                        unset($fields[$field_k]);
                    }
                }
                if ($count = count($fields))
                {
                    $fields = array_chunk($fields, ($count % 2 ? $count + 1 : $count) / 2);
                }
                else
                {
                    $fields = [];
                }
            }
            else
            {
                $fields = [];
            }
            if ($subject->product_info || $fields || $subject->DefImageExist /*|| $object_page->description*/)
            {
                $spi = $subject->product_info;
                $view = view('hamahang.Bazaar.helper.bazaar-display',
                [
                    'fields' => $fields,
                    'spi' => $spi,
                    'image' => $subject->def_image_url,
                    'image_exist' => $subject->DefImageExist,
                    //'PageDescription' => $object_page->description
                ]
                )->render();
                $content = $view . $content;
            }
        }
        else
        {
            $content = 'این صفحه موجود نیست';
        }
        if (false) { view('pages.public'); }
        return
            [
                'viewname' => $viewname,
                'Alert' => $Alert,
                'view' => $view,
                'Descr' => $Descr,
                'Rel' => $Rel,
                'PageType' => $PageType,
                'Title' => $Title,
                'sid' => $Sid,
                'ContentType' => $ContentType,
                'current_tab' => $pid,
                'pid' => $pid,
                'menu' => $menu,
                'content' => $content . $object_page->description,
                'allowedittag' => $allowedittag,
                'allowdeltag' => $allowdeltag,
                //'keywords' => $keywords,
                'tabs' => $tabs, //PageTabs('subject', $sid),
                'Tree' => $newtree,
                'Files' => $Files
            ];
    }

    public function highlights($id)
    {
        $uid = Auth::check() ? Auth::id() : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        if (isset($_GET['tt']) && $_GET['tt'] != '')
        {
            $type = $_GET['tt'];
        }
        else
        {
            $type = 'ME';
        }
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $sid = $id;
        $PgC = new PageClass();
        $page = $PgC->SubjectTabs($sid);
        $RightCol = $PgC->GetRightCol($uid, $sesid, $sid, 'subjects');
        $Title = $page->Title;
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $tabs = $page->tabs;
        $keywords = '';
        $Files = '';
        $Portals = $PgC->GetProtals($uid, $sesid);
        $tools = $PgC->Tools($sid, 0, $uid, $sesid, 'publicpage', 'subjectdesktop');
        $shortTools = $tools['abzar'];
        $Tree = $PgC->DesktopTree($id, 'highlights', 'YE');
        $SP = new \App\HamafzaServiceClasses\DesktopsClass();
        $desk = $SP->Gethighlights($uid, 0, $sid);
        $desk = json_encode($desk);
        $desk = json_decode($desk);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $tabs = json_encode($tabs);
        $tabs = json_decode($tabs);
        /* !!$MenuTools = json_encode($MenuTools);
          $MenuTools = json_decode($MenuTools);!! */
        $PageType = 'subject';
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        return view('pages.desktopcontents', array('RightCol' => $RightCol, 'PageType' => $PageType, 'SiteLogo' => $SiteLogo, 'MyOrganGroups' => $MyOrganGroups,
            'SiteTitle' => $SiteTitle, 'Title' => $Title, 'sid' => $sid,
            'pid' => 'desktop/' . $sid . '/highlights', 'menu' => $menu, 'content' => $desk,
            'keywords' => $keywords, 'tabs' => $tabs, 'Tree' => $Tree, 'Portals' => $Portals,
            'Files' => $Files, 'tools' => $shortTools, 'tools_menu' => $MenuTools, 'keywordTab' => $keywordTab
        ));
    }

    public function announces($id)
    {
        $uid = Auth::check() ? Auth::id() : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        if (isset($_GET['tt']) && $_GET['tt'] != '')
        {
            $type = $_GET['tt'];
        }
        else
        {
            $type = 'ME';
        }
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $sid = $id;
        $PgC = new PageClass();
        $page = $PgC->SubjectTabs($sid);
        $RightCol = $PgC->GetRightCol($uid, $sesid, $sid, 'subjects');
        $Title = $page->Title;
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $tabs = $page->tabs;
        $keywords = '';
        $Files = '';
        $Portals = $PgC->GetProtals($uid, $sesid);
        $tools = $PgC->Tools($sid, 0, $uid, $sesid, 'publicpage', 'subjectdesktop');
        $shortTools = $tools['abzar'];
        $Tree = $PgC->DesktopTree($id, 'announces', 'XE');
        $SP = new \App\HamafzaServiceClasses\DesktopsClass();
        $desk = $SP->Getannounces($uid, 0, $sid);
        $desk = json_encode($desk);
        $desk = json_decode($desk);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $tabs = json_encode($tabs);
        $tabs = json_decode($tabs);
        /* !!$MenuTools = json_encode($MenuTools);
          $MenuTools = json_decode($MenuTools);!! */
        $PageType = 'subject';
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        return view('pages.desktopcontents', array('RightCol' => $RightCol, 'PageType' => $PageType, 'SiteLogo' => $SiteLogo, 'MyOrganGroups' => $MyOrganGroups,
            'SiteTitle' => $SiteTitle, 'Title' => $Title, 'sid' => $sid,
            'pid' => 'desktop/' . $sid, 'menu' => $menu, 'content' => $desk,
            'keywords' => $keywords, 'tabs' => $tabs, 'Tree' => $Tree, 'Portals' => $Portals,
            'Files' => $Files, 'tools' => $shortTools, 'tools_menu' => $MenuTools, 'keywordTab' => $keywordTab
        ));
    }

    public function user_measures_page($id, $type = '')
    {
        $uid = Auth::check() ? Auth::id() : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        if (isset($_GET['tt']) && $_GET['tt'] != '')
        {
            $type = $_GET['tt'];
        }
        else
        {
            $type = 'ME';
        }
        $PC = new PublicClass();
        $menu = $PC->GetSiteMenu();
        $sid = $id;
        $PgC = new PageClass();
        $page = $PgC->SubjectTabs($sid);
        $RightCol = $PgC->GetRightCol($uid, $sesid, $sid, 'subjects');
        $Title = $page->Title;
        $SiteTitle = config('constants.SiteTitle');
        $SiteLogo = config('constants.SiteLogo');
        $tabs = $page->tabs;
        $keywords = '';
        $Files = '';
        $Portals = $PgC->GetProtals($uid, $sesid);
        $tools = $PgC->Tools($sid, 0, $uid, $sesid, 'publicpage', 'subjectdesktop');
        $shortTools = $tools['abzar'];
        $Tree = $PgC->DesktopTree($id, 'user_measures_page', $type);
        $SP = new \App\HamafzaServiceClasses\MeasureClass();
        if ($type == 'ZE')
        {
            $type = 'ME';
        }
        $desk = $SP->PageSelect($type, $uid, $sid);
        if (is_array($desk) && count($desk) > 0)
        {
            $dds = new \App\HamafzaGrids\MeasureDataGrid();
            $c = $dds->ME($desk);
        }
        else
        {
            $c = 'موردی یافت نشد';
        }
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $tabs = json_encode($tabs);
        $tabs = json_decode($tabs);
        /* !!$MenuTools = json_encode($MenuTools);
          $MenuTools = json_decode($MenuTools);!! */
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $PageType = 'subject';
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        return view('pages.pagedesktop', array('RightCol' => $RightCol, 'PageType' => $PageType, 'SiteLogo' => $SiteLogo, 'MyOrganGroups' => $MyOrganGroups,
            'SiteTitle' => $SiteTitle, 'Title' => $Title, 'sid' => $sid,
            'pid' => 'desktop/' . $sid, 'menu' => $menu, 'content' => $c,
            'keywords' => $keywords, 'tabs' => $tabs, 'Tree' => $Tree, 'Portals' => $Portals,
            'Files' => $Files, 'tools' => $shortTools, 'tools_menu' => $MenuTools, 'keywordTab' => $keywordTab
        ));
    }

    public function PageDefdesk($sid)
    {
        /* $uid = Auth::check() ? Auth::id() : 0;
          $sesid = 0;
          //$PC = new PublicClass();
          $PgC = new PageClass();
          $page = $PgC->SubjectTabs($sid);
          //$RightCol = RightCol($sid, 'subjects');
          $Title = $page->Title;
          $keywords = '';
          $Files = '';
          //$Portals = $PgC->GetProtals($uid, $sesid);
          $Tree = $PgC->DesktopTree($sid);
          $SP = new \App\HamafzaServiceClasses\PageClass();
          $desk = $SP->PageDashboard($uid, $sesid, 0, $sid);
          $c = DesktopClass::DrawPageDashboard($desk, $sid);
          $PageType = 'subject';
          return
          [
          'viewname' => 'pages.page_desktop_dashboard',
          'Alert' => '',
          'PageType' => $PageType,
          'Title' => $Title,
          'sid' => $sid,
          'pid' => $sid . '/desktop',
          'content' => $c,
          'uname' => $sid,
          'keywords' => $keywords,
          'tabs' => PageTabs('subject', ['id' => $sid]),
          'Files' => $Files, 'Tree' => $Tree
          ]; */
        /* return view('pages.user_desktop_dashboard', array('PageType' => $PageType, 'SiteLogo' => $SiteLogo,
          'SiteTitle' => $SiteTitle, 'Title' => $Title, 'sid' => $sid, 'uname' => $sid,
          'pid' => $sid . '/desktop', 'menu' => $menu, 'content' => $c,
          'tabs' => $tabs, 'Tree' => $Tree, 'Portals' => $Portals,
          'Files' => $Files, 'tools' => $shortTools, 'tools_menu' => $MenuTools, 'keywordTab' => $keywordTab
          )); */
    }

    public static function Sel_Page()
    {
        $first = array();
        $PKeys = DB::table('subject_type_tab')
            ->select('tid', 'stid', 'name', 'first')
            ->get();
        foreach ($PKeys as $PKey)
        {
            if ($PKey->first == 1)
            {
                $first[$PKey->stid] = $PKey->tid;
            }
        }
        foreach ($first as $key => $val)
        {
            $selpage[] = '(kind = ' . $key . ' AND type = ' . $val . ')';
        }
        $sel_pages = '(' . implode($selpage, ' OR ') . ')';
        return $sel_pages;
    }

    public static function pageinsubject($id)
    {
        $SP = new PagesClass();
        $s = $SP->pageinsubject($id);
        $c = SubjectGrids::Pageinsubject($s);
        return view('modals.public', array('content' => $c));
    }

    public static function homepage($name, $uid, $sesid, $Selected, $Tree, $sublink)
    {
        $ret = DesktopClass::USER($name);
        $Portals = PageClass::GetProtals($uid, $sesid);
        $keywordTab = KeywordClass::GetPublicKeyword($sesid, $uid);
        $MyOrganGroups = '';
        if (session('MyOrganGroups'))
        {
            $MyOrganGroups = session('MyOrganGroups');
        }
        $PgC = new PageClass();
        $tools = $PgC->Tools(0, 0, $uid, $sesid, 'Desktop', 'SubjectType');
        $MenuTools = toolsGenerator([6 => ['uid' => $uid, 'sid' => 0]], 1, 5);
        $shortTools = $tools['abzar'];
        if ($uid != 0 && UsersClass::permission('homepage', $uid) == '1')
        {
            $mainSlide = DB::table('homepage_slide')->where('type', '1')->get();
            $otherSlide = DB::table('homepage_slide')->where('type', '2')->get();
            return view('pages.Desktop.homepage', array('PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'mainSlide' => $mainSlide, 'otherSlide' => $otherSlide, 'content' => '', 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'menutools' => $MenuTools));
        }
        else
        {
            return view('pages.Desktop', array('PageType' => 'desktop', 'SiteLogo' => $ret['SiteLogo'], 'MyOrganGroups' => $MyOrganGroups, 'SiteTitle' => $ret['SiteTitle'], 'sid' => $uid,
                'Title' => $ret['Title'], 'Small' => $ret['Small'], 'uname' => $ret['uname'], 'pid' => 'desktop',
                'menu' => $ret['menu'], 'content' => 'شما به این قسمت دسترسی ندارید', 'Files' => '', 'keywords' => '',
                'Portals' => $Portals, 'keywordTab' => $keywordTab, 'tabs' => $ret['tabs'], 'Tree' => $Tree, 'tools' => $shortTools, 'menutools' => $MenuTools));
        }
    }

    public static function PageSetting($sid, $pid, $uid, $sesid, $title = '')
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $subject_policies = policy_CanView($sid, '\App\Models\hamafza\Subject', '\App\Policies\SubjectPolicy', 'canEdit');
            if ($subject_policies == false)
            {
                return "شما به ابزار تنظیمات این صفحه دسترسی ندارید!";
            }
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $s = $SP->GetPageSetting($uid, $sesid, $sid, $pid);
            $Setting = $s['propertie'];
            $kind = $s['propertie']['kind'];
            $str = '';
            $Fields = $s['propertie']['Fields']['fields'];
            $Reports = $s['propertie']['Fields']['reports'];
            if (count($Fields))
            {
                foreach ($Fields as $key => $val)
                {
                    $field_name = $val->name;
                    $field_type = $val->type;
                    $field_value = '';
                    $field_vals = '';
                    $requires = $val->requires;
                    $Desc = $val->help;
                    $field_id = $val->id;
                    $field_value = $val->defvalue;
                    $field_value = explode('|', $field_value);
                    $Report = '';
                    foreach ($Reports as $value)
                    {
                        if ($value->field_id == $field_id)
                        {
                            $Report = $value->field_value;
                        }
                    }
                    $str .= '<tr>';
                    $pc = new PublicClass();
                    $str .= $pc->field_view($field_id, $field_name, $field_type, $field_value, $requires, $Desc, $Report);
                    $str .= '</tr>';
                }
            }
            $Relations_in_subject = $s['Relations'];
            $res_array = [];

            if (isset($Relations_in_subject[0]))
            {
                if (isset($Relations_in_subject[0]['rel']))
                {
                    if($Relations_in_subject[0]['rel'] != '0')
                    {
                        foreach ($Relations_in_subject as $res)
                        {
                            $res_array[$res['rel']][] = $res;
                        }
                    }
                }
            }

            $Relations_in_subject = json_encode($res_array);
            $Helps = $s['Helps'];
            $relations = Relations::all();
            $relations_array = array();
            $str = '';
            foreach ($relations as $result)
            {
                if ($result->directname != '')
                {
                    $rel['id'] = 'D' . $result->id;
                    $rel['text'] = $result->directname.'('.$result->name.')';
                    array_push($relations_array, $rel);
                }
                if ($result->Inversename != '')
                {
                    $rel['id'] = 'I' . $result->id;
                    $rel['text'] = $result->Inversename .'('.$result->name.')';
                    array_push($relations_array, $rel);
                }
            }
            $relations_json= json_encode($relations_array);
            $Access = $s['Access'];
            $Setting = json_encode($Setting);
            $Setting = json_decode($Setting);
            $Access = json_encode($Access);
            $Access = json_decode($Access);
            $subjects = Subject::where('id', $sid)->with('keywords')->first();
            $user = User::find($subjects->admin);
            $admin = $user ? [$user->id, $user->FullName] : [0, 'کاربر حذف شده است.'];
            $spi = $subjects->product_info;
            $pages = Pages::where('sid', $sid)->select('id')->get();
            if ($pages)
            {
                foreach ($pages as $page)
                {
                    $helps[] = Pages::find($page->id)->help->first();
                }
            }
            return view('hamahang.pages.page_setting', ['admin' => $admin, 'rels' => $relations_json,'subjects' => $subjects, 'Helps' => $Helps, 'Setting' => $Setting, 'fields' => $str, 'sid' => $sid, 'relation' => $Relations_in_subject, 'Access' => $Access, 'pid' => $pid, 'Title' => $title, 'spi' => $spi, 'meta_fields' => $subjects->meta_fields, 'helps' => $helps])->render();
        }
    }

    public static function PageSettingssss($sid, $pid, $uid, $sesid, $title = '')
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $s = $SP->GetPageSetting($uid, $sesid, $sid, $pid);
            $Setting = $s['propertie'];
            $kind = $s['propertie']['kind'];
            $str = '';
            $Fields = $s['propertie']['Fields']['fields'];
            $Reports = $s['propertie']['Fields']['reports'];
            $Fields = json_decode($Fields, true);
            $Reports = json_decode($Reports, true);
            if (is_array($Fields))
            {
                foreach ($Fields as $key => $val)
                {
                    $str .= '<tr>';
                    $field_name = $val['name'];
                    $field_type = $val['type'];
                    $field_value = $val['defvalue'];
                    $Rep_value = '';
                    foreach ($Reports as $item)
                    {
                        if ($item['field_id'] == $val['id'])
                        {
                            $Rep_value = $item['field_value'];
                        }
                    }
                    $field_value = explode('|', $field_value);
                    $requires = $val['requires'];
                    $Desc = $val['help'];
                    $field_id = $val['id'];
                    $str .= PublicClass::PageSettingfields($field_id, $field_name, $field_type, $field_value, $requires, $Desc, $Rep_value);
                    $str .= '</tr>';
                }
            }
//            if (is_array($Fields)) {
//                
//                $field_name = $Fields['name'];
//                $field_type = $Fields['type'];
//                $field_value = $Fields['value'];
//                $field_vals = $Fields['vals'];
//                $requires = $Fields['requires'];
//                $Desc = $Fields['Desc'];
//                $field_id = $Fields['id'];
//                foreach ($field_id as $key => $val) {
//                    $str.= '<tr>';
//                    $pc = new PublicClass();
//                    $vals = (array_key_exists($key, $field_vals)) ? $field_vals[$key] : '';
//                    $str.=$pc->field_view($key, $field_name[$key], $field_type[$key], $field_value[$key], $requires[$key], $Desc[$key], $vals);
//                    $str.= '</tr>';
//                }
//            }
            $Relations = $s['Relations'];
            $rel = '<table class="table">';
            $n = 1;
            if (is_array($Relations))
            {
                foreach ($Relations as $val)
                {
                    $rel .= PageClass::ManageRel($val['right'], $val['left'], $val['rel'], $n);
                    $n++;
                }
                $max = $n + 5;
                for ($n; $n <= $max; $n++)
                {
                    $rel .= PageClass::ManageRel($val['right'], '', '', $n);
                }
            }
            else
            {
                $max = $n + 5;
                $r['right']['id'] = $sid;
                $r['right']['title'] = $title;
                for ($n; $n <= $max; $n++)
                {
                    $rel .= PageClass::ManageRel($r['right'], '', '', $n);
                }
            }
            $Helps = $s['Helps'];
            $rel .= '</table>';
            $Access = $s['Access'];
            $Access = json_encode($Access);
            $Access = json_decode($Access);
            $Setting = json_encode($Setting);
            $Setting = json_decode($Setting);
            return view('modals.page_setting', array('Helps' => $Helps, 'Setting' => $Setting, 'fields' => $str, 'sid' => $sid, 'relation' => $rel, 'Access' => $Access, 'pid' => $pid));
        }
    }

    public static function ManageRel($right, $n, $sid, $title)
    {
        $relations = DB::table('relations')->get();
        $rels = array();
        foreach ($relations as $value)
        {
            if ($value->directname != '')
            {
                $rel['id'] = 'D' . $value->id;
                $rel['title'] = $value->directname;
                $rel['name'] = $value->name;

                array_push($rels, $rel);
            }
            if ($value->Inversename != '')
            {
                $rel['id'] = 'I' . $value->id;
                $rel['title'] = $value->Inversename;
                $rel['name'] = $value->name;

                array_push($rels, $rel);
            }
        }
        $str = '';
        if (array_key_exists('right', $right))
        {
            if ($right->right->id == $sid)
            {
                $str = '<tr><td style="width:1px;border:none;"><input type="hidden" name="subject1[' . $n . ']" value="' . $right->right->id . '"  /></td>
		<td style="width:120px;border:none;">';
                $str .= PageClass::relations($n, $rels, 1, $right->rel);
                $str .= '</td>';
                if ($right->left->id > 0)
                {
                    $str .= '<script type="text/javascript">$(document).ready(function(){$("#subject' . $n . '").tokenInput("add", {id: "' . $right->left->id . '", name: "' . $right->left->title . '" });});</script>';
                }
                $str .= '<td style="width:250px;border:none;"><input type="hidden" name="subject12[' . $n . ']" value=""  /><input type="text" class="Auto-com token-input-list-pages" id="subject' . $n . '" name="subject2[' . $n . ']"  style="width:250px !important;" /></td></tr>';
            }
            elseif ($right->left->id == $sid)
            {
                $str = '<tr><td style="width:1px;border:none;"><input type="hidden" name="subject1[' . $n . ']" value="' . $right->left->id . '"  /></td>
		<td style="width:120px;border:none;">';
                $str .= PageClass::relations($n, $rels, 0, $right['rel']);
                $str .= '</td>';
                if ($right['right']['id'] > 0)
                {
                    $str .= '<script type="text/javascript">$(document).ready(function(){$("#subject' . $n . '").tokenInput("add", {id: "' . $right->right->id . '", name: "' . $right->right->title . '" });});</script>';
                }
                $str .= '<td style="width:250px;border:none;"><input type="hidden" name="subject12[' . $n . ']" value=""  /><input type="text" class="Auto-com token-input-list-pages" id="subject' . $n . '" name="subject2[' . $n . ']"  style="width:250px !important;" /></td></tr>';
            }
        }
//        else
//        {
            $str = '<tr><td style="width:1px;border:none;"><input type="hidden" name="subject1[' . $n . ']" value="' . $sid . '"  /></td>
		<td style="width:120px;border:none;">';
            $str .= PageClass::relations($n, $rels, 0, '');
            $str .= '</td>';
            $str .= '<td style="width:250px;border:none;"><input type="hidden" name="subject12[' . $n . ']" value=""  /><input type="text" class="Auto-com token-input-list-pages" id="subject' . $n . '" name="subject2[' . $n . ']"  style="width:250px !important;" /></td></tr>';
//        }

        return $str;
    }

    public static function relations($n, $rels, $sid1, $rel)
    {
        $res = '<select style="width:220px;" dir="rtl" class="form-control" name="relation[' . $n . ']">';
        $rel = ($sid1 == 1) ? "D" . $rel : "I" . $rel;
        foreach ($rels as $value)
        {
            $checked = ($rel == $value['id']) ? 'selected=""' : '';
            $res .= '<option value="' . $value['id'] . '" ' . $checked . '   >' . $value['title'] . ' (' . $value['name'] . ')</option>';
        }
        $res .= '</select>';
        return $res;
    }

    public function update_subject($uid, $sesid, $sid, $subject_title, $PS_keywords, $field, $tt, $subject_help, $subject_pid)
    {
        $SP = new \App\HamafzaServiceClasses\SubjectsClass();
        $menu = $SP->UpdateSubject($uid, $sesid, $subject_title, $PS_keywords, $field, $sid, $tt, $subject_help, $subject_pid);
        return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
    }

    public function IntroFilms($films)
    {
        $images = '<div id="FilmSection">';
        $fehrest = '';
        $n = 0;
        foreach ($films as $row)
        {
            if ($n == 0)
            {
                $show = '';
            }
            else
            {
                $show = 'display:none';
            }
            $images .= '<div id="Video_' . $row['id'] . '" class="VideCotrol" style="' . $show . '">'
                . '<span ><h1>' . $row['title'] . '</h1></span><div style="background-image: url(videos/' . $row['pic'] . ');background-repeat: no-repeat;background-size:100%;-moz-background-size:100% 100%;text-align: center;
-webkit-background-size:100% 100%;
background-size:100% 100%; height:310px ; width: 600px ;margin: auto; "><img src="videos/play.png" style="padding: 100px 0 0 0;" class="Playcontrol" vid="VideoControl_' . $row['id'] . '"/> <video id="VideoControl_' . $row['id'] . '" controls="controls" width="600" height="310" class="VideCotroler" style="display:none;">
<source src="videos/' . $row['film'] . '"></video></div>'
                . '<center><a target="_blank" href="videos/' . $row['film'] . '">' . 'دانلود ویدیو </a></center><span>' . $row['descr'] . '</span></div>';
            if ($row['pretitle'] == '1')
            {
                $style = "margin-right:5px;";
            }
            else
            {
                if ($row['pretitle'] == '2')
                {
                    $style = "margin-right:15px;";
                }
                else
                {
                    if ($row['pretitle'] == '3')
                    {
                        $style = "margin-right:25px;";
                    }
                }
            }
            $fehrest .= '<span style="' . $style . '"><a style="direction:rtl;width: 100%;color: #000;cursor: pointer; font-size: 9pt;" class="ShowVideos" vid=' . $row['id'] . '>' . $row['title'] . '<span style="float:left;color: gray;"> ' . $row['length'] . ' <span></a></span><br>';

            $n++;
        }
        if ($n >= 1)
        {
            Session::put('list', '<div ><br>' . $fehrest . '</div>');
        }

        $images .= '</div>';
        return $images;
    }

    public function OldIntroSlide($slides)
    {
        $res = '<p><div style="margin-top:20px;" id="SlideSection"><link rel="stylesheet" href="' . url('/') . '/theme/Content/css/demo.css" type="text/css" media="screen" /> <div class="wmuSlider PageSlides"><div class="wmuSliderWrapper">';
        $images = '';
        $n = 0;
        foreach ($slides as $value)
        {
            $images .= "<article> <img src='" . url('/') . "/{$value['src']}' /></article>";
            $n++;
        }

        $end = '</div>
      <script type="text/javascript" src="' . url('/') . '/theme/Scripts/modernizr.custom.min.js"></script>    
    <script src="' . url('/') . '/theme/Scripts/wmuslider.js"></script>
    <script src="' . url('/') . '/theme/Scripts/wmugallery.js"></script>
    <script>
        $( document ).ready(function() {
       
$("#SlideSwitch").click(function() {
            $(".Fehrest").hide();
            //$("#accordion").hide();
 alert("ss");

      $("#SlideSection").show();
            $("#TextSection").hide();
             $("#FilmSection").hide();
                   $(".PageSlides").wmuSlider(); 
                   $("#SlideSwitch").addClass("btnActive");
$("#SlideSwitch").removeClass("UnSelectTagBut"); 
$("#TextSwitch").removeClass("btnActive"); 
$("#FilmSwitch").removeClass("btnActive"); 



});
$("#TextSwitch").click(function() {
 $(".Fehrest").show();
            $("#accordion").show();

      $("#SlideSection").hide();
                   $("#FilmSection").hide();
$("#FilmSwitch").removeClass("btnActive"); 

            $("#TextSection").show();
      $("#TextSwitch").addClass("btnActive");
$("#TextSwitch").removeClass("UnSelectTagBut"); 
$("#SlideSwitch").removeClass("btnActive"); 

});

$("#FilmSwitch").click(function() {
$("#SlideSection").hide();
$("#TextSection").hide();
$("#TextSwitch").removeClass("btnActive"); 
$("#FilmSection").show();
$("#FilmSwitch").addClass("btnActive");
$("#FilmSwitch").removeClass("UnSelectTagBut"); 
$("#SlideSwitch").removeClass("btnActive"); 

});


';

//        if (($pid == 21 || $pid == 24) && (isset($_GET['title']) && $_GET['title'] = '1'))
//            $end.=' $("#SlideSwitch").trigger("click");$(".PageSlides").stop();';


        $end .= '});</script><style>.wmuSliderPagination{left:450px !important;} </style>
    </div> </div>';
        if ($n > 0)
        {
            return $res . $images . $end;
        }
        else
        {
            return '';
        }
    }

    public function IntroSlide($slides)
    {
        $res = '<p><div style="margin-top:20px;" id="SlideSection"><link rel="stylesheet" href="' . url('/') . '/theme/Content/css/galleria.classic.css" type="text/css" media="screen" /> <div class="galleria">';
        $images = '';
        $n = 0;
        foreach ($slides as $value)
        {
            $images .= "<img src='" . url('/') . "/" . $value['src'] . "'> ";
            $n++;
        }

        $end = '</div>
        
    <script src="' . url('/') . '/theme/Scripts/galleria-1.4.2.min.js"></script>
   
    <script>
        $( document ).ready(function() {
       
$("#SlideSwitch").click(function() {
      $("#SlideSection").show();
            $("#TextSection").hide();
                     //   $("#accordion").hide();
            $(".Fehrest").hide();

             $("#FilmSection").hide();
                   
                   $("#SlideSwitch").addClass("btnActive");
$("#SlideSwitch").removeClass("UnSelectTagBut"); 
$("#TextSwitch").removeClass("btnActive"); 
$("#FilmSwitch").removeClass("btnActive"); 



});
$("#TextSwitch").click(function() {
   $(".Fehrest").show();
                        $("#accordion").show();
      $("#SlideSection").hide();
                   $("#FilmSection").hide();
$("#FilmSwitch").removeClass("btnActive"); 

            $("#TextSection").show();
      $("#TextSwitch").addClass("btnActive");
$("#TextSwitch").removeClass("UnSelectTagBut"); 
$("#SlideSwitch").removeClass("btnActive"); 

});

$("#FilmSwitch").click(function() {
$("#SlideSection").hide();
$("#TextSection").hide();
$("#TextSwitch").removeClass("btnActive"); 
$("#FilmSection").show();
$("#FilmSwitch").addClass("btnActive");
$("#FilmSwitch").removeClass("UnSelectTagBut"); 
$("#SlideSwitch").removeClass("btnActive"); 

});


';

//        if (($pid == 21 || $pid == 24) && (isset($_GET['title']) && $_GET['title'] = '1'))
//            $end.=' $("#SlideSwitch").trigger("click");$(".PageSlides").stop();';


        $end .= '
            Galleria.loadTheme("' . url('/') . '/theme/Scripts/galleria.classic.min.js");
            Galleria.run(".galleria");
              //$(".Fehrest").hide();
                 //       $("#accordion").hide();

       });  </script>
   </div>';
        if ($n > 0)
        {
            return $res . $images . $end;
        }
        else
        {
            return '';
        }
    }

    public static function ModifyContent($content)
    {
        $content = str_replace("<h2>&nbsp;</h2>", "", $content);
        $content = str_replace("<h2></h2>", "", $content);
        $content = str_replace("<h2> </h2>", "", $content);
        $content = str_replace("<h1>&nbsp;</h1>", "", $content);
        $content = str_replace("<h1></h1>", "", $content);
        $content = str_replace("<h1> </h1>", "", $content);
        $content = str_replace("<h3>&nbsp;</h3>", "", $content);
        $content = str_replace("<h3></h3>", "", $content);
        $content = str_replace("<h3> </h3>", "", $content);
        $content = str_replace("<h4>&nbsp;</h4>", "", $content);
        $content = str_replace("<h4></h4>", "", $content);
        $content = str_replace("<h4> </h4>", "", $content);
        return $content;
    }

    public function EditPageSend($pid, $uid, $sesid, $content, $ver_comment, $ver_date, $edit_num, $description)
    {
        $SP = new \App\HamafzaServiceClasses\PageClass();
        $content = PageClass::ModifyContent($content);
        $menu = $SP->page_edit($pid, $uid, $sesid, $content, $ver_comment, $ver_date, $edit_num, $description);
        return $menu;
    }

    public static function PageFields($Fields, $showDefimg, $defimage)
    {

        $str = '';
        $strs = '';
        $Fields = json_decode($Fields, true);
        if (is_array($Fields))
        {
            $str = '<table class="">';
            foreach ($Fields as $key => $value)
            {
                $rep = '';
                $str .= (trim($value['field_val']) != '') ? '<tr><td style="padding:2px 5px 0 5px ;">' . $value['name'] . '</td><td >' . $value['field_val'] . '</td></tr>' : '';
            }
            $str .= '</table>';
            $strs = $str;
        }
        if ($showDefimg == '1')
        {
            $strs = '<table><tr><td style="vertical-align: top;"><img style="max-width: 120px;" src="' . asset('/') . '/' . $defimage . '"></td><td></td><td style="vertical-align: top;"> ' . $str . '</td></tr></table>';
        }
        return $strs;


//        $str = '';
//        $strs = '';
//        if (is_array($Fields)) {
//            $str = '<table class="">';
//            foreach ($Fields as $value) {
//                $str.='<tr><td style="padding:2px 5px 0 5px ;">' . $value['label'] . '</td><td>' . $value['val'] . '</td></tr>';
//            }
//            $str.='</table>';
//            $strs = $str;
//        }
//        if ($showDefimg == '1') {
//            $strs = '<table><tr><td style="vertical-align: top;"><img style="max-width: 120px;" src="' .base_url(). '/' . $defimage . '"></td><td></td><td style="vertical-align: top;"> ' . $str . '</td></tr></table>';
//        }
//        return $strs;
    }

    public static function GetRightCol($uid, $sesid, $sid, $type)
    {
        //  $SP = new service();
        // $menu = $SP->ServicePost('RightCol', 'uid=' . $uid . '&sesid=' . $sesid . '&sid=' . $sid . '&type=' . $type);
        // echo 'RightCol'. 'uid=' . $uid . '&sesid=' . $sesid . '&sid=' . $sid . '&type=' . $type;
//        $json_a = json_decode($menu, true);
//        $s = $json_a['data'];
        $d = PublicsClass::RightCol($uid, $sesid, $sid, $type, 1);

        return $d;
    }

    /* public static function GetProtals($uid, $sesid)
      {
      //        if ($uid != 0) {
      //           // if (!Cache::has('Protals')) {
      //                $SP = new service();
      //                $menu = $SP->ServicePost('GetProtals', 'uid=' . $uid . '&sesid=' . $sesid);
      //                $json_a = json_decode($menu, true);
      //                $s = $json_a['portals'];
      //                $PC = new PublicClass();
      //                if (is_array($s)) {
      //                    $newtree = $PC->CretaeTree1L($s, 'pid', 'parent_id', 'title');
      //                    $newtree = $PC->Json(0, $newtree);
      //                } else {
      //                    $newtree = '';
      //                }
      ////                Cache::put('Protals', $newtree, 60);
      ////            } else
      ////                $newtree = Cache::get('Protals');
      //        }
      //        else
      //        if ($uid == 0) {
      ////            if (!Cache::has('ProtalsU')) {
      //                $SP = new service();
      //               // return 'GetProtals'. 'uid=' . $uid . '&sesid=' . $sesid;
      //                $menu = $SP->ServicePost('GetProtals', 'uid=' . $uid . '&sesid=' . $sesid);
      //                $json_a = json_decode($menu, true);
      //                $s = $json_a['portals'];
      //                $PC = new PublicClass();
      //                if (is_array($s)) {
      //                    $newtree = $PC->CretaeTree1L($s, 'pid', 'parent_id', 'title');
      //                    $newtree = $PC->Json(0, $newtree);
      //                } else {
      //                    $newtree = '';
      //                }
      ////                Cache::put('ProtalsU', $newtree, 60);
      ////            } else
      ////                $newtree = Cache::get('ProtalsU');
      //        }
      return '';
      } */

    /* public static function MenuTools($menutools, $sid, $uid, $sesid)
      {
      $SP = new service();
      $res = '<div class="btn-group pull-right frst-wdt mr"><button type="button" id="rSubMenuBtn" class="btn  fa fa-align-justify icon-reorder" data-icon="U+E0CC" data-toggle="tooltip" data-placement="top" title="ابزارها"></button></div>';
      $menu = $SP->ServicePost('CheckLogin', 'user_id=' . $uid . '&session_id=' . $sesid);
      $json_a = json_decode($menu, true);
      $s = $json_a['data'];
      if ($s)
      {
      foreach ($menutools as $item)
      {
      foreach ($item[1] as $items)
      {
      $name = $items['name'];
      $items['link'] = 'modals/' . $items['name'] . '?sid=' . $sid;
      }
      }
      }
      return $menutools;
      }

      public static function Tools($sid, $pid, $uid, $sesid, $type = 'publicpage', $subtype = 'subject')
      {
      $res = '<div class="btn-group pull-right frst-wdt mr"><button type="button" id="rSubMenuBtn" class="btn  fa fa-align-justify icon-reorder" data-icon="U+E0CC" data-toggle="tooltip" data-placement="top" title="ابزارها"></button></div>';

      $s = PagesClass::page_tools($sid, $pid, $uid, $subtype, $sesid, true);
      $val = $s['val'];
      $label = $s['label'];
      $help = $s['Help'];

      $others = $s['othermenus'];
      $islogin = session('Login');

      $uid = session('uid');

      //    foreach ($s as $value) {
      if ($uid != '' && $uid != '0')
      {
      if ($val['like'] == '1')
      {
      $res .= '<div  class="btn-group pull-right mr"><button id="LikePage" val="0" uid="' . $uid . '" sessid="' . $sesid . '" sid="' . $sid . '" type="button" class="btnActive  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="' . $label['disLike'] . '"></button></div>';
      }
      else
      {
      if ($val['like'] == '0')
      {
      $res .= '<div  class="btn-group pull-right mr"><button id="LikePage" val="1" uid="' . $uid . '" sessid="' . $sesid . '" sid="' . $sid . '" type="button" class="btn  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="' . $label['like'] . '"></button></div>';
      }
      }
      if ($val['follow'] == '1')
      {
      $res .= '<div class="btn-group pull-right mr"><button id="FollowPage" val="0" uid="' . $uid . '" sessid="' . $sesid . '" sid="' . $sid . '" type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="' . $label['unfollow'] . '"></button></div>';
      }
      else
      {
      if ($val['follow'] == '0')
      {
      $res .= '<div class="btn-group pull-right mr"><button id="FollowPage" val="1" uid="' . $uid . '" sessid="' . $sesid . '" sid="' . $sid . '" type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="' . $label['follow'] . '"></button></div>';
      }
      }
      $res .= '<div class="btn-group pull-right mr"><button id="CommentPage" val="1" uid="' . $uid . '" sessid="' . $sesid . '" sid="' . $sid . '" type="button" class="btn  fa fa-anchor icon-ezhare-nazar comment" data-toggle="tooltip" data-placement="top" title="' . $label['comment'] . '"></button></div>';
      }
      else
      {
      $res .= '<div  class="btn-group pull-right mr"><button type="button" class="btn  fa fa-anchor icon-pasandidan login" data-toggle="modal" data-target="#loginWmessage" data-placement="top"  title="' . $label['like'] . '"></button></div>';
      $res .= '<div class="btn-group pull-right mr"><button  type="button" class="btn  fa fa-anchor icon-rss login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="' . $label['unfollow'] . '"></button></div>';
      $res .= '<div class="btn-group pull-right mr"><button type="button" class="btn  fa fa-anchor icon-ezhare-nazar login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="' . $label['comment'] . '"></button></div>';
      }
      $help = json_encode($help);

      $help = json_decode($help);
      if ($help)
      {
      $res .= '<div class="btn-group" style="float: left"><a href="' . url('/') . '/modals/helpview?id=' . $help->pageid . '&tagname=' . $help->tagname . '&hid=' . $help->id . '&pid=25" title=" راهنمای اینجا"  class="jsPanels icon-help HelpIcons"></a></div>';
      }

      //   }
      //dd($others);
      if ($help)
      {
      $helpParams = ['pageid' => $help->pageid, 'tagname' => $help->tagname, 'id' => $help->id];
      }
      else
      {
      $helpParams = 0;
      }
      $ret['abzar'] = shortToolsGenerator('Page', $uid, ['uid' => $uid, 'sessid' => $sesid, 'sid' => $sid], $helpParams);
      $ret['other'] = $others;
      return $ret;
      } */

    public function PageDetail($pid, $uid = 0, $ses_id = 0, $Type = '', $Edit = '0', $hid = 0, $islocal = '')
    {
        if ($uid != 0)
        {
            $shType = ($Edit == '1') ? '1' : '';
            $data = PagesClass::PageDetail($pid, $shType, $uid, $hid, $ses_id, '', 0, $islocal);
        }
        else
        {
            if ($uid == 0)
            {
                $data = PagesClass::PageDetail($pid, '', $uid, $hid, $ses_id, '', 0, $islocal);
            }
        }
        return $data;
    }

    public function SubjectTabs($sid)
    {
        $PageClass = new PagesClass();
        $tabs = $PageClass->SubjectTabs($sid);
        return $tabs;
    }

    /* public function DesktopTree($id, $type = '', $Selected = '')
      {
      $uid = (session('uid') != '') ? session('uid') : 0;
      $sesid = (session('sesid') != '') ? session('sesid') : 0;
      $menus = array();
      $menusRet = array();
      $menu['id'] = '#vazaef';
      $menu['text'] = 'وظایف ';
      $menu['href'] = '#';
      $menu['parent'] = '#';
      array_push($menus, $menu);
      $menu['id'] = 'user_measures_page?tt=ZE';
      $menu['text'] = 'وظایف من';
      $menu['href'] = 'user_measures_page';
      $menu['parent'] = '#vazaef';
      array_push($menus, $menu);
      $menu['id'] = 'BCump?tt=BC';
      $menu['text'] = 'رونوشت‌های من';
      $menu['href'] = 'user_measures_page';
      $menu['parent'] = '#vazaef';
      array_push($menus, $menu);
      $menu['id'] = 'user_measures_page?tt=Fme';
      $menu['text'] = 'ارجاعات من';
      $menu['href'] = 'user_measures_page';
      $menu['parent'] = '#vazaef';
      array_push($menus, $menu);

      $menu['id'] = 'user_measures_page?tt=MeDrafts';
      $menu['text'] = 'پیش‌نویس‌های من';
      $menu['href'] = 'user_measures_page';
      $menu['parent'] = '#vazaef';
      array_push($menus, $menu);
      $menu['id'] = 'user_measures_page?tt=ALL';
      $menu['text'] = 'همه';
      $menu['href'] = 'user_measures_page';
      $menu['parent'] = '#vazaef';
      array_push($menus, $menu);
      $menu['id'] = '#yaddahtha';
      $menu['text'] = ' یادداشت‌ها';
      $menu['href'] = 'yaddasht';
      $menu['parent'] = '#';
      array_push($menus, $menu);
      $menu['id'] = 'announces?type=XE';
      $menu['text'] = ' یادداشت‌ها';
      $menu['href'] = 'yaddasht';
      $menu['parent'] = '#yaddahtha';
      array_push($menus, $menu);
      $menu['id'] = 'highlights?type=YE';
      $menu['text'] = ' علامت‌گذاری‌ها';
      $menu['href'] = 'yaddasht';
      $menu['parent'] = '#yaddahtha';
      array_push($menus, $menu);
      $PC = new PublicClass();
      if (is_array($menus) && count($menus) > 0)
      {
      $newtree = $PC->CretaeTree1L($menus, 'id', 'parent', 'text');
      $newtree = $PC->Json(0, $newtree, $type, $Selected);
      }
      else
      {
      $newtree = '';
      }
      return $newtree;
      } */
}
