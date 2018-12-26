<div class="pull-left user-config">
    @if(Auth::check())
        <div class="pull-left user-config dropdown">
            <a href="#" id="avatar" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{Auth::user()->Name.' '.Auth::user()->Family}}
                <span class="caret"></span>
                <img class="img-circle img-responsive jsPanels" href="{{route('modals.profile_avatar')}}" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(auth()->user()->avatar)])}}"/>
            </a>
            <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}/wall" class="wall">دیوار @if(session('WallNotificaton')>0)<span class="badge">{{session('WallNotificaton')}}</span>@endif</a>
            <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}/desktop" class="wall">میز کار @if(session('DesktopNotificaton')>0)<span class="badge DesktopNotificaton">{{session('DesktopNotificaton')}}</span>@endif</a>
            <!-- begin cart`s basket -->
            <a href="{{ route('ugc.desktop.hamahang.bazaar.cart', ['username' => auth()->user()->Uname]) }}" class="wall" style="visibility: {!! count(Session::get('cart')) ? 'visible' : 'hidden' !!}" id="basket_area">
                <div style="display: inline-block;">
                    <span>سبد خرید</span>
                    <div id="cart_basket_count" style="display: inline-block; border-radius: 100%; background: rgba(252, 255, 7, 0.7); color: black; width: 18px; height: 18px; text-align:center; padding-top: 2px; position: absolute; font-size: 10px; top: -7px; left: -14px">
                        {!! count(Session::get('cart')) !!}
                    </div>
                </div>
            </a>
            {{--
            <a href="{{ route('ugc.desktop.hamahang.bazaar.cart', ['username' => auth()->user()->Uname]) }}" class="wall">
                <div style="display: inline-block;">
                    <i class="fa fa-shopping-basket" id="cart_basket" style="font-size: 18px;"></i>
                    <div id="cart_basket_count" style="display: inline-block; border-radius: 100%; background: rgba(252, 255, 7, 0.9); color: black; width: 18px; height: 18px; text-align:center; padding-top: 2px; position: fixed; margin: -5px -7px 0 0; font-size: 10px;" id="cart_count">
                        {!! count(Session::get('cart')) !!}
                    </div>
                </div>
            </a>
            --}}
            <!-- end cart`s basket -->
            <div class="dropdown-menu">
                <span class="glyphicon glyphicon-triangle-top"></span>
                <img class="img-responsive pull-right jsPanels" href="{{route('modals.profile_avatar')}}" src="{{ auth()->user()->avatar_link }}"/>
                <b>{{Auth::user()->Name.' '.Auth::user()->Family}}</b>
                <span>
                @if(session('Summary')!="")
                        {{session('Summary')}}
                    @else
                        {{session('email')}}
                    @endif
                </span>
                <BR>
            <!--
                <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}?tab=wall" class="wall">دیوار </a>
                <a href="{{App::make('url')->to('/')}}/{{session('Uname')}}?tab=desktop">میز کار </a>
                -->
                <div class="col-md-6 noPadding" style=" margin-right: 90px;">
                    <a style="background-color: #3eb332;border: medium none;border-radius: 0;color: #fff;font-size: 9pt; margin: 10px 0 0;position: relative; width: 100%;" href="{{App::make('url')->to('/')}}/{{session('Uname')}}"
                       type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">معرفی</a>
                </div>
                <div class="clearfix"></div>
                <div class="footer">
                    <a style="display: none;" onclick="Amgh" style="z-index: 10000000" id="UserSet" class="jsPanels" href="{{App::make('url')->to('/')}}/modals/setting?sid={{session('uid')}}&type=user" title="تنظیمات"> مشخصات
                        <div class="icon-tanzimat pull-right" STYLE="FONT-SIZE: 12PT;padding: 3PX;height: 10px;"></div>
                    </a>
                    <a href="{{App::make('url')->to('/')}}/Logout" class="pull-left exit"><span class="glyphicon glyphicon-off"></span>خروج</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @else
        <img class="pull-right" src="{{App::make('url')->to('/')}}/theme/Content/icons/avatar.png"/>
        <div class="login" data-toggle="modal" data-target="#login">ورود</div>
        <div class="register" data-toggle="modal" data-target="#register">ثبت نام</div>
    @endif
