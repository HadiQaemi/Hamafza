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

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>
<body>
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <nav class="navbar navbar-custom">
        <div class="container-fullwidth">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header col-md-4">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand rtl-brand" href="#">هم افزا</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul id="custom-navbar-right" class="nav navbar-nav navbar-right col-xs-9">
                    <li><a href="{{ url('/4') }}">شبکه اجتماعی</a></li>
                    <li><a href="{{ url('/3') }}">اسناد</a></li>
                    <li><a href="{{ url('/2') }}">دانشنامه</a></li>
                    <li><a href="{{ url('/1') }}">قرآن کریم</a></li>
                </ul>
                <div class="navbar-left col-xs-12 col-sm-4">
                    <ul id="header-icons" class="nav navbar-nav col-xs-5 col-md-4 header-icons">
                        <li style="border: none;"><a aria-controls="side-search-tab-1" href="#side-search-tab-1" role="tab" data-toggle="tab"><span style="font-size: 20px; color: white;" class="icon-search-1"></span></a></li>
                        <li style="border: none;"><a aria-controls="side-search-tab-2" href="#side-search-tab-2" role="tab" data-toggle="tab"><span style="font-size: 20px; color: white;" class="icon-tag"></span></a></li>
                        <li style="border: none;"><a aria-controls="side-search-tab-3" href="#side-search-tab-3" role="tab" data-toggle="tab"><span style="font-size: 20px; color: white;" class="icon-dargah"></span></a></li>
                    </ul>
                    <div id="login" class="login pull-left col-xs-5 col-md-6" style="overflow-y: hidden">
                        <img src="{{ url('theme/hamafza/index_2/img/avatar.png') }}">
                        <div class="inner-login col-xs-9" style="padding: 0%">
                            @if(auth()->check())
                                <a href="#">{{ auth()->user()->Name .' '. auth()->user()->Family }}</a>
                                <ul id="ul-nav">
                                    <li><a href="{{ url(auth()->user()->Uname . '/wall') }}">دیوار@if(user_notifications_count('wall', auth()->id()) > 0) <span class="badge">{{ user_notifications_count('wall', auth()->id()) }}</span> @endif</a>
                                    </li>
                                    <li><a style="padding-right: 5px;" href="{{ url(auth()->user()->Uname . '/desktop') }}">میز کار @if(user_notifications_count('', auth()->id()) > 0)<span
                                                    class="badge DesktopNotificaton">{{ user_notifications_count('', auth()->id()) }}</span>@endif</a></li>
                                    <li style="margin-left: 4%; padding-right: 5px;"><a href="{{ url(auth()->user()->Uname . '/cart') }}">خرید @if(user_notifications_count('bazaar', auth()->id()) > 0)<span
                                                    class="badge DesktopNotificaton">{{ user_notifications_count('bazaar', auth()->id()) }}</span>@endif</a></li>
                                    <li class="dropdown custom-dropdown" style="margin:0 2px 4px 0">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <div class="col-lg-12">
                                                <img src="img/avatar.png">
                                                <h3><b>عضو سایت</b></h3>
                                                <h5 style="color: #9e9e9e">example@yahoo.com</h5>
                                                <input type="submit" name="about" tabindex="4" class="btn custom-btn center-block btn-success" value="درباره" onclick="window.location='about.html'">
                                            </div>
                                            <div class="exit">
                                                <a href="#"><i class="icon fa-power-off" aria-hidden="true"></i></a>
                                                <a href="#">خروج</a>
                                            </div>
                                        </ul>
                                    </li>
                                </ul>
                            @else
                                <a class="homepage_modal_login_form" href="#">ورود</a>
                                <a class="homepage_modal_register_form" href="#">ثبت نام</a>
                            @endif
                        </div>
                    </div>
                </div><!-- /.navbar-left -->
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>
    <div class="footer-top">
        @include('layouts.homepages.helpers.hamafza_2.index_content')
    </div>
    @include('layouts.homepages.helpers.hamafza_2.sections.footer')

    @include('layouts.homepages.helpers.hamafza_2.assets.script.main_scripts')
    @include('layouts.homepages.helpers.hamafza_2.assets.script.inline_scripts')
    @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
</div>
</body>
</html>