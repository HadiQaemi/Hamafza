<!DOCTYPE html>
<html ng-app="hamafza">
<head lang="en">
    @include('sections.header')
</head>
<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style="overflow: auto;">
<div hmfz-main-header="">
    {{--<nav id="header" class="navbar navbar-default" style="position: fixed;z-index: 10000;width: 100%;">--}}
    <nav id="header" class="navbar navbar-default" >
        <div class="container-fluid">
            @include('sections.menu')
            @include('sections.loginregister')
        </div>
    </nav>
    @include('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_h_sid')
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

        <div hmfz-tmplt-thm-clr="" hmfz-tmplt-cntnt="">
            ﻿
            <div class="bootslider minislider" id="bootslider" style="margin-top: 55px;">
                <!-- Bootslider Loader -->
                <div class="bs-loader">
                    <img src="homslider/loader.gif" width="31" height="31" alt="Loading.." id="loader"/>
                </div>
                <!-- /Bootslider Loader -->
                <!-- Bootslider Container -->
                <div class="bs-container">
                    <!-- Bootslider Slide -->

                    @if(is_array($mainSlide) && count($mainSlide)>0)
                        @foreach($mainSlide as $item)
                            <div class="bs-slide active">
                                <div class="bs-foreground">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                                <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                    <h2>{{$item->title}}</h2>
                                                    <p>{{$item->descr}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-background">
                                    <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                         data-right="50" data-delay="500">
                                    <img src="Content/slide/{{$item->pic}}" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                         data-top="20" data-delay="500">

                                    <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                                </div>
                            </div>
                        @endforeach

                    @else
                    <!-- /Bootslider Slide -->
                        <div class="bs-slide active">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2>اشراف می‌یابید!</h2>

                                                <p>در هم‌افزا «دانش» نظم می‌یابد، تصورها درست‌تر شکل می‌گیرند و «فهم» عمیق‌تر و دقیق‌تری پدید می‌آید.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/1.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">

                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>

                        <!-- Bootslider Slide -->
                        <div class="bs-slide">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2>نزدیک می‌شوید!</h2>
                                                <p>هم‌افزا «حصارهای علمی» را کم‌رنگ کرده و هم‌افزایی دانش را افزایش می‌دهند. هم‌افزا ذهن‌ها را به هم نزدیک می‌کند.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/3.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">

                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>
                        <!-- /Bootslider Slide -->


                        <!-- Bootslider Slide -->
                        <div class="bs-slide">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2> وصل می‌شوید!</h2>
                                                <p>در هم‌افزا جویندگان و صاحبان دانش یکدیگر را «می‌یابند» و در تعامل با یکدیگر «هم‌زبان» و «هم‌دل» می‌شوند.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/2.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">
                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>
                        <!-- /Bootslider Slide -->


                        <!-- Bootslider Slide -->
                        <div class="bs-slide">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2>شکوفا می‌شوید!</h2>
                                                <p>
                                                    می‌توانید خود را معرفی کنید، افراد بیشتری را بهتر بشناسید، از زیرساخت‌های متعددی (شبکه اجتماعی، ویکی، پرس‌وجو و ...) استفاده کنید؛ تا بیشتر بفهمید و بهتر منتشر کنید.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/6.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">

                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>
                        <!-- /Bootslider Slide -->


                        <!-- Bootslider Slide -->
                        <div class="bs-slide">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2>شروع کنید!</h2>
                                                <p>مخاطبان هم‌افزا «اهالی اندیشه و جویندگان علم» هستند؛ به‌ویژه کسانی که می‌خواهند «وقتشان» در پیچ‌وتاب فضای شلوغ و به‌هم‌ریخته کنونی تلف نشود.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/4.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">

                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>
                        <!-- /Bootslider Slide -->

                        <!-- Bootslider Slide -->
                        <div class="bs-slide">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2>به اینجا بیایید!</h2>
                                                <p>
                                                    چشم انداز هم افزا اینجا است: «فهم بهتر و بیشتر، اوج گرفتن قله علم و عمل و تقویت اندیشه و تعقل در راستای رشد فردی و نیل به جامعه مطلوب.»
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/5.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">

                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>
                        <!-- /Bootslider Slide -->

                        <!-- Bootslider Slide -->
                        <div class="bs-slide">
                            <div class="bs-foreground">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-sx-10 bs-vertical-center">
                                            <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                                <h2>
                                                    به هم‌افزا نیاز دارید!

                                                </h2>
                                                <p>
                                                    دنیای امروز بسیار گسترده، متنوع و پیچیده شده؛ مشغله‌ها و دغدغه‌ها فزونی یافته؛ فراغت‌ها اندک، حافظه و عقلانیت تضعیف و رؤیاهای تقویت‌شده؛ غفلت‌ها زیاد و قلب‌ها سست شده‌ و ...
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bs-background">
                                <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                     data-right="50" data-delay="500">
                                <img src="Content/slide/7.png" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                                     data-top="20" data-delay="500">

                                <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                            </div>
                        </div>
                        <!-- /Bootslider Slide -->
                    @endif

                </div>
                <!-- /Bootslider Container -->
            </div>

            <div class="row main-container" style="top:-20px;">
                <div class="col-md-3" style="top:-20px;">
                    <div class="panel panel-light" style="height: 332px;">
                        <div class="panel-heading panel-heading-darkblue"></div>
                        @include('sections.homeright')

                    </div>


                </div>
                <div class="col-md-6" style="top:-20px;">
                    <div class="panel panel-light" style="height: 332px;">
                        <div class="panel-heading panel-heading-green"></div>
                        <div class="panel-body">
                            @include('sections.homecenter')

                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="top:-20px;">
                    <div class="panel panel-light quick-access" style="height: 332px;">

                        <div class="panel-heading panel-heading-green" style="padding: 0"></div>
                        <div class="panel-body">
                            @include('sections.homeleft')
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end of Main Template -->
        <div class="col-md-12 footerPage">
            <p>
            <ul class="center-block" style="width: 600px;">
                <li><a href="{{App::make('url')->to('/')}}/ms">درباره {{ Config::get('constants.SiteFullTitle')}}</a></li>
                <li>
                    <div class="Footicon icon-2-3"></div>
                    مبتنی بر <a href="{{App::make('url')->to('/')}}/100">هم&zwnj;افزا</a></li>
                <li>
                    <div class="Footicon icon-2-3"></div>
                    پشتیبانی:
                    <a href="http://www.hamafza.co" target="_blank">فناوران مدیریت علم هم&zwnj;افزا</a></li>

                @if ($uid  != '0' && UsersClass::permission('homepage', $uid) == '1')
                    <li>
                        <div class="Footicon icon-2-3"></div>
                        <a href="{{App::make('url')->to('/')}}/{{$Uname}}/desktop/homepage" target="_blank">ویرایش صفحه اول</a></li>
                @endif

            </ul>
            </p>

        </div>
    </div>
</div>


@if(Session::get('message')!='')
    <script>
        jQuery.noticeAdd({
            text: '{{ Session::get('message') }}',
            stay: false,
            type: '{{ Session::get("mestype") }}'
        });
        //                    if (Session::get('message') == 'کاربر ناشناس'){
        //            window.location = "{{App::make('url')->to('/')}}/Logout";
        //            }
    </script>

@endif

<script>

    $(document).ready(function () {
        $("#TagRes").mCustomScrollbar();
    });
    $(function () {
        $("#KeywordFehresrt").jstree({
            "plugins": ["search"]
        });
        var to = false;
    });
    $('#KeywordFehresrt').jstree({
        "plugins": ["search"],
        'core': {
            'data': [
                {!! $keywordTab !!}
            ],
            'rtl': true,
            "themes": {
                "icons": false
            }
        }
    });
    $("#KeywordFehresrt").bind('select_node.jstree',
        function (e, data) {
            var texts = data.node.text;
            var ids = data.node.id;
            $("#Navigatekeywords").tokenInput("add", {id: ids, name: texts});
            $("#TagRes").animate({
                scrollTop: 0
            }, 600);
        })

        .on("activate_node.jstree", function (e, data) {
            window.location.href = data.node.a_attr.href;
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });</script>
<!--    <link rel="stylesheet" type="text/css" media="screen" href="{{App::make('url')->to('/')}}/theme/Content/css/sequencejs-theme.sliding-horizontal-parallax.css" />
        
                <script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.sequence.js"></script>
                <script src="{{App::make('url')->to('/')}}/theme/Scripts/sequencejs-options.sliding-horizontal-parallax.js"></script>-->
</body>
</html>