</div>
<ul class="nav navbar-nav pull-left quick-links">
    @if(session('Login') && session('Login')=='TRUE')
        <li>
            <a>
                <span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span>
            </a>
        </li>
    @else
        <li style="display: none;">
            <a>
                <span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span>
            </a>
        </li>
    @endif
    <li><a><span class="icon-dargah" title="درگاه‌ها" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li><a><span class="icon-tag" title="کلید واژه‌ها" data-placement="top" data-toggle="tooltip"></span></a></li>
    <li><a><span class="icon-search-1" title="جستجو" data-placement="top" data-toggle="tooltip"></span></a></li>
</ul>
<div class="side-search">
    <div class="navbar navbar-default">
        <ul class="nav nav-tabs">
            <li class="active"><a aria-controls="side-search-tab-1" href="#side-search-tab-1" role="tab" data-toggle="tab"><span class="icon-search-1"></span>جستجو</a></li>
            <li><a aria-controls="side-search-tab-2" href="#side-search-tab-2" role="tab" data-toggle="tab"><span class="icon-tag"></span>کلید واژه‌ها</a></li>
            <li><a aria-controls="side-search-tab-3" href="#side-search-tab-3" role="tab" data-toggle="tab"><span class="icon-dargah"></span>درگاه‌ها</a></li>
            <li><a aria-controls="side-search-tab-4" href="#side-search-tab-4" role="tab" data-toggle="tab"><span class="icon-choobalefnazok" uid="{{session('uid')}}"></span>چوب‌های الف</a></li>
        </ul>
        <button type="button" class="close pull-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="tab-content">
        <div id="side-search-tab-1" role="tabpanel" class="tab-pane active">
            <div class="row col-md-12 pull-left">
                <form id="form_search_tab">
                    <div class="row col-md-12 pull-left">
                        <div class="col-md-10">
                            <input class="form-control" alt="Search" maxlength="50" id="searchword" name="searchw" @if(session('SearchRes')!='')value="{{session('SearchWord')}}"@endif >
                        </div>
                        <div class="col-md-1">
                            <input type="button" value="بیاب" title="Searchpost" class="btn btn-primary" id="SearchBut" style="padding:6px;">
                            <img style="display: none;" src="{{url('/img/loader.gif')}}" id="Searchloding">
                        </div>
                        <div class="col-md-1" style="left: -40px;top: -5px;">
                            <a style="font-size: 16pt;" class="jsPanels icon icon-help HelpIcons" title="راهنمای اینجا" href="{{url('/modals/helpview?id=17&tagname=sotonjostejo&pid=18')}}"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="title_filter" id="title_filter">
                                            <span>{{trans('app.title')}}</span>
                                        </label>
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="content_filter" id="content_filter">
                                            <span>{{trans('app.content')}}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="search_in_pages" id="search_in_pages" checked>
                                            <span>{{trans('app.pages')}}</span>
                                        </label>
                                        <label>
                                            <input type="checkbox" class="form-check-input" name="search_in_posts" id="search_in_posts">
                                            <span>{{trans('app.posts')}}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="SearchRes" class="row col-md-12 pull-left" style="height:600px;">
                    <div id="SearchRes2" style="margin-top: 15px;">
                        @if(session('SearchRes')!='')
                            {{session('SearchRes')}}
                        @endif
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        $("#SearchRes").mCustomScrollbar();
                    })
                </script>
            </div>
        </div>










        <div id="side-search-tab-2" role="tabpanel" class="tab-pane innerpane ">
            <div class="row col-md-12 pull-left">
                <div class="col-md-9">
                    @include('sections.tagNavigat')
                </div>
                <div class="col-md-2">
                    <input type="button" value="بیاب" title="Searchpost" class="btn btn-primary" id="TagBut" style="padding:6px;">
                    <img id="Tagloding" src="{{App::make('url')->to('/')}}/img/loader.gif" style="display: none;"/>
                    <div id="TagRefBut" style="cursor:pointer;display:none;cursor: pointer;height: 15px;overflow: hidden;">
                        <a onclick="RefreshTags();" href="#">
                            <div class="icon icon-chap1"></div>
                        </a>
                    </div>
                </div>
                <div class="col-md-1" style="left: -15px;top: -5px;">
                    <a style="font-size: 16pt;" class="jsPanels icon icon-help HelpIcons" title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=sotonbarchasb&pid=17"></a>
                </div>
            </div>
            <!--<div id="TagRes" class="row col-md-12 pull-left" style="overflow: auto; position: absolute;left:1px;margin-top: 35px">-->
            <div id="side-search-tab-2-1" role="tabpanel" class="tab-pane active">
                <div id="TagRes" class="row col-md-12 pull-left" style="height:600px;">
                    <div class="wrapper">
                        <ul class="nav nav-pills link-word">
                            <li class="active" style="width: 50%;"><a style="padding: 5px;" data-toggle="pill" href="#keyWords">کلید واژه‌ها</a></li>
                            <li style="width: 49%;"><a style="padding: 5px;" id="ShowResKey" style="padding: 5px;" data-toggle="pill" href="#Results" @if(session('TagSearch')=='') style="display: none;" @endif>یافته‌ها</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="keyWords" class="tab-pane active in">
                                <div accordion="" class="panel-group accordion" id="Bookmarkaccordion">
                                    <div id="KeywordFehresrt" style="margin-top: 5px;"></div>
                                </div>
                                <script>
                                    $(document).ready(function ()
                                    {
                                        $("#TagRes").hide();
                                        $("#TagRes").show();
                                        $("#TagRes").mCustomScrollbar();
                                    });
                                    $(function ()
                                    {
                                        $("#KeywordFehresrt").jstree
                                        ({
                                            "plugins": ["search"]
                                        });
                                        var to = false;
                                    });
                                    $('#KeywordFehresrt').jstree
                                    ({
                                        "plugins": ["search"],
                                        'core': {
                                            'data': [
                                                {!!GetPublicKeyword()!!}
                                            ],
                                            'rtl': true,
                                            "themes": {
                                                "icons": false
                                            }
                                        }
                                    });
                                    $("#KeywordFehresrt").bind('select_node.jstree', function (e, data)
                                    {
                                        var texts = data.node.text;
                                        var ids = data.node.id;
                                        $("#Navigatekeywords").tokenInput("add", {id: ids, name: texts});
                                        $("#TagRes").animate
                                        ({
                                            scrollTop: 0
                                        }, 600);
                                    })

                                    .on("activate_node.jstree", function (e, data)
                                    {
                                        window.location.href = data.node.a_attr.href;
                                        history.pushState("", document.title, window.location.pathname + window.location.search);
                                    });
                                </script>
                            </div>
                            <div id="Results" class="tab-pane fade" @if(session('TagSearch')=='') style="display: none;" @endif>
                                <div id="KeywordSearch">
                                    @if(session('TagSearch')!='')
                                        {{session('TagSearch')}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>










        <div id="side-search-tab-3" role="tabpanel" class="tab-pane ">
            <div class="innerpane">
                <div class="row">
                    <div class="col-md-11 txtsearch" style="display: flex; ">
                        <input type="text" class="list-search col-md-5 GharbalSearch" placeholder="غربال..." id="portallist-search"/>

                    </div>
                    <div class="col-md-1" style="height: 20px;position: absolute;top:50px;left:0; ">
                        <a style="font-size: 16pt;" class="jsPanels icon icon-help HelpIcons" title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=soton_dargahha&pid=17"></a>
                    </div>
                </div>


                <div accordion="" class="panel-group accordion" id="portallistDiv" style="height: 500px;">
                    <div id="PrtalFehresrt" class="v"></div>
                </div>

            <!--            <script>
             $(function () {
             $("#PrtalFehresrt").jstree({
             "plugins" : [  "search" ]
             });
                     var to = false;
                     $('#portallist-search').keyup(function () {
             if (to) { clearTimeout(to); }
             to = setTimeout(function () {
             var v = $('#portallist-search').val();
                     $('#PrtalFehresrt').jstree(true).search(v);
             }, 250);
             });
             });
             $('#PrtalFehresrt').jstree({
     "plugins" : [ "search"  ],
             'core': {
             'data': [
             @if(isset($portals))
                {{$Portals}}
            @endif
                    ],
                            'rtl': true,
                            "themes": {
                            "icons": false
                            }
                    }
            });
                    $("#PrtalFehresrt").bind('select_node.jstree',
                    function (e, data)
                    {
                    var id = data.node.id;
                            var n = id.indexOf("#");
                            domain = "{{App::make('url')->to('/')}}/" + id;
                     if (n == - 1){
             window.location = domain;
             }
             })

             .on("activate_node.jstree", function (e, data) {
             window.location.href = data.node.a_attr.href;
                     history.pushState("", document.title, window.location.pathname + window.location.search);
             });
 $("#portallistDiv").mCustomScrollbar("update");
 </script>-->

                <script>
                    $(document).ready(function () {
                        $("#portallistDiv").mCustomScrollbar();
                    })
                </script>
                @if (isset($Portals) && is_array($Portals) )
                    @foreach($Portals as $item)
                        <li>{{ $item['sortid']}} - <a href="{{App::make('url')->to('/')}}/{{ $item['pid']}} "><span>{{ $item['title']}} </span></a></li>
                    @endforeach
                @endif
            </div>
        </div>
        <div id="side-search-tab-4" role="tabpanel" class="tab-pane ">
            @if(session('Login') && session('Login')=='TRUE')
                <div class="innerpane">
                    <?php
                    $Bookmarks = session('Bookmarks');
                    $Bookmarks = $Bookmarks;
                    $i = 1;
                    ?>
                    <div class="row">
                        <div class="col-md-11 txtsearch" style="display: flex; ">
                            <input type="text" class="list-search  col-md-5 GharbalSearch" placeholder="غربال..." id="Bookmarklist-search"/>
                        </div>
                        <div class="col-md-1" style="height: 20px;position: absolute;top:50px;left:0; ">
                            <a style="font-size: 16pt;" class="jsPanels icon icon-help HelpIcons" title="راهنمای اینجا" href="{{App::make('url')->to('/')}}//modals/helpview?id=17&tagname=sotonchobhayealef&pid=17"></a>
                        </div>
                    </div>
                    <div accordion="" class="panel-group accordion" id="Bookmarkaccordion2" style="margin-right:15pt;">
                        <div id="BookmarkFehresrt" class="v"></div>
                    </div>
                    @if (is_array($Bookmarks) )
                        @foreach($Bookmarks as $item)

                            <li style="line-height: 25px; list-style: inside none disc;">{{ $i}} - <a href="{{App::make('url')->to('/')}}/{{ $item['link']}} "><span>{{ $item['Title']}} </span></a></li>
                            <?php $i++; ?>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@include('sections.helper.login_modal',['modal_id'=>'login','csrf'=>$csrf])
@include('sections.helper.login_modal',['modal_id'=>'loginWmessage','modal_login_message'=>true,'csrf'=>$csrf])
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ثبت نام</h3>
            </div>
            <div class="modal-body modal-register">
                <form class="HamafzaIcon " action="{{App::make('url')->to('/')}}/Register" method="post">
                    {{ csrf_field() }}
                    <div class="form-group input-group">
                        <span class="input-group-addon">نام کاربری</span>
                        <input type="text" id="usernameTXT" class="form-control" name="username" aria-label="Amount (to the nearest dollar)" placeholder="فقط حروف انگلیسی">
                        <span class="input-group-addon">EN</span>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon">رایانامه </span>
                        <input type="text" class="form-control" name="email" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-addon">@</span>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon ">رمزعبور</span>
                        <input type="password" class="form-control" name="pass" data-toggle="password" autocomplete="off">
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon">نام </span>
                        <input type="text" class="form-control" name="name" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-addon icon-a-b"></span>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-addon"> نام خانوادگی </span>
                        <input type="text" class="form-control" name="family" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-addon icon-a-b"></span>
                    </div>

                    <div class="row col-md-12 pull-left">
                        <div class="col-md-4">
                            <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas">فراموشی رمز عبور</div>
                        </div>
                        <div class="col-md-3">
                            <div data-dismiss="modal" data-toggle="modal" data-target="#login" class="login">ورود</div>
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-info">ثبت کاربر جدید</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="forgetpas" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">فراموشی رمز عبور</h3>
            </div>
            <div class="modal-body modal-forgetpas">
                <form method="post" action="{{ route('hamafza.forget_pas') }}">
                    <div class="form-group input-group">
                        <span class="input-group-addon">رایانامه </span>
                        <input type="text" name="email_forget" class="form-control" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-addon">@</span>
                    </div>
                    <div class="row col-md-7 pull-left">
                        <div class="col-md-4">
                            <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="help-block register" style="cursor: pointer">ثبت نام</div>
                        </div>
                        <div class="col-md-3">
                            <div data-dismiss="modal" data-toggle="modal" data-target="#login" class="help-block login" style="cursor: pointer">ورود</div>
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-info">ارسال رمز</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

