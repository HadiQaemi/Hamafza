<!doctype html>
<html lang="fa">
<head>
    @php($csrf = csrf_token())
    <meta name="csrf-token" content="{{ $csrf}}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133904506-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-133904506-2');
    </script>
    @if( ! empty($meta_description))
        <meta name="description" content="{{$meta_description}}"/>
    @else
        <meta name="description" content="{{Config::get('constants.Sitedescription')}}"/>
    @endif
    <title>{{ $SiteTitle }}</title>
    @include('layouts.homepages.helpers.hamafza_2.assets.style.main_style')
    @include('layouts.homepages.helpers.hamafza_2.assets.script.main_scripts')
    @include('layouts.homepages.helpers.hamafza_2.assets.script.inline_scripts')
    @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <style>
        .horizontal-menu .parent_li ul {
            background: #1b658aa3;
        }
        #custom-navbar-right li {
            height: 23px;
            line-height: 15px;
        }
        .tab-content input{
            font-size: large !important;
            width: 50px;
        }
        .tab-content .btn-primary{
            color: #fff;
        }
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            font-size: 12px !important;
        }
        ::-moz-placeholder { /* Firefox 19+ */
            font-size: 12px !important;
        }
        :-ms-input-placeholder { /* IE 10+ */
            font-size: 12px !important;
        }
        :-moz-placeholder { /* Firefox 18- */
            font-size: 12px !important;
        }
        .error-login{
            font-size: 12px;
            color: #ef9393;
            position: relative;
            top: -8px;
        }
        #homepage_login_form input{
            font-size: 15px !important;
            height: 35px !important;
            direction: rtl !important;
        }
        #homepage_login_form button{
            height: 30px;
            line-height: 10px;
            font-size: large !important;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .tumbnail1 input {
            margin-bottom: 9px !important;
        }
        .login_captcha_image{
            height: 35px;
            width: 100%;
            line-height: 35px;
        }
        .inner_register_div .btn_modal_register{
            font-size: 20px !important;
        }
        .inner_register_div .login{
            font-size: 20px !important;
        }
        #modal_login_form button{
            font-size: 20px !important;
        }
        #modal_remember_pass_form button{
            font-size: 20px !important;
        }
        #modal_remember_pass_form button{
            padding: 5px;
        }
        #modal_remember_pass_form .help-block{
            font-size: 20px !important;
        }
        #modal_remember_pass_form .help-block.register{
            font-size: 15px !important;
        }
        #modal_remember_pass_form input{
            font-size: 15px !important;
            height: 35px !important;
            direction: rtl !important;
        }
        #modal_login_form input{
            font-size: 15px !important;
            height: 35px !important;
            direction: rtl !important;
        }
    </style>
