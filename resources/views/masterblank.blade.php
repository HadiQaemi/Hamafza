<!DOCTYPE html>
<html ng-app="hamafza" lang="fa-IR">

<head lang="fa-IR">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <!---------------**Meta**-------------->
    @include('sections.meta')

    @if(Config::get('constants.Addstyle')!='')
        <link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/Content/css/{{Config::get('constants.Addstyle')}}"/>
    @endif

<!---------------**Main Style**-------------->
    @include('sections.main_style')
    @yield('after_main_style')

<!---------------**Specific Plugin Style**-------------->
    @yield('specific_plugin_style')

<!---------------**Inline Style**-------------->
    @yield('inline_style')

<!---------------**Main Scripts**-------------->
    @include('sections.main_scripts')
    @yield('after_main_scripts')
</head>

<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style=" position: fixed;width: 100%;">
<div hmfz-main-header="">
    <nav id="header" class="navbar navbar-default">
        <div class="container-fluid">
            <input type="hidden" id="_Alltoken" name="_Alltoken" value="{{ csrf_token()}}"/>
            <script>
                var token = $("#_Alltoken").val();
            </script>
            @include('sections.menu')
            @include('sections.loginregister')
        </div>
    </nav>
</div>
<div id="main">
    <!-- New HTMl -->
    <div id="scrollReset">
        <a href="#" class="up glyphicon glyphicon-chevron-up"></a>
        <a href="#" class="down glyphicon glyphicon-chevron-down"></a>
    </div>
    <!--End New HTMl -->
    <div hmfz-ui-view="">
        <!-- start of Main Template -->
        <div hmfz-tmplt-thm-clr="theme-darkblue" hmfz-tmplt-cntnt="">
            <div class="toolbarContainer">
                <div id="toolbar">
                    <div class="pull-right right-detail col-md-10">
                        <h1>{!!$Title!!}</h1>
                    <!--<h2><a style="color: white;" href="{{App::make('url')->to('/')}}/{{$pid}}">{{$Title}}</a></h2>-->
                        <!--<small>آخرین بروز رسانی  ۲۰ فروردین ۱۳۹۰</small>-->
                    </div>
                    <div class="clearfix"></div>
                    <div class="toolbar_border"></div>
                    {{--@include('sections.tools')--}}
                </div>
                <div class="activty-box"></div>
                @include('sections.comment')
            </div>
            <div id="mainContainer">
                <div class="dsply-tbl">
                    <div class="dsply-tbl-rw">
                        <div class="right-menu dsply-tbl-cl">
                            <ul class="menu">
                                @yield('tabs')
                            </ul>
                            <!--                                    <div class="bottom">
                                                                    <strong>28</strong>
                                                                    <div>فرد برخط</div>
                                                                </div>-->
                        </div>
                        <div hmfz-pg-tb="" class="next-container dsply-tbl-cl">
                            <div hmfz-pg-tb-cntnt="" class="row">
                                <div class="scrl-bx" id="vrScroll">
                                    <div class="col-md-3 scrl">
                                        <div class="scrl-2 small col-md-12">
                                            @yield('Tree')
                                        </div>
                                    </div>
                                    <div class="col-md-9 scrl" id="Tdxcre">
                                        <div class="scrl-2  big col-md-12">
                                            @yield('content')
                                            <br>
                                            <div class="panel panel-light fix-box">
                                                @yield('content2')
                                                @yield('keywords')
                                            </div>
                                            @yield('Files')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.dsply-tbl-rw -->
            </div><!-- /.display-table -->
            <!--Right Menu  -->
            @if(isset($tools_menu))
            {!! $tools_menu !!}
            @else
            {!!   toolsGenerator([1=>['sid'=>4260,'p'=>1],2,3,4,5,6,7,8,9],1,4) !!}
            @endif
        </div>
    </div>
    <!-- end of Main Template -->
</div>

<!---------------**Specific Plugin Scripts**-------------->
@yield('specific_plugin_scripts')

<!---------------**Inline Scripts**-------------->
@yield('inline_scripts')

<script>
    var pageheight = $(window).height();
    var dcrl2 = pageheight;
    $("#Tdxcre").height(dcrl2 - 150);
    $(".two").height(dcrl2);
    $(".small").height(dcrl2 - 200);
</script>

@if(Session::get('message')!='')
    <script>
        jQuery.noticeAdd({
            text: '{{ Session::get('message') }}',
            stay: false,
            type: '{{ Session::get("mestype") }}'
        });
        @if (Session::get('message') == 'کاربر ناشناس')
            window.location = "{{App::make('url')->to('/')}}/Logout";
        @endif
    </script>
@endif
@yield('modal_content')
</body>
</html>