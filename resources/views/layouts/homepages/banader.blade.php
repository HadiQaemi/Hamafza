<!DOCTYPE html>
<html ng-app="hamafza" class="banader banader_homepage">
<head lang="en">
    @php($csrf = csrf_token())
    <meta name="csrf-token" content="{{ $csrf}}">
    @include('layouts.helpers.common.sections.meta')
<!---------------**Main Style**-------------->
    @include('layouts.helpers.common.assets.style.main_style')
    @include('layouts.homepages.helpers.banader.assets.style.after_main_style')
<!---------------**Specific Plugin Style**-------------->
    @include('layouts.homepages.helpers.banader.assets.style.specific_plugin_style')
<!---------------**Inline Style**-------------->
    @include('layouts.homepages.helpers.banader.assets.style.inline_style')
<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
    @include('layouts.homepages.helpers.banader.assets.script.after_main_scripts')
</head>

<body dir="rtl" style="overflow-y: auto;">
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <div hmfz-main-header="">
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
                        @if(!auth()->check())
                            <span class="" style="font-size: 20px;">{!!config('constants.SiteFullTitle')!!}</span>
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
        {{--<nav id="header" class="navbar navbar-default" style="position: fixed;z-index: 10000;width: 100%;">--}}
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
        <div>
            <!-- start of Main Template -->
            <!-- *************************************************************** -->
            <!-- /////////////////////////////////////////////////////////////// -->
        @include('layouts.homepages.helpers.banader.index_content')
        <!-- /////////////////////////////////////////////////////////////// -->
            <!-- *************************************************************** -->
            <!-- end of Main Template -->
            @include('layouts.helpers.common.sections.footer_helper')
        </div>
    </div>
    <!---------------**Specific Plugin Scripts**-------------->
@include('layouts.homepages.helpers.banader.assets.script.specific_plugin_scripts')
<!---------------**Inline Scripts**-------------->
    @include('layouts.homepages.helpers.banader.assets.script.inline_scripts')
    @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
</div>
</body>
</html>