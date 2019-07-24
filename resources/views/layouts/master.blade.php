@if(Request::exists('link_type'))
    @php($csrf = csrf_token())
    <div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
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

                <!---------------**Specific Plugin Scripts**-------------->
            <!---------------**Inline Scripts**-------------->
                @yield('inline_scripts')




                @yield('modal_content')
            </div>
        </div>
    </div>
@else
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
                            @if (auth()->check())<span style="font-size: 20px;">{{ config('constants.SiteFullTitle') }}</span>@endif
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
                                    <h1>{!! $Title !!}</h1>
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
                    //add by hadi
                    $(document).on('click', '.saveSessionUserEvent', function () {
                        var do_again = $(this).attr('do_type');
                        var saveObj = {};
                        var cid = 0;
                        var form_id = 'sessionForm';
                        //console.log(document.forms[form_id].getElementsByTagName("cid"));
                        // console.log('#' + form_id + ' select[name="cid"]');
                        //console.log($('#' + form_id + ' select[name="cid"]').val());
                        saveObj.htitle = $('#' + form_id + ' input[name="title"]').val();
                        saveObj.event_type = $('#' + form_id + ' input[name="event_type"]').val();
                        saveObj.agendas = $('#' + form_id + ' .agendas').map(function(){return $(this).val()}).get();
                        saveObj.description = $('#' + form_id + ' textarea[name="descriotion"]').val();
                        saveObj.hstartdate = $('#' + form_id + ' input[name="startdate"]').val();
                        saveObj.starttime = $('#' + form_id + ' input[name="starttime"]').val();
                        saveObj.henddate = $('#' + form_id + ' input[name="enddate"]').val();
                        saveObj.endtime = $('#' + form_id + ' input[name="endtime"]').val();
                        saveObj.term = $('#' + form_id + ' input[name="term"]').val();
                        saveObj.hlocation = $('#' + form_id + ' input[name="location"]').val();
                        saveObj.hcid = $('#' + form_id + ' select[name="cid"]').val();
                        saveObj.session_pages = $('#' + form_id + ' select[name="new_session_pages[]"]').val();
                        saveObj.keywords = $('#' + form_id + ' select[name="keywords[]"]').val();


                        ///////////////////////////////////////////////
                        if ($('#' + form_id + ' input[type="checkbox"][name="allDay"]').is(':checked')) {
                            saveObj.allDay = 1;
                        }
                        else {
                            saveObj.allDay = 0;
                        }

                        if ($('#' + form_id + ' input[name="event_id"]').length && $('#' + form_id + ' input[name="event_id"]').val() > 0) {
                            saveObj.mode = 'edit';
                            saveObj.event_id = $('#' + form_id + ' input[name="event_id"]').val();
                            saveObj.type = $('#' + form_id + ' input[name="type"]').val();
                        }
                        saveObj.mode = 'calendar';
                        var errorMsg_id = 'sessionMsgBox';
                        ///////////////////////////////////////////////
                        // Session Data
                        // sessionObj = {};
                        saveObj.hagenda = $('#' + form_id + ' #agenda').val();
                        saveObj.session_color = $('#' + form_id + ' input[name="session_color"]').val();
                        saveObj.action_duration_act = $('#' + form_id + ' #action_duration_act').val();
                        saveObj.action_duration_act_type = $('#' + form_id + ' #action_duration_act_type').val();
                        saveObj.session_chief = $('#' + form_id + ' select[name="session_chief"]').select().val();
                        saveObj.session_secretary = $('#' + form_id + ' select[name="session_secretary"]').select().val();
                        saveObj.session_facilitator = $('#' + form_id + ' select[name="session_facilitator"]').val();
                        saveObj.session_voting_users = $('#' + form_id + ' select[name="session_voting_users[]"]').val();
                        saveObj.session_notvoting_users = $('#' + form_id + ' select[name="session_notvoting_users[]"]').val();
                        saveObj.save_type = $('input[name="new_session_save_type"]').val();
                        saveObj.long = $('#' + form_id + ' input[name="long"]').val();
                        saveObj.lat = $('#' + form_id + ' input[name="lat"]').val();
                        saveObj.type = $('#' + form_id + ' input[name="session_type"]:checked').val();
                        saveObj.location_phone = $('#' + form_id + ' input[name="location_phone"]').val();
                        saveObj.coordination_phone = $('#' + form_id + ' input[name="coordination_phone"]').val();
                        // saveObj.hevent_id = result.event.id;
                        saveObj.mode = $('input[name="mode"]').val();
                        if ($('input[name="sid"]').length) {
                            saveObj.sid = $('input[name="sid"]').val();
                        }
                        if ($('input[type="checkbox"][name="send_Invitation"]').is(':checked')) {
                            saveObj.send_Invitation = 1;
                        }
                        else {
                            saveObj.send_Invitation = 0;
                        }
                        if ($('input[type="checkbox"][name="create_session_page"]').is(':checked')) {
                            saveObj.create_session_page = 1;
                        }
                        else {
                            saveObj.create_session_page = 0;
                        }
                        if ($('input[type="checkbox"][name="allow_inform_invitees"]').is(':checked')) {
                            saveObj.allow_inform_invitees = 1;
                        }
                        else {
                            saveObj.allow_inform_invitees = 0;
                        }
                        // console.log(saveObj);

                        var res = '';
                        $.ajax({
                            url: '{{ URL::route('hamahang.calendar_events.save_session_event')}}',
                            type: 'POST', // Send post dat
                            data: saveObj,
                            async: false,
                            success: function (s) {
                                res = JSON.parse(s);
                                if (res.success == false) {
                                    $('#' + errorMsg_id).empty();
                                    errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, {id: errorMsg_id}, form_id);
                                    // $('#' + errorMsg_id).html(warning);
                                } else {
                                    // console.log(res);
                                    //eventInfo = JSON.parse(res.event);
                                    eventInfo = res.event;

                                    if(do_again=='close-form')
                                    {
                                        $('.jsPanel-btn-close').click();

                                    }else{
                                        $('.sessionForm input').val('');
                                    }

                                    var html = '{{trans("calendar.calendar_saveSession_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';
                                    {{--messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', html);--}}
                                    {{--messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', '{!! trans("calendar.calendar_saveSession_success") !!}');--}}
                                }
                            }
                        });
                        // return res;
                        //  console.log(result);return;
                        // if (result.success == true) {
                        /*
                        by hadi
                        var result = saveEvent('sessionForm', 'sessionMsgBox');
                        var modal_btn = [
                            {
                                item: '' +
                                '<div >' +
                                '   <button type="button" name="saveSession" id="saveSession" value="save" class="btn btn-info" type="button">' +
                                '       <i class="glyphicon  glyphicon-save-file bigger-125"></i>' +
                                '       <span>{trans('app.save')}}</span>' +
                                '   </button>' +
                                '</div>'
                            }
                        ];
                        sessionModal.toolbarAdd("footer", modal_btn);
                        $('#saveSessionUserEvent').remove();
                        navigationWizard();
                        $('#sessionMsgBox').html('');
                        $('textarea[name="location"]').append('<input type="hidden" name="event_id" value="' + result.event.id + '">');
                        $('textarea[name="location"]').append('<input type="hidden" name="mode" value="calendar">');
                        $('#form-event-content').hide();
                        $('#form-session-content').show();
                        */
                        // }
                    });
                    //comment by hadi
                    $(document).on('click', '#btn_save_task_image', function () {
                        var formElement = $( '.id_input_files' )[0].files[0];
                        var data = new FormData();
                        data.append('image',formElement);
                        data.append('pid','{{rand(1,100).rand(1,100)}}');
                        data.append('form_type','form');
                        $this = $(this);
                        $.ajax
                        ({
                            url: '{{ route('FileManager.tinymce_external_filemanager') }}',
                            type: 'post',
                            dataType: 'json',
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function(data)
                            {
                                if (data.success)
                                {
                                    $('#desc').val($('#desc').val() + "\nimg::" + data.FileID + "::img");
                                    $('.content_tab_view').html($('#desc').val().replace('img::','<img src="{{route('FileManager.DownloadFile',['type'=> 'ID','id'=>'']).'/'}}').replace('::img','">'));
                                    $('#'+$this.parents(".jsPanel").attr('id') + ' .jsPanel-btn-close').click();
                                } else
                                {
                                    messageModal('fail', 'خطا', data.result);
                                }
                            }
                        });
                    });
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
                                // console.log(result);
                                // result = JSON.parse(result);
                                if (result.success == true) {
                                    if (again == 1) {
                                        ResetForm();
                                    }
                                    else {
                                        $('.jsPanel-btn-close').click();
                                    }
                                    // if(window.table_chart_grid2 != undefined){
                                        window.table_chart_grid2.ajax.reload();
                                    // }
                                    // if(window.table_chart_grid3 != undefined){
                                        window.table_chart_grid3.ajax.reload();
                                    // }
                                    eventInfo = (result.event);
                                    // (function ($) {
                                    //     $("#calendar").fullCalendar('addEventSource', [{
                                    //         start: eventInfo.startdate,
                                    //         end: eventInfo.enddate,
                                    //         title: eventInfo.title,
                                    //         color: eventInfo.bgColor,
                                    //         block: true
                                    //     }]);
                                    // })(jQuery_2);
                                }
                                else {
                                    messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                                }
                            }
                        });
                    }
                    function UpdateTasks(form_id, again,action) {
                        //console.log(form_id);
                        $('#task_form_action').val(action);
                        $('#save_type').val(1);
                        var form_data = $('#' + form_id).serialize();
                        // console.log(form_data);
                        // alert($('input[name="show_task_save_type"]').val());
                        $.ajax({
                            type: "POST",
                            url: '{{ route('hamahang.tasks.update_task')}}',
                            dataType: "json",
                            data: form_data,
                            success: function (result) {
                                if (result.success == true) {
                                    $('.jsPanel-btn-close').click();
                                    {{--messageModal('success','{{trans('tasks.edit_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
                                    if(window.table_chart_grid2 != undefined){
                                        window.table_chart_grid2.ajax.reload();
                                    }
                                    if(window.table_chart_grid3 != undefined){
                                        window.table_chart_grid3.ajax.reload();
                                    }
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
                                        if(window.table_chart_grid2 != undefined){
                                            window.table_chart_grid2.ajax.reload();
                                        }
                                        if(window.table_chart_grid3 != undefined){
                                            window.table_chart_grid3.ajax.reload();
                                        }
                                    }
                                    {{--messageModal('success','{{trans('tasks.edit_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
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
                                        if(window.table_chart_grid2 != undefined){
                                            window.table_chart_grid2.ajax.reload();
                                        }
                                        if(window.table_chart_grid3 != undefined){
                                            window.table_chart_grid3.ajax.reload();
                                        }
                                    }
                                    {{--messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
                                }
                                else {
                                    messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                                }
                            }
                        });
                    }
                    // $(document).on('click', '.dropdown-menu a', function (e) {
                    //     var modalContentUrl = $(this).attr('hrefhref');
                    //     $.ajax({
                    //         type: "GET",
                    //         async: false,
                    //         url: '/'+modalContentUrl,
                    //         data: {'link_type':'new_method'},
                    //         success: function(msg){
                    //             $('#Tdxcre2').html(msg);
                    //             $('#Tdxcre2 .toolbarContainer ').css('display','none');
                    //             $('#Tdxcre2 #header').css('display','none');
                    //             $('#Tdxcre2 .right-menu').css('display','none');
                    //             $('#Tdxcre2 #vrScroll2 .noPadding.background-white').css('display','none');
                    //             $('#Tdxcre2 #mainContainer').css('margin-top','-90px');
                    //         },
                    //     });
                    // });
                    // $('#Fehresrt a').click(function (e) {
                    //     alert($(this).attr('href'));
                    //     e.preventDefault();
                    //     return false;
                    //     $('div.dropdown-menu').click(function (event) {
                    //         $('#Tdxcre2').html('asdasd');
                    //     });
                    //
                    //     $.ajax({
                    //         type: "POST",
                    //         async: false,
                    //         url: modalContentUrl,
                    //         data: {},
                    //         success: function(msg){
                    //             console.log(msg);
                    //             $('#modal .modal-body').html(msg);
                    //         },
                    //     });
                    //
                    // });
                    $(document).on('click', '.all_btn', function () {
                        var $this = $(this);
                        var is_apply = $this.data('apply');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('hamahang.subjects.update') }}",
                            dataType: 'json',
                            data: $('#form_subject_omomi').serialize(),
                            success: function (data) {
                                if (data.success == false) {
                                    messageBox('error', '', data.error.subject_title, {'id': 'alert_setting_omomi'});
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('hamafza.update_relations') }}",
                                        dataType: 'json',
                                        data: $('#form_subject_ravabet').serialize(),
                                        success: function (theResponse) {
                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('hamafza.update_access') }}",
                                                dataType: 'json',
                                                data: $('#manager_form').serialize(),
                                                success: function (theResponse) {
                                                    $.ajax
                                                    ({
                                                        url: '{{ route('modals.help.relation.add') }}',
                                                        type: 'post',
                                                        data: data,
                                                        dataType: 'json',
                                                        success: function(response)
                                                        {
                                                            jQuery.noticeAdd({
                                                                text: 'تغییرات با موفقیت انجام شد',
                                                                stay: false,
                                                                type: 'success'
                                                            });
                                                            jQuery.noticeAdd({type: response[0], text: response[1], stay: false});
                                                            $('.jsglyph-close').click();
                                                            // location.reload();
                                                            return false;

                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                    /*messageBox('success', '', data,{'id': 'alert_setting_omomi'},'hide_modal');*/
//                    $('.jsglyph-close').click();
                                }
                            }
                        });
                    });
                    $(document).on('click', '#DiagramOptionsBtn', function () {
                        var $this = $(this);
                        var is_apply = $this.data('apply');
                        $.ajax({
                            type: "POST",
                            url: "{{ route('hamahang.diagram.save_diagram') }}",
                            dataType: 'json',
                            data: $('#digram_form').serialize(),
                            success: function (data) {
                                if (data.success == false) {
                                    messageBox('error', '', data.error.subject_title, {'id': 'alert_setting_omomi'});
                                }else{
                                    $('.jsPanel-btn-close').click();
                                    window.table_diagram.ajax.reload();
                                }
                            }
                        });
                    });
                    $(document).on('click', '.change-score-btn', function () {
                        $this = $(this);
                        var form_id = $this.data('form_id');
                        var form_data = $('#' + form_id).serialize();
                        $.ajax({
                            type: "POST",
                            url: '{{ route('hamahang.org_chart.set_score')}}',
                            dataType: "json",
                            data: form_data,
                            success: function (result) {
                                console.log(result);
                                if (result.success == true) {
                                    $('.jsPanel-btn-close').click();
                                    // $('.' + result.item + '.job_' + result.job_id).val(result.score);
                                    organs_wages_grid();
                                    {{--messageModal('success','{{trans('tasks.edit_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}

                                }
                                else {
                                    messageModal('error', '{{trans('app.operation_is_failed')}}', result.error);
                                }
                            }
                        });
                    });

                    $(document).on('click', '.update_task', function () {
                        var save_type = $("input[name='show_task_save_type']:checked").val();
                        $('#save_type').val(save_type);
                        var $this = $(this);
                        var form_id = $this.data('form_id');
                        var save_again = $this.data('again_save');
                        UpdateTasks(form_id, save_again,1);

                        if(window.table_chart_grid2 != undefined){
                            window.table_chart_grid2.ajax.reload();
                        }
                        if(window.table_chart_grid3 != undefined){
                            window.table_chart_grid3.ajax.reload();
                        }
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
                            {{--else--}}
                            {{--alert('{{ trans('tasks.the_save_type_is_not_selected') }}');--}}
                        }
                        $(".tab-content.new-task-form").animate({
                            scrollTop: 0
                        }, 500);
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
                            {{--alert('{{ trans('tasks.the_save_type_is_not_selected') }}');--}}
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
                                    if(window.table_chart_grid2 != undefined){
                                        window.table_chart_grid2.ajax.reload();
                                    }
                                    if(window.table_chart_grid3 != undefined){
                                        window.table_chart_grid3.ajax.reload();
                                    }
                                    $('.jsPanel-btn-close').click();
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
@endif
