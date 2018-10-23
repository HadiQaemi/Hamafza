<div class="user-configs navbar-left col-xs-12 col-sm-5 col-md-4 col-lg-5" style="width: 194px;background: #3986AC none repeat scroll 0 0;height: 52px;">
    @if(Session::has('Login') && Session::get('Login')=='TRUE')
        <div class="pull-left user-config dropdown">
            <a href="#" id="avatar" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                {{Session::get('Name')}} {{Session::get('Family')}}<span class="caret"></span>
                <img src="{{App::make('url')->to('/')}}/{{Session::get('pic')}}" class="img-circle img-responsive"/>
            </a>
            <a href="{{App::make('url')->to('/')}}/{{Session::get('Uname')}}/wall" class="wall">دیوار @if(Session::get('WallNotificaton')>100000)<span class="badge">{{Session::get('WallNotificaton')}}</span>@endif</a>
            <a href="{{App::make('url')->to('/')}}/{{Session::get('Uname')}}/desktop" class="wall">میز کار @if(Session::get('DesktopNotificaton')>0)<span class="badge DesktopNotificaton">{{Session::get('DesktopNotificaton')}}</span>@endif
            </a>
            <div class="dropdown-menu">
                <span class="glyphicon glyphicon-triangle-top"></span>
                <img src="{{App::make('url')->to('/')}}/{{Session::get('pic')}}" class="img-responsive pull-right"/>
                <b>{{Session::get('Name')}} {{Session::get('Family')}}</b>
                <span>
                @if(Session::get('Summary')!="")
                        {{Session::get('Summary')}}
                    @else
                        {{Session::get('email')}}
                    @endif
            </span>
                <BR>
            <!--            <a href="{{App::make('url')->to('/')}}/{{Session::get('Uname')}}?tab=wall" class="wall">دیوار </a>
                        <a href="{{App::make('url')->to('/')}}/{{Session::get('Uname')}}?tab=desktop">میز کار </a>-->
                <div class="col-md-6 noPadding" style=" margin-right: 90px;">
                    <a style="background-color: #3eb332;border: medium none;border-radius: 0;color: #fff;font-size: 9pt; margin: 10px 0 0;position: relative; width: 100%;" href="{{App::make('url')->to('/')}}/{{Session::get('Uname')}}"
                       type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        درباره
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="footer">
                    <a style="display: none;" onclick="Amgh" style="z-index: 10000000" id="UserSet" class="jsPanels" href="{{App::make('url')->to('/')}}/modals/setting?sid={{Session::get('uid')}}&type=user" title="تنظیمات"> مشخصات
                        <div class="icon-tanzimat pull-right" STYLE="FONT-SIZE: 12PT;padding: 3PX;height: 10px;"></div>
                    </a>
                    <a href="{{App::make('url')->to('/')}}/Logout" class="pull-left exit"><span class="glyphicon glyphicon-off"></span>خروج</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @else
        <img class="pull-right" src="{{App::make('url')->to('/')}}/theme/Content/icons/avatar.png" style=" padding: 10px"/>
        <div class="login" data-toggle="modal" STYLE="padding-top: 8px;" data-target="#login">ورود</div>
        <div class="register" data-toggle="modal" data-target="#register">ثبت نام</div>
    @endif
</div>
<ul class="nav navbar-nav pull-left quick-links">

    @if(Session::has('Login') && Session::get('Login')=='TRUE')
        <li><a><img class="icon-choobalefnazok" src="{{App::make('url')->to('/')}}/img/bookmarks.png" style="width: 21px" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></a></li>
    @else
        <li style="display: none;"><a><span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span></a></li>

    @endif
    <li><a><img class="icon-dargah" src="{{App::make('url')->to('/')}}/img/3_1.png" style="width: 21px" title="درگاه‌ها" data-placement="top" data-toggle="tooltip"></a></li>
    <li><a><img class="icon-tag" src="{{App::make('url')->to('/')}}/img/tags.png" style="width: 21px" title="کلید واژه‌ها" data-placement="top" data-toggle="tooltip"></a></li>
    <li><a><img src="{{App::make('url')->to('/')}}/img/search.png" style="width: 21px" title="جستجو" data-placement="top" data-toggle="tooltip"></a></li>


</ul>