</head>
<body class="mstr-clr responsive-theme">
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <nav class="navbar navbar-custom">
        <div class="container-fullwidth">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand rtl-brand" style="color:#fff !important;" href="#">هم افزا</a>
            </div>
        @php ($logged_in = session('Login') && session('Login') == 'TRUE')
        @php ($style = $logged_in ? null : 'display: none')
        @php ($unstyle = $logged_in ? null : 'style="width: 32%;"')
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul id="custom-navbar-right" class="nav navbar-nav navbar-right">
                    <ul class="nav navbar-nav navbar-right quick-links-res hidden-xs" style="margin-right: 15px;width: 800px;top: -50px;right: -200px;">
                        {!! menuGenerator(3, 'horizontal') !!}
                    </ul>
                </ul>
                <div class="navbar-left" style="overflow: hidden">
                    <div style="position: relative;right: 20px;" class="">
                        <div class="pull-left" style="margin: 0px 20px;width: 160px;">
                            <div class="pull-left" style="padding-right: 15px;width: 130px;">
                                <div class="inner-login" style="padding: 0%">
                                    @if(auth()->check())
                                        <div style="margin-top: 8px;">
                                            <div style="padding-bottom: 5px">
                                                <a href="#" style="color: #fff;font-weight: lighter;">{{ auth()->user()->Name .' '. auth()->user()->Family }}</a>
                                            </div>
                                            <div>
                                                <div class="col-xs-4 noRightPadding noLeftPadding">
                                                    <a href="{{ url(auth()->user()->Uname . '/wall') }}" style="font-size: x-small;color: #fff;font-size: x-small;font-weight: lighter;">دیوار@if(user_notifications_count('wall', auth()->id()) > 0) <span class="badge" style="color: #fff;font-weight: lighter;">{{ user_notifications_count('wall', auth()->id()) }}</span> @endif</a>
                                                </div>
                                                <div class="col-xs-4 noRightPadding noLeftPadding">
                                                    <a style="color: #fff;font-size: x-small;font-weight: lighter;" href="{{ url(auth()->user()->Uname . '/desktop') }}">میز کار @if(user_notifications_count('', auth()->id()) > 0)<span
                                                                class="badge DesktopNotificaton">{{ user_notifications_count('', auth()->id()) }}</span>@endif</a>
                                                </div>
                                                <div class="col-xs-4 noRightPadding noLeftPadding">
                                                    <a href="{{App::make('url')->to('/')}}/Logout" class="exit fa fa-power-off" style="color: #fff;font-weight: lighter;font-size: x-small;font-size: 12pt;"></a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="homepage_modal_login_form pointer" href="#" style="color: #fff;font-weight: lighter;padding: 5px 0px;">ورود</div>
                                        <div class="register homepage_register_user pointer" href="#" style="color: #fff;font-weight: lighter;padding: 5px 0px;">ثبت نام</div>
                                    @endif
                                </div>
                            </div>
                            <div class="pull-left" style="margin-top: 7px;margin-top: 7px;width: 30px;">
                                <img src="{{ url('theme/hamafza/index_2/img/avatar.png') }}" style="float:right">
                            </div>
                        </div>
                        <div class="pull-left quick-links" style="margin-top: 12px;margin-left: 20px;">
                            <div class="pull-left col-xs-2">
                                <li class="no-border pointer" href="#tab4"><a><span class="icon-search-1"  style="font-size: 20px; color: white;"></span></a></li>
                            </div>
                            <div class="pull-left col-xs-2">
                                <li class="no-border pointer" href="#tab3"><a><span class="icon-tag"  style="font-size: 20px; color: white;"></span></a></li>
                            </div>
                            <div class="pull-left col-xs-2">
                                <li class="no-border pointer" href="#tab2"><a><span class="icon-dargah icon-dargah-click"  style="font-size: 20px; color: white;"></span></a></li>
                            </div>
                            <div class="pull-left col-xs-2" style="{{$style}}">
                                <li class="no-border pointer" href="#tab1"><a><span class="icon-choobalefnazok" style="font-size: 20px; color: white;"></span></a></li>
                            </div>
                        </div>
                        {{--<ul class="nav navbar-nav col-xs-5 col-md-4 header-icons quick-links" style="    position: relative !important;left: -120px;top: 12px;padding: 0px;">--}}
                            {{--<li href="#tab1" {!! $style !!}><a><span class="icon-choobalefnazok" title="چوب‌های الف" data-placement="top" data-toggle="tooltip"></span></a></li>--}}
                            {{--<li class="no-border pointer" href="#tab1" style="{{$style}}"><a><span class="icon-choobalefnazok" style="font-size: 20px; color: white;"></span></a></li>--}}
                            {{--<li class="no-border pointer" href="#tab2"><a><span class="icon-dargah icon-dargah-click"  style="font-size: 20px; color: white;"></span></a></li>--}}
                            {{--<li class="no-border pointer" href="#tab3"><a><span class="icon-tag"  style="font-size: 20px; color: white;"></span></a></li>--}}
                            {{--<li class="no-border pointer" href="#tab4"><a><span class="icon-search-1"  style="font-size: 20px; color: white;"></span></a></li>--}}
                        {{--</ul>--}}
                    </div>
                    {{--<div class="login pull-left col-xs-5 col-md-6" style="    overflow-y: hidden;position: relative;left: -65px;">--}}
                        {{--<img src="{{ url('theme/hamafza/index_2/img/avatar.png') }}" style="float:right">--}}
                        {{--<div class="inner-login" style="padding: 0%">--}}
                            {{--@if(auth()->check())--}}
                                {{--<a href="#" style="color: #fff;font-weight: lighter;">{{ auth()->user()->Name .' '. auth()->user()->Family }}</a>--}}
                                {{--<ul id="ul-nav">--}}
                                    {{--<li style="position: relative;top: 2px;"><a href="{{ url(auth()->user()->Uname . '/wall') }}" style="font-size: x-small;color: #fff;font-size: x-small;font-weight: lighter;">دیوار@if(user_notifications_count('wall', auth()->id()) > 0) <span class="badge" style="color: #fff;font-weight: lighter;">{{ user_notifications_count('wall', auth()->id()) }}</span> @endif</a>--}}
                                    {{--</li>--}}
                                    {{--<li style="position: relative;top: 2px;right: 5px;"><a style="color: #fff;font-size: x-small;font-weight: lighter;padding-right: 5px;" href="{{ url(auth()->user()->Uname . '/desktop') }}">میز کار @if(user_notifications_count('', auth()->id()) > 0)<span--}}
                                                    {{--class="badge DesktopNotificaton">{{ user_notifications_count('', auth()->id()) }}</span>@endif</a></li>--}}
                                    {{--<li style="position: relative;top: 3px;right: 10px;color: #fff;font-weight: lighter;padding-right: 5px;">--}}
                                        {{--<a href="{{App::make('url')->to('/')}}/Logout" class="exit fa fa-power-off" style="color: #fff;font-weight: lighter;font-size: x-small;font-size: 12pt;"></a>--}}
                                    {{--</li>--}}

                                {{--</ul>--}}
                            {{--@else--}}
                                {{--<a class="homepage_modal_login_form" href="#" style="color: #fff;font-weight: lighter;">ورود</a>--}}
                                {{--<a class="homepage_modal_register_form" href="#" style="color: #fff;font-weight: lighter;">ثبت نام</a>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div><!-- /.navbar-left -->
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
        @include('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_h_sid')
    </nav>
    <div class="footer-top">
        @include('layouts.homepages.helpers.hamafza_2.index_content')
    </div>
    @include('layouts.homepages.helpers.hamafza_2.sections.footer')

</div>
</body>
</html>