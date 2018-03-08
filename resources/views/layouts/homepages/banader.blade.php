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

<body dir="rtl" style="overflow: auto;">
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <div hmfz-main-header="">
        <style>
            .nav .open > a, .nav .open > a:hover, .nav .open > a:focus {
                background-color: #3986AC;
            }
            .navbar-default .navbar-toggle .icon-bar {
                background-color: #f9f9f9;
            }
            .navbar-default .navbar-toggle {
                background-color: #3986AC;
            }
            #myNavbar{
                height: 250px;
                color: #fff;
            }
            .navbar-default .navbar-nav > li > a {
                color: #fff;
            }
            .user-config{
                /*margin-left: -15px;*/
            }
            .logo{
                margin-right: 15px !important;
            }
            .banader_homepage #main {
                padding-top: 10px;
            }
            .container > .navbar-header, .container-fluid > .navbar-header, .container > .navbar-collapse, .container-fluid > .navbar-collapse {
                margin-right: -15px;
                margin-left: 0px;
            }
            /*#header .container-fluid {*/
            /*margin-left: -15px;*/
            /*margin-right: 15px;*/
            /*}*/
        </style>
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
                            <span class="hidden-lg hidden-md hidden-sm" style="font-size: 10px;">{!!substr($Title,0,50)!!}...</span>
                        @endif
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right" style="margin-right: 15px">
                        @if (auth()->check())
                            {!! menuGenerator(3, 'horizontal') !!}
                        @endif
                    </ul>
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