<div class="side-search">
    <div class="navbar navbar-default">
        <ul class="nav nav-tabs">

            <li class="active"><a aria-controls="side-search-tab-1" href="#side-search-tab-1" role="tab" data-toggle="tab"><span class="icon-search-1"></span>جستجو</a></li>
            <li><a aria-controls="side-search-tab-2" href="#side-search-tab-2" role="tab" data-toggle="tab"><span class="icon-tag"></span>کلید واژه‌ها</a></li>
            <li><a aria-controls="side-search-tab-3" href="#side-search-tab-3" role="tab" data-toggle="tab"><span class="icon-dargah"></span>درگاه‌ها</a></li>
            <li><a aria-controls="side-search-tab-4" href="#side-search-tab-4" role="tab" data-toggle="tab"><span class="icon-choobalefnazok"></span>چوب‌های الف</a></li>
        </ul>
        <button type="button" class="close pull-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="tab-content">
        <div id="side-search-tab-1" role="tabpanel" class="tab-pane active">
            <div class="row col-md-12 pull-left" style="height: 40px;">
                <div class="row col-md-12 pull-left">
                    <div class="col-md-10">
                        <input class="form-control" alt="Search" maxlength="50" id="searchword" name="searchword" @if(Session::get('SearchRes')!='')
                        value="{{Session::get('SearchWord')}}"
                                @endif >
                    </div>
                    <div class="col-md-1">
                        <input type="button" value="بیاب" title="Searchpost" class="btn btn-primary" id="SearchBut" style="padding:6px;">
                        <img style="display: none;" src="{{App::make('url')->to('/')}}/img/loader.gif" id="Searchloding">
                    </div>
                    <div class="col-md-1" style="left: -40px;top: -5px;">
                        <a style="font-size: 16pt;" class="jsPanels icon icon-help HelpIcons" title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=sotonjostejo&pid=18"></a>

                    </div>
                </div>
                <div id="SearchRes" class="row col-md-12 pull-left" style="height:600px;">
                    <div id="SearchRes2" style="margin-top: 15px;">
                        @if(Session::get('SearchRes')!='')
                            {{Session::get('SearchRes')}}
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
            <div class="row col-md-12 pull-left" style="height: 40px;">
                <div class="col-md-9">
                    @include('sections.tagNavigat')
                </div>
                <div class="col-md-2">
                    <input type="button" value="بیاب" title="Searchpost" class="btn btn-primary" id="TagBut" style="padding:6px;">
                    <img id="Tagloding" src="{{App::make('url')->to('/')}}/img/loader.gif" style="display: none;"/>
                    <div id="TagRefBut" style="cursor:pointer;display:none;cursor: pointer;height: 15px;overflow: hidden;"><a onclick="RefreshTags();" href="#">
                            <div class="icon icon-chap1"></div>
                        </a></div>

                </div>
                <div class="col-md-1" style="left: -15px;top: -5px;">
                    <a style="font-size: 16pt;" class="jsPanels icon icon-help HelpIcons" title="راهنمای اینجا" href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=sotonbarchasb&pid=17"></a>

                </div>


            </div>
            <!--<div id="TagRes" class="row col-md-12 pull-left" style="overflow: auto; position: absolute;left:1px;margin-top: 35px">-->

            <div id="side-search-tab-1" role="tabpanel" class="tab-pane active">
                <div id="TagRes" class="row col-md-12 pull-left" style="height:600px;">

                    <div class="wrapper">
                        <ul class="nav nav-pills link-word">
                            <li class="active" style="width: 50%;"><a style="padding: 5px;" data-toggle="pill" href="#keyWords">کلید واژه‌ها</a></li>
                            <li style="width: 49%;"><a style="padding: 5px;" id="ShowResKey" style="padding: 5px;" data-toggle="pill" href="#Results" @if(Session::get('TagSearch')=='') style="display: none;" @endif>یافته‌ها</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="keyWords" class="tab-pane active in">
                                <div accordion="" class="panel-group accordion" id="Bookmarkaccordion">
                                    <div id="KeywordFehresrt" style="margin-top: 5px;"></div>
                                </div>


                                <script>

                                    $(document).ready(function () {
                                        $("#TagRes").hide();
                                        $("#TagRes").show();

                                        $("#TagRes").mCustomScrollbar();
                                    });
                                    $(function () {
                                        $("#KeywordFehresrt").jstree({
                                            "plugins": ["search"]
                                        });
                                        var to = false;
                                    });
                                    $('#KeywordFehresrt').jstree({
                                        "plugins": ["search"],
                                        'core': {
                                            'data': [
                                                {{$keywordTab}}
                                            ],
                                            'rtl': true,
                                            "themes": {
                                                "icons": false
                                            }
                                        }
                                    });
                                    $("#KeywordFehresrt").bind('select_node.jstree',
                                        function (e, data) {
                                            var texts = data.node.text;
                                            var ids = data.node.id;
                                            $("#Navigatekeywords").tokenInput("add", {id: ids, name: texts});
                                            $("#TagRes").animate({
                                                scrollTop: 0
                                            }, 600);
                                        })

                                        .on("activate_node.jstree", function (e, data) {
                                            window.location.href = data.node.a_attr.href;
                                            history.pushState("", document.title, window.location.pathname + window.location.search);
                                        });</script>
                            </div>

                            <div id="Results" class="tab-pane fade" @if(Session::get('TagSearch')=='') style="display: none;" @endif>
                                <div id="KeywordSearch">
                                    @if(Session::get('TagSearch')!='')
                                        {{Session::get('TagSearch')}}
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
                <div class="row" style="height: 40px;">
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
                        {{$Portals}}
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
                <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/scroll/jquery.mCustomScrollbar.concat.min.js"></script>

                <script>
                    $(document).ready(function () {
                        $("#portallistDiv").mCustomScrollbar();

                    })
                </script>
                @if (is_array($Portals) )
                    @foreach($Portals as $item)
                        <li>{{ $item['sortid']}} - <a href="{{App::make('url')->to('/')}}/{{ $item['pid']}} "><span>{{ $item['title']}} </span></a></li>
                    @endforeach
                @endif
            </div>
        </div>
        <div id="side-search-tab-4" role="tabpanel" class="tab-pane ">
            @if(Session::has('Login') && Session::get('Login')=='TRUE')
                <div class="innerpane">
                    <?php
                    $Bookmarks = Session::get('Bookmarks');
                    $Bookmarks = $Bookmarks;
                    $i = 1;
                    ?>
                    <div class="row" style="height: 40px;">
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


