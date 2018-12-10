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
                    <a class="navbar-brand rtl-brand" href="{{App::make('url')->to('/')}}" style="padding: inherit !important; height: 47px!important;">
                        <span style="font-size: 20px;">{{ config('constants.SiteFullTitle') }}</span>
                        @if (auth()->check())
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
    <div id="main" style="overflow: auto;height: 100Vh;background: url(theme/general/img/main-bg.png);background-size: 100% 100%;">
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
            <div class="row col-xs-12" style="margin-top:10%;">
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
                                    <table style="width:100%;margin-top: 20px;">
                                        <tbody>
                                        <tr>
                                            <td style="padding: 2px;padding-left: 15px;">
                                                <div id="homepage_username_request_errors" style="font-family: Arial; font-size: 12px; color: red"></div>
                                                <input type="text" name="username" id="username" autofocus="" class="form-control required"  " placeholder="رایانامه یا نام کاربری"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 2px;width:100%;padding-left: 15px;padding-top: 12px;">
                                                <div id="homepage_password_request_errors" style=" font-size: 12px; color: red"></div>
                                                <input type="password" id="passwords" name="password" class="form-control required" placeholder="رمز عبور"  autocomplete="off">
                                            </td>
                                        </tr>
                                        @if (!config('app.debug'))
                                            <tr>
                                                <td style="padding: 2px;padding-left: 15px;padding-top: 12px;">
                                                    <div style="padding:0px">
                                                        <div id="captcha_code" class="form-group input-group col-xs-5" style="float: right;" >

                                                            <input type="text" name="captcha_code" placeholder="کد امنیتی" class="form-control" tabindex="1"     >
                                                        </div>

                                                        <div class="homepage_login_captcha_refresh captcha-refresh-style" style="float: right;margin-right: 7px;">
                                                            <i style="color: black; margin-top: 9px;" class="fa fa-refresh"></i>
                                                        </div>
                                                        <div >
                                                            <img style="height: 34px;  border-radius: 4px 0px 0px 4px !important" class="homepage_login_captcha_image" src="{{ route('captcha', 'login') }}">
                                                        </div>
                                                        <div id="homepage_captcha_request_errors" style="    clear: both;font-family: IranSharp; font-size: 12px; color: red"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="padding: 2px;padding-left: 15px;padding-top: 12px;">
                                                <input type="button" id="btn_homepage_login_form" class="btn btn-primary col-xs-12" value="ورود به سامانه"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top: 12px;">
                                                <span class="homepage_register_user" style="cursor: pointer; color: green;">کاربر جدید هستم</span>
                                                /
                                                <span class="homepage_forget_password_user" style="cursor: pointer;">رمز عبور را فراموش کرده‌ام</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-xs-5 left-div">
                    <img class="center-block" src="theme/general/img/ecological.png">
                    <p class="first-p2">
                        {{--در <span>هم افزا</span> وفاق گسترش می یابد--}}
                    </p>
                    <p >در دسترس بودن دانش و بسترهای ارتباطی شفافیت ها را افزایش داده، اختلافات بی حاصل را کمرنگ کرده و اجماع را می‌افزاید.</p>
                </div>
                <div class="col-xs-2"></div>
            </div>

        </div>
        <footer class="general-footer col-xs-12 text-center navbar-fixed-bottom">
            <ul id="footer" style="border-top: 1px solid #0bbb0b;height: 50px">
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
<script>
    $('.homepage_login_captcha_image,.login_captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
</script>
</body>
</html>
