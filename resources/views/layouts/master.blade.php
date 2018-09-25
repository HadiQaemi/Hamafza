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
    <style>
        #vrScroll2 .scrl{
            height: 85vh;
            overflow: auto;
            margin-bottom: 50px;
        }
        #vrScroll2 .scrl{
            direction: ltr;
        }
        #vrScroll2 .scrl::-webkit-scrollbar {
            width: 5px;
            direction: rtl;
        }

        #vrScroll2 .scrl::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        }

        #vrScroll2 .scrl::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
        }
    </style>
<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @yield('after_main_scripts')
<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125470180-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-125470180-1');
    </script>
</head>
<body dir="rtl" class="mstr-clr responsive-theme" hmfz-ui-thm="" style=" position: fixed;width: 100%;">
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <div hmfz-main-header="">
        @if ('kmkz' == config('constants.IndexView'))
            <style>#header { background-color: #367BAB; }</style>
        @endif
        <nav id="header" class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header navbar-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    {{--<img src="file:///C:/Users/soft/Desktop/hamafza%20960616/img/logo.png" style="float: right; margin-top: 2%; margin-right: 3px">--}}
                    {{--<a class="navbar-brand" href="#" style="float: right;font-size: 1.9em;height: 48px;color: #FFF !important;">هم افزا</a>--}}
                    <a class="navbar-brand rtl-brand" href="{{App::make('url')->to('/')}}" style="padding: inherit !important; height: 47px!important;">
                        @if (auth()->check())<span style="font-size: 10px;">{{ config('constants.SiteFullTitle') }}</span>@endif
                        <img class="logo" src="{{App::make('url')->to('/')}}/{{ config('constants.SiteLogo') }}">
                        @if(isset($Title))
                            <span class="hidden-lg hidden-md hidden-sm" style="font-size: 8px;">{{mb_substr($Title,0,30, "utf-8").'...'}}</span>
                        @endif
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    @if (auth()->check())
                        <ul class="nav navbar-nav navbar-right quick-links-res" style="margin-right: 15px">
                            {!! menuGenerator(3, 'horizontal') !!}
                        </ul>
                    @else
                        <ul class="nav navbar-nav quick-links quick-links-res hidden-sm hidden-md hidden-lg">
                            <li href="#tab2" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">درگاه‌ها</span></a></li>
                            <li href="#tab3" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">کلید واژه‌ها</span></a></li>
                            <li href="#tab4" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">جستجو</span></a></li>
                        </ul>
                        <ul class="nav navbar-nav quick-links-res hidden-lg hidden-md hidden-sm" style="margin-top: 15px;">
                            <li href="#tab2" class="res-li">
                                <a class="register res-a" data-toggle="modal" data-target="#register">ثبت نام</a>
                            </li>
                            <li href="#tab2" class="res-li">
                                <a class="login res-a" data-toggle="modal" data-target="#login">ورود</a>
                            </li>
                        </ul>
                    @endif
                    <ul class="nav navbar-nav navbar-left">
                        @include('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar')
                    </ul>
                </div>
            </div>
        </nav>
        @include('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_h_sid')
        {{--<nav id="header" class="navbar navbar-default">--}}
        {{--<div class="container-fluid">--}}
        {{--@include('layouts.helpers.common.sections.helpers.nav_bar.menu')--}}
        {{--@include('layouts.helpers.common.sections.nav_bar')--}}
        {{--</div>--}}
        {{--</nav>--}}
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
                <div class="toolbarContainer hidden-xs hidden-sm">
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
                        <div class="container-fullwidth hidden-lg hidden-md">
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs header-mobile">
                                    @yield('tabs')
                                </ul>
                            </div>
                        </div>
                        <div class="dsply-tbl-rw">
                            <div class="right-menu dsply-tbl-cl hidden-xs hidden-sm">
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

                            <div hmfz-pg-tb="" class="next-container dsply-tbl-cl" style="overflow: hidden">
                                <div hmfz-pg-tb-cntnt="" class="row row-hd margin-top-min-4">
                                    {{--<div class="scrl-bx" id="vrScroll" style="height: 90vh;width: 100%;overflow: scroll;">--}}
                                    <div class="" id="vrScroll2">
                                        @if(View::hasSection('position_right_col_3') || View::hasSection('Tree'))
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 scrl noPadding background-white">
                                                {{--<div id="pcol_3" class="scrl-22 mCustomScrollbar col-md-12" data-mcs-theme="minimal-dark" style="direction: ltr">--}}
                                                <div id="pcol_32" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hd-tree" data-mcs-theme="minimal-dark2" style="direction: rtl;">
                                                    <div style="direction: rtl">
                                                        @yield('position_right_col_3')
                                                        @yield('Tree')
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 scrl" id="Tdxcre">--}}
                                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="Tdxcre2">
                                        @else
                                                    {{--<div class="col-md-12 scrl" id="Tdxcre">--}}
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="Tdxcre2" style="">
                                                        <div style="direction: rtl">
                                        @endif
                                                            {{--<div class="scrl-2  scrlbig col-md-12" data-mcs-theme="minimal-dark" style="direction: ltr">--}}
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hd-body" data-mcs-theme="minimal-dark2" style="direction: rtl;width: 99.5%;padding-left: 0px;overflow-x: hidden;">
                                                                <div style="direction: rtl;" id="master_inner_rtl_div" >
                                                                    <div class="panel panel-light fix-box first-fix-box height-100" style="margin-bottom: 50px;">
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
				function SaveTask(form_id, again,action) {
					//console.log(form_id);
					$('#task_form_action').val(action);
					var form_data = $('#' + form_id).serialize();
					$.ajax({
						type: "POST",
						url: '{{ route('hamahang.tasks.save_task')}}',
						dataType: "json",
						data: form_data,
						success: function (result) {
							console.log(result);
                            // result = JSON.parse(result);
							if (result.success == true) {
								if (again == 1) {
									ResetForm();
								}
								else {
									$('.jsPanel-btn-close').click();
								}
								messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});
                                eventInfo = (result.event);
                                (function ($) {
                                    $("#calendar").fullCalendar('addEventSource', [{
                                        start: eventInfo.startdate,
                                        end: eventInfo.enddate,
                                        title: eventInfo.title,
                                        color: eventInfo.bgColor,
                                        block: true
                                    }]);
                                })(jQuery_2);
							}
							else {
								messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
							}
						}
					});
				}
                function UpdateTask(form_id, again,action) {
                    //console.log(form_id);
                    $('#task_form_action').val(action);
                    $('#save_type').val(1);
                    var form_data = $('#' + form_id).serialize();
                    console.log(form_data);
                    alert($('input[name="show_task_save_type"]').val());
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tasks.update_task')}}',
                        dataType: "json",
                        data: form_data,
                        success: function (result) {
                            if (result.success == true) {
                                $('.jsPanel-btn-close').click();
                                {{--messageModal('success','{{trans('tasks.edit_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
                            }
                            else {
                                messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                            }
                        }
                    });
                }
				function UpdateLibraryTask(form_id, again,action) {
					$('#task_form_action').val(action);
					var form_data = $('#' + form_id).serialize();
					$.ajax({
						type: "POST",
						url: '{{ route('hamahang.library.UpdateLibraryTask')}}',
						dataType: "json",
						data: form_data,
						success: function (result) {
							console.log(result);
							if (result.success == true) {
								if (again == 1) {
									ResetForm();
								}
								else {
									$('.jsPanel-btn-close').click();
								}
								messageModal('success','{{trans('tasks.edit_task')}}' , {0:'{{trans('app.operation_is_success')}}'});
							}
							else {
								messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
							}
						}
					});
				}
				function SaveInLibraryTask(form_id, again,action) {
					$('#task_form_action').val(action);
					var form_data = $('#' + form_id).serialize();
					$.ajax({
						type: "POST",
						url: '{{ route('hamahang.library.SaveToLibraryTask')}}',
						dataType: "json",
						data: form_data,
						success: function (result) {
							if (result.success == true) {
								if (again == 1) {
									ResetForm();
								}
								else {
									$('.jsPanel-btn-close').click();
								}
								{{--messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
							}
							else {
								messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
							}
						}
					});
				}
                $(document).on('click', '.update_task', function () {
                    var save_type = $("input[name='new_task_save_type']:checked").val();
                    $('#task_of_action').val('fffffffffffffff');
                    var $this = $(this);
                    var form_id = $this.data('form_id');
                    var form_id = $this.data('form_id');
                    var save_again = $this.data('again_save');

                    UpdateTask(form_id, save_again,1);
                });
				$(document).on('click', '.save_task', function () {
					var save_type = $("input[name='new_task_save_type']:checked").val() != undefined ? $("input[name='new_task_save_type']:checked").val() :
                        ($("input[name='show_task_save_type']:checked").val() != undefined ? $("input[name='show_task_save_type']:checked").val() :
                            ($("input[name='show_task_save_type_final']:checked").val() != undefined ? $("input[name='show_task_save_type_final']:checked").val() : '') );
                    var $this = $(this);
					var form_id = $this.data('form_id');
					var save_again = $this.data('again_save');
					if (save_type == 1) {
						SaveTask(form_id, save_again,1);
					}
					else if (save_type == 0) {
						SaveTask(form_id, save_again,0);
						//save_as_draft(form_id, save_again);
					}
                    else if (save_type == 2) {
					    if($("input[name='type']:checked").val()==1)
					    {
                            SaveInLibraryTask(form_id, save_again,'private');
                            // $('#PrivateLiberaryTable').DataTable().ajax.reload();
                        }else{
                            SaveInLibraryTask(form_id, save_again,'public');
                            // $('#GeneralLiberaryTable').DataTable().ajax.reload();
                        }
					}
                    else if (save_type == 3) {
                        SaveInLibraryTask(form_id, save_again,'private');
                    }
					else
					{
					    if($("input[name='show_task_save_type_final']:checked").val()==1)
                            SaveTask(form_id, save_again,0);
					    else
						    alert('{{ trans('tasks.the_save_type_is_not_selected') }}');
					}
				});
                $(document).on('change', '.liberary_task_save_type',function() {
                    if($("input[name='liberary_task_save_type']:checked").val()==2)
                    {
                        $('.edit_liberary_new_task').removeClass('hidden');
                        $('.save_task').addClass('hidden');
                    }else{
                        $('.edit_liberary_new_task').addClass('hidden');
                        $('.save_task').removeClass('hidden');
                    }

                });

                $(document).on('click', '.edit_liberary_new_task', function () {
                    var save_type = $("input[name='liberary_task_save_type']:checked").val();
                    var $this = $(this);
                    var form_id = $this.data('form_id');
                    var save_again = $this.data('again_save');
                    if (save_type == 1) {
                        SaveTask(form_id, save_again,1);
                    }
                    else if (save_type == 0) {
                        SaveTask(form_id, save_again,0);
                        //save_as_draft(form_id, save_again);
                    }
                    else if (save_type == 2) {
                        if($("input[name='type']:checked").val()==1)
                        {
                            SaveInLibraryTask(form_id, save_again,'private');
                            // $('#PrivateLiberaryTable').DataTable().ajax.reload();
                        }else{
                            SaveInLibraryTask(form_id, save_again,'public');
                            // $('#GeneralLiberaryTable').DataTable().ajax.reload();
                        }
                    }
                    else
                    {
                        alert('{{ trans('tasks.the_save_type_is_not_selected') }}');
                    }
                });
				function SetActToTask(form_id) {
                    //console.log(form_id);
                    var form_data = $('#' + form_id).serialize();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tasks.set_act_to_task')}}',
                        dataType: "json",
                        data: form_data,
                        success: function (result) {
                            console.log(result);
                            if (result.success == true) {
                                $('.jsPanel-btn-close').click();
                                messageModal('success','{{trans('tasks.submit_action')}}' , {0:'{{trans('app.operation_is_success')}}'});
                            }
                            else {
                                messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                            }
                        }
                    });
                }
				$(document).on('click', '.act_on_task', function () {
					var $this = $(this);
					var form_id = $this.data('form_id');
					SetActToTask(form_id);
				});
                if($(document).width() > 1000){
                    $('.hd-body').css('max-height','80vh');
                    $('.hd-body').css('overflow-y','auto');
                    $('.hd-tree').css('max-height','82vh');
                    $('.hd-tree').css('overflow-y','auto');
                    // $('.user-config').css('margin-left','-7px');
                    $('.logo').css('margin-right','20px !important');
                }else{
                    $('.row-hd').css('height','85vh');
                    $('.row-hd').css('overflow-y','auto');
                }
                $('.right-menu').css('height','100vh');
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
@yield('HFM_Form_JS')
</body>
</html>