<div id="loginWmessage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ورود</h3>
            </div>
            <style>
                input.input-validation-error {
                    border: 1px solid #e80c4d;
                }
            </style>
            <div class="modal-body modal-login">
                <div style="margin:15px;font-size: 9pt;color: red;" class="gkCode10"><p>برای استفاده از این ابزار، دسترسی به اطلاعات کاربری شما ضروری است؛ بنابراین ابتدا باید نام کاربری و رمز خود را وارد نمایید، تا درخواست شما قابل دریافت و
                        اعمال باشد. </p>
                    <p>اگر عضو نیستید، تنها با ثبت «نام، نام خانوادگی و رایانامه» و انتخاب نام کاربری و رمز بلافاصله عضو خواهید شد.</p></div>
                @if(isset($Loginprompt) && $Loginprompt!='')
                    <span style="color:red;margin-bottom: 10px;text-align: cenetr;">{{$Loginprompt}}</span>
                @endif
                <div class="form-group input-group">
                    <span class="input-group-addon">نام کاربری</span>
                    <input type="text" name="usenamew" id="usenamew" class="form-control" required aria-label="Amount (to the nearest dollar)" placeholder="فقط حروف انگلیسی">
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    <span class="input-group-addon">EN</span>
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon">رمزعبور</span>
                    <input class="form-control passwordw" name="passwordw" data-toggle="password" required="required" title="" type="password" autocomplete="off">
                </div>

                <input type="hidden" name="passwordhidw" id="passwordhidw">
                <div class="row col-md-9 pull-left">
                    <div class="col-md-4">
                        <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas">فراموشی رمز عبور</div>
                    </div>
                    <div class="col-md-4">
                        <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="register">ثبت نام</div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" id="LoginButtw">ورود</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>


<div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-darkblue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ورود</h3>
            </div>
            <style>
                input.input-validation-error {
                    border: 1px solid #e80c4d;
                }
            </style>
            <div class="modal-body modal-login">
                @if(isset($Loginprompt) && $Loginprompt!='')
                    <span style="color:red;margin-bottom: 10px;text-align: cenetr;">{{$Loginprompt}}</span>
                @endif
                <div class="form-group input-group">
                    <span class="input-group-addon">نام کاربری</span>
                    <input type="text" name="usename" id="usename" class="form-control" required aria-label="Amount (to the nearest dollar)">
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    <span class="input-group-addon">EN</span>
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon">رمزعبور</span>
                    <input class="form-control password" name="password" data-toggle="password" required="required" title="" type="password" autocomplete="off">
                </div>
                <input type="hidden" name="passwordhid" id="passwordhid">
                <div class="row col-md-9 pull-left">
                    <div class="col-md-4">
                        <div data-dismiss="modal" data-toggle="modal" data-target="#forgetpas" class="help-block forgetpas">فراموشی رمز عبور</div>
                    </div>
                    <div class="col-md-4">
                        <div data-dismiss="modal" data-toggle="modal" data-target="#register" class="register">ثبت نام</div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" id="LoginButt">ورود</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div id="register" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-green">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">ثبت نام</h3>
            </div>
            <div class="modal-body modal-register">
                <form action="{{App::make('url')->to('/')}}/Register" method="post">
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
                    <div class="row col-md-9 pull-left">
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

<div id="forgetpas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="">
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

