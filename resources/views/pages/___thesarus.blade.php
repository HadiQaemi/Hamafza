<html ng-app="hamafza">
    <head lang="en">
        @include('sections.header')
        <link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/thesarus.css" />
        <link rel='stylesheet' href="{{App::make('url')->to('/')}}/theme/Content/css/treemenu.css" type='text/css' />
        <link rel='stylesheet' href="{{App::make('url')->to('/')}}/theme/Content/css/vis.css" type='text/css' />
        <link rel='stylesheet' href="{{App::make('url')->to('/')}}/theme/Content/css/daneshnameh.css" type='text/css' />
        <link href="{{App::make('url')->to('/')}}/theme/Content/css/textassist.css" rel="stylesheet" type="text/css"/>
        <script src="{{App::make('url')->to('/')}}/theme/Scripts/textassist.js" type="text/javascript"></script>
        <script src="{{App::make('url')->to('/')}}/theme/Scripts/vis.js"></script>
        <script src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.js"></script>
        @include('scripts.publicpages')
    </head>
    <body dir="rtl" class="mstr-clr" hmfz-ui-thm="">
        <div hmfz-main-header="">
            <nav id="header" class="navbar navbar-default">
                <div class="container-fluid">
                    @include('sections.menu')
                    @include('sections.loginregister')
                </div>
            </nav>
        </div>
        <div id="main">
            <div hmfz-ui-view="">
                <!-- start of Main Template -->
                <div hmfz-tmplt-thm-clr="" hmfz-tmplt-cntnt="">
                    <div hmfz-tmplt-thm-clr="theme-gold" hmfz-tmplt-cntnt="">
                        <div class="toolbarContainer">
                            <div id="toolbar">
                                <div class="pull-right right-detail">
                                    <h1>{{$Title}}</h1>
                                    <!--<small>آخرین بروز رسانی  ۲۰ فروردین ۱۳۹۰</small>-->
                                </div>
                                <div class="clearfix"></div>
                                <div class="toolbar_border"></div>
                                @include('sections.tools')
                            </div>
                            <div class="activty-box"></div>
                            @include('sections.comment') 

                        </div>
                        <div id="mainContainer">
                            <div class="dsply-tbl">
                                <div class="dsply-tbl-rw">
                                    <div class="right-menu dsply-tbl-cl">
                                        <ul class="menu">
                                            @if (is_array($tabs))
                                            @foreach($tabs as $item)
                                            @if (trim($item['link']) === trim($pid))
                                            <li class="active"><a href="{{App::make('url')->to('/')}}/{{ $item['href']}}">{{ $item['title']}}</a></li>
                                            @else
                                            <li><a href="{{App::make('url')->to('/')}}/{{ $item['href']}}">{{ $item['title']}}</a></li>
                                            @endif
                                            @endforeach
                                            @endif
                                        </ul>
                                        <div class="bottom">
<!--                                            <strong>28</strong>
                                            <div>فرد برخط</div>-->
                                        </div>
                                    </div>
                                    <div hmfz-pg-tb="" class="next-container dsply-tbl-cl">
                                        <div hmfz-pg-tb-cntnt="" class="row">
                                            <div class="scrl-bx">
                                                <div class="col-md-3 scrl">
                                                    <div class="scrl-2 small col-md-12">
                                                        @include('sections.rightcol')
                                                    </div>
                                                </div>
                                                <div class="col-md-9 scrl">
                                                    <div class="col-md-8 big scrl-2 two">

                                                        <div class="panel panel-light fix-box">
                                                            <button class="ful-scrn">
                                                                <span class="glyphicon glyphicon-fullscreen"></span>
                                                            </button>
                                                            <div class="fix-inr">
                                                                <div style="padding: 0;" class="panel-heading panel-heading-gold"></div>
                                                                <div class='text-content'>
                                                                    {{$content}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 scrl-3">
                                                        <div class="panel panel-light fix-box">
                                                            <button class="ful-scrn">
                                                                <span class="glyphicon glyphicon-fullscreen"></span>
                                                            </button>
                                                            <div class="fix-inr">
                                                                <div style="padding: 0;" class="panel-heading panel-heading-gold"></div>
                                                                <div id="KeywordDetails" class="panel-body text-decoration"></div>
                                                                <div id="mynetwork"></div>
                                                            </div>
                                                            <div class="row" id="ThesBut" Style="margin: 10px;display: none;">
                                                                @if($allowdeltag)
                                                                <div class="col-md-4">
                                                                    <a onclick="DelKeys(this)" class="btn btn-primary ThesBut" keyid="">حذف</a>
                                                                </div>
                                                                @endif
                                                                @if($allowedittag)
                                                                <div class="col-md-4">
                                                                    <a id="EditKeybut" title="ویرایش کلیدواژه" class="btn btn-primary ThesBut jsPanels" keyid="">ویرایش</a>
                                                                </div>
                                                                @endif
                                                                @if($allowedittag)
                                                                <div class="col-md-4">
                                                                    <a id="MergeKeyBut"  title="ادغام کلیدواژه" class="btn btn-primary ThesBut jsPanels" keyid="">ادغام</a>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.dsply-tbl-rw -->
                            </div><!-- /.display-table -->
                            @include('sections.toolsmenu')              
                            <!--Right Menu  -->
                        </div>
                    </div>
                </div>
                <!-- end of Main Template -->
            </div>
            <div class="clearfix"></div>

        </div>
        @if(Session::get('message')!='')       
        <script>
            jQuery.noticeAdd({
                text: '{{ Session::get('message') }}',
                stay: false,
                type: '{{ Session::get("mestype") }}'
            });
        </script>
        @endif

        <script>


            function DelKeys(e) {
                id = $(e).attr("keyid");
                if (id != '') {
                    var r = confirm("آیا مایل به حذف کلید واژه هستید؟\n\
در صورت حذف کلیه ارتباط ها نیز حذف می شود");
                    if (r == true) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('hamafza.keyword_delete') }}',
                            dataType: 'html',
                            data: ({keyid: id}),
                            success: function(theResponse) {
                                jQuery.noticeAdd({
                                    text: theResponse,
                                    stay: false,
                                    type: 'success'
                                });
                            }
                        });
                    } else {
                        txt = "You pressed Cancel!";
                    }
                }
            }
            function loadKeyDet(id) {
                if (id == '')
                    alert("محتوا خالی است");
                else {
                    $("#KeywordDetails").html("");
                    $("#mynetwork").html("");
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamafza.key_rel') }}',
                        dataType: 'html',
                        data: ({keyid: id}),
                        success: function(theResponse) {
                            var obj = JSON.parse(theResponse);
                            res = obj.table;
                            res2 = obj.keywords;
                            res3 = obj.relations;
                            $("#KeywordDetails").html(res);
                            startNetwork(res2, res3);
                            $("#EditKeybut").attr("href", "{{App::make('url')->to('/')}}/modals/editkeyword?sid=" + id);

                            $("#MergeKeyBut").attr("href", "{{App::make('url')->to('/')}}/modals/mergkeyword?sid=" + id);
                            $("#ThesBut").show();
                            $(".ThesBut").attr("keyid", id);
                        }
                    });
                }
            }
            function startNetwork(res20, res30) {
                var options = {
                    autoResize: true,
                }
                var container = document.getElementById('mynetwork');
                var data = {
                    nodes: res20,
                    edges: res30
                };
                network = new vis.Network(container, data, options);
            }
        </script>
    </body>
</html>