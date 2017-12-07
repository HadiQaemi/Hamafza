<!DOCTYPE html>
<html ng-app="hamafza" lang="fa-IR" class="banader">
<head lang="fa-IR">
    @php($csrf = csrf_token())
    <meta name="csrf-token" content="{{$csrf}}">
    <!---------------**Meta**-------------->
    @include('layouts.helpers.common.sections.meta')

    @if(Config::get('constants.Addstyle')!='')
        <link rel="stylesheet" href="{{url('/theme/Content/css/'.Config::get('constants.Addstyle'))}}"/>
    @endif

<!---------------**Main Style**-------------->
    @include('layouts.helpers.common.assets.style.main_style')
    @yield('after_main_style')
<!---------------**Specific Plugin Style**-------------->
    @yield('specific_plugin_style')
    {!! index_view_style(config('constants.IndexView')) !!}
<!---------------**Inline Style**-------------->
    @yield('inline_style')
<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @yield('after_main_scripts')
</head>
<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style=" position: fixed;width: 100%;">
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <div hmfz-main-header="">
        <nav id="header" class="navbar navbar-default">
            <div class="container-fluid">
                @include('layouts.helpers.common.sections.helpers.nav_bar.menu')
                @include('layouts.helpers.common.sections.nav_bar')
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
                        @if(isset($Title))
                            <div class="pull-right right-detail col-md-10">
                                <h1>{!!$Title!!}</h1>
                            </div>
                        @endif
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
                                    @yield('tabs')
                                </ul>
                                @if(isset($Onlines))
                                    <div class="bottom">
                                        <strong>{!! $Onlines !!}</strong>
                                        <div>فرد برخط</div>
                                    </div>
                                @endif
                            </div>
                            <div hmfz-pg-tb="" class="next-container dsply-tbl-cl">
                                <div hmfz-pg-tb-cntnt="" class="row">
                                    <div class="scrl-bx" id="vrScroll">
                                        @if(View::hasSection('position_right_col_3') || View::hasSection('Tree'))
                                            <div class="col-md-3 scrl">
                                                <div id="pcol_3" class="scrl-22 mCustomScrollbar col-md-12" data-mcs-theme="minimal-dark" style="direction: ltr">
                                                    <div style="direction: rtl">
                                                        @yield('position_right_col_3')
                                                        @yield('Tree')
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 scrl" id="Tdxcre">
                                                @else
                                                    <div class="col-md-12 scrl" id="Tdxcre">
                                                        <div style="direction: rtl">
                                                            @endif
                                                            <div class="scrl-2  scrlbig col-md-12" data-mcs-theme="minimal-dark" style="direction: ltr">
                                                                <div style="direction: rtl;" id="master_inner_rtl_div" >
                                                                    <div class="panel panel-light fix-box" style="height: 100%;">
                                                                        <button class="ful-scrn">
                                                                            <span class="glyphicon glyphicon-fullscreen"></span>
                                                                        </button>
                                                                        <div class="fix-inr" style="height: 100%;">
                                                                            <div style="padding: 0;" class="panel-heading panel-heading-darkblue WallTop"></div>
                                                                            <div class="messageBox" style="margin: 10px;"></div>
                                                                            @include('hamahang.master.alert')
                                                                            @include('hamahang.master.confirm')
                                                                            @include('hamahang.master.loading')
                                                                            @yield('content')
                                                                            @yield('content2')
                                                                            @yield('keywords')
                                                                        </div>
                                                                    </div>
                                                                    @yield('Files')
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                    </div>
                                </div>
                            </div><!-- /.dsply-tbl-rw -->
                            <!--Right Menu  -->
                            @include('sections.tools_menu')
                        </div><!-- /.display-table -->
                    </div>
                </div>
                <!-- end of Main Template -->
            </div>

            <script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
            <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
            <script type="text/javascript" src="{{URL::to('assets/Packages/js_tree/dist/jstree.min.js')}}"></script>
            <!---------------**Specific Plugin Scripts**-------------->
        @yield('specific_plugin_scripts')
        @include('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_global_js')
        <!---------------**Inline Scripts**-------------->
            @yield('inline_scripts')

            <script>
                var pageheight = $(window).height();
                var dcrl2 = pageheight;
                //$("#Tdxcre").height(dcrl2 - 140);
                //console.log('page_height = '+dcrl2);
                //    $("#Tdxcre").height(dcrl2 - 150);
                $(".two").height(dcrl2);
                //    $(".small").height(dcrl2 - 200);
                $("#pcol_3").height(dcrl2 - 180);

                $(window).ready(function () {
                    resize_init();
                    window.onresize = resize_init();
                });

                $(document).on('click', ".task_info", function () {
                    show_task_info($(this).data("t_id"));
                });

                $(document).on('click', ".project_info", function () {
                    show_project_info($(this).data("p_id"));
                });

                function resize_init() {
                    window.pageheight = $(window).height();
                    window.dcrl2 = pageheight;
                    $("#Tdxcre").height(window.dcrl2 - 140);
                    //console.log('Tdxcre = '+(window.dcrl2 - 140));
                    var footer_height = $(".footer_task").height();
                    var header_height = $(".header_task").height();
                    var tdx_height = $("#Tdxcre").height();
                    //var nav_height=$("#header").height();
                    var toolbar_height = $(".toolbarContainer").height();
                    var div_title = ($('.div_title_not_started').height());
                    var height_task = tdx_height - (footer_height + header_height + div_title + 70);
                    console.log(height_task);
                    $(".div_groups_task").css('height', height_task + 'px');
                }

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
            @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
            <script type="text/javascript" src="{{URL::asset('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
        </div>
    </div>
</div>
</body>
</html>