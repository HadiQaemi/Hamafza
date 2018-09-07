<!DOCTYPE html>
<html ng-app="hamafza" class="@yield('html_class')">
<head lang="en">
    @php($csrf = csrf_token())
    <!---------------**Meta**-------------->
    <meta name="csrf-token" content="{{ $csrf}}">
    @include('layouts.helpers.common.sections.meta')

    <!---------------**Main Style**-------------->
    @include('layouts.helpers.common.assets.style.main_style')
    @include('layouts.homepages.helpers.general.assets.style.after_main_style')

    <!---------------**Specific Plugin Style**-------------->
    @include('layouts.homepages.helpers.general.assets.style.specific_plugin_style')

    <!---------------**Inline Style**-------------->
    @include('layouts.homepages.helpers.general.assets.style.inline_style')

    <!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
    @include('layouts.homepages.helpers.general.assets.script.after_main_scripts')
        <style>
            /* width */
            ::-webkit-scrollbar {
                width: 10px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #888;
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
</head>
<body dir="rtl" class="mstr-clr responsive-theme" hmfz-ui-thm="" style=" position: fixed;width: 100%;"><div id="slider2_container" class="daneshSlider shadowBox hidden" style="position: relative; top:0; left: 0; width: 790px; height: 340px; overflow: hidden;float:right; "></div>
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
                        @if (auth()->check())
                            <span style="font-size: 20px;">{{ config('constants.SiteFullTitle') }}</span>
                        @endif
                        <img class="logo" src="{{App::make('url')->to('/')}}/{{ config('constants.SiteLogo') }}">
                        @if(isset($Title))
                            <span class="hidden-lg hidden-md hidden-sm" style="font-size: 10px;">{{mb_substr($Title,0,50, "utf-8").'...'}}</span>
                        @endif
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">

                    @if (auth()->check())
                        <ul class="nav navbar-nav navbar-right quick-links-res" style="margin-right: 15px">
                            {!! menuGenerator(3, 'horizontal') !!}
                        </ul>
                    @else
                        {{--<ul class="nav navbar-nav navbar-right quick-links-res" style="margin-right: 15px">--}}
                            {{--{!! menuGenerator(3, 'horizontal') !!}--}}
                        {{--</ul>--}}
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
    <div id="main" style="overflow: auto;height: 100Vh;background: url(theme/general/img/main-bg.png) no-repeat center center fixed;">
        <!-- New HTMl -->
        {{--<div id="scrollReset">--}}
            {{--<a href="#" class="up glyphicon glyphicon-chevron-up"></a>--}}
            {{--<a href="#" class="down glyphicon glyphicon-chevron-down"></a>--}}
        {{--</div>--}}
        <!--End New HTMl -->

        <div hmfz-ui-view="">
            <!-- start of Main Template -->

        {{--@include('layouts.homepages.helpers.general.index_content')--}}
    {{--    @include('layouts.homepages.helpers.hamafza.index_content')--}}
        <!-- end of Main Template -->
            {{--@include('layouts.helpers.common.sections.footer_helper')--}}
            <div class="row col-xs-12 margin-top-50">
                <div class="col-xs-2"></div>
                    @if (auth()->check())
                        <div class="col-xs-3 margin-left-10">
                            @include('sections.homeright-general')
                        </div>
                    @else
                        <div class="col-xs-3 background-white margin-left-10">
                            <div class="homepage_login_div">
                                <div class="homepage_inner_login_div">
                                    <form id="homepage_form_login" name="form-login" class="form_login clearfix" method="post">
                                        {{ csrf_field() }}
                                        <div id="homepage_login_fail_request_errors" style="font-family: IranSharp; font-size: 12px; color: red; text-align: center; margin-bottom: 10px;"></div>
                                        <table style="width:100%;margin-top: 30px;">
                                            <tbody>
                                            <tr>
                                                <td style="padding: 2px;padding-left: 15px;">
                                                    <label style="padding-bottom: 10px;padding-top: 10px;">رایانامه یا نام کاربری</label>
                                                    <span style=""></span>
                                                    <div id="homepage_username_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                                                    <input type="text" name="username" id="username" autofocus="" class="form-control required" style="direction: ltr; font-family: Arial;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 2px;width:100%;padding-left: 15px;">
                                                    <label style="padding-bottom: 10px;padding-top: 10px;">رمز عبور</label>
                                                    <div id="homepage_password_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                                                    <input type="password" id="passwords" name="password" class="form-control required" style="direction: ltr;">
                                                </td>
                                            </tr>
                                            @if (!config('app.debug'))
                                                <tr>
                                                    <td style="padding: 2px;padding-left: 15px;">
                                                        <label>کد امنیتی</label>
                                                        <div id="captcha_code" class="form-group input-group">
                                                            <div id="homepage_captcha_request_errors" style="font-family: IranSharp; font-size: 12px; color: red"></div>
                                                            <input type="text" name="captcha_code" class="form-control" tabindex="1" style="direction: ltr; font-family: arial;">
                                                        </div>

                                                        <div class="homepage_login_captcha_refresh captcha-refresh-style" style="">
                                                            <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                                                        </div>
                                                        <div style="float: right;">
                                                            <img style="height: 34px;" class="homepage_login_captcha_image" src="{{ route('captcha', 'login') }}">
                                                        </div>
                                                        <div class="clearfixed"></div>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr style="margin-top: 20px">
                                                <td class="homepage_login" style="padding: 2px; padding-left: 15px;">

                                                    {{--<div class="forgetpas homepage_forget_password_user" data-target="#forgetpas" data-toggle="modal" data-dismiss="modal" style="display: table; margin: auto;">رمز عبور را فراموش کرده‌ام</div>--}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="" style="">
                                            <input type="button" id="btn_homepage_login_form" class="btn btn-primary pull-right" value="ورود به سامانه" style="margin:20px 0 10px 0;"/>
                                        </div>
                                        <div class="col-xs-12 noLeftPadding noRightPadding margin-top-15">
                                            <div class="col-xs-12 noLeftPadding noRightPadding" style="">
                                                <span class="homepage_register_user" style="cursor: pointer; color: green;">کاربر جدید هستم</span>
                                                /
                                                <span class="homepage_forget_password_user" style="cursor: pointer;">رمز عبور را فراموش کرده‌ام</span>
                                                {{--<a href="#">lhljhkj</a>--}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                <div class="col-xs-5 left-div">
                    <img class="center-block" src="theme/general/img/ecological.png">
                    <p class="first-p">در <span>هم افزا</span> وفاق گسترش می یابد</p>
                    <p >در دسترس بودن دانش و بسترهای ارتباطی شفافیت ها را افزایش داده، اختلافات بی حاصل را کمرنگ کرده و اجماع را می‌افزاید.</p>
                </div>
                <div class="col-xs-2"></div>
            </div>
            {{--<div id="login_div" class="right-div" style="height: 420px;margin-top: 100px;">--}}

            {{--</div>--}}
            {{--<div class="right-div">--}}
                {{--<p class="text-center">ثبت نام در هم افزا</p>--}}
                {{--<form id="loginform" class="form-horizontal" role="form" style="">--}}

                    {{--<div style="margin-bottom: 4%" class="input-group form-group-sm">--}}
                        {{--<span class="input-group-addon custom-addon2" style="border-left: none; border-right: 1px solid #ccc; width: 39%; text-align: right; font-size: 1.1em">نام کاربری</span>--}}
                        {{--<input id="login-username" class="login-input" type="text" class="form-control custom-form" name="username" value="" placeholder="">--}}

                    {{--</div>--}}

                    {{--<div style="margin-bottom: 4%" class="input-group form-group-sm">--}}
                        {{--<span class="input-group-addon custom-addon2" style="border-left: none; border-right: 1px solid #ccc; width: 39%; text-align: right; font-size: 1.1em">پست الکترونیک</span>--}}
                        {{--<input id="login-username" class="login-input" type="text" class="form-control custom-form" name="username" value="" placeholder="">--}}

                    {{--</div>--}}

                    {{--<div style="margin-bottom: 4%" class="input-group form-group-sm">--}}
                        {{--<span class="input-group-addon custom-addon2" style="border-left: none; border-right: 1px solid #ccc; width: 39%; text-align: right; font-size: 1.1em">گذرواژه</span>--}}
                        {{--<input id="login-username" class="login-input" type="text" class="form-control custom-form" name="username" value="" placeholder="">--}}

                    {{--</div>--}}

                    {{--<div style="margin-bottom: 4%" class="input-group form-group-sm">--}}
                        {{--<span class="input-group-addon custom-addon2" style="border-left: none; border-right: 1px solid #ccc; width: 39%; text-align: right; font-size: 1.1em">نام و نام خانوادگی</span>--}}
                        {{--<input id="login-password" class="login-input" type="password" class="form-control custom-form" name="password" placeholder="">--}}

                    {{--</div>--}}
                {{--</form>--}}
                {{--<div class="btn btn-success">ثبت نام</div>--}}
                {{--<a href="#"><p class="blue-text">عضو سایت هستم</p></a>--}}

            {{--</div>--}}

        </div>
        <footer class="general-footer col-xs-12 text-center navbar-fixed-bottom">
            <ul id="footer" style="border-top: 1px solid #0bbb0b">
                <li>
                    <a href="http://www.hamafza.ir/ms">درباره هم افزا</a>
                </li>
                <li>
                    <img src="http://hamafza.eqbal.ac.ir/theme/eghbal/Img/li-icon.png">
                </li>
                <li>
                    <a href="http://www.hamafza.ir/100" target="_blank"><span>مبتنی بر</span> هم افزا</a>
                </li>
                <li>
                    <img src="http://hamafza.eqbal.ac.ir/theme/eghbal/Img/li-icon.png">
                </li>
                <li>
                    <a href="http://www.hamafza.co" target="_blank"><span>پشتیبانی :</span> فناوران مدیریت علم هم افزا</a>
                </li>
            </ul>
        </footer>
    </div>

    <!---------------**Specific Plugin Scripts**-------------->
    @include('layouts.homepages.helpers.general.assets.script.specific_plugin_scripts')

    <!---------------**Inline Scripts**-------------->
    @include('layouts.homepages.helpers.general.assets.script.inline_scripts')

    @if(session('message')!='')
        <script>
            jQuery.noticeAdd({
                text: '{{ session('message') }}',
                stay: false,
                type: '{{ session("mestype") }}'
            });
        </script>
    @endif

    @include('layouts.homepages.helpers.general.assets.script.inline_scripts')
    @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
</div>
</body>
</html>
