<!DOCTYPE html>
<html ng-app="hamafza">
<head lang="en">
    <link href="{{App::make('url')->to('/')}}/theme/amid/css/index.css" rel="stylesheet"/>
    <link href="{{App::make('url')->to('/')}}/theme/amid/css/jquery.flipster.min.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/respond.js"></script>
    <![endif]-->
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jssor.core.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jssor.utils.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jssor.slider.min.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jquery.flipster.min.js"></script>
    <link rel="stylesheet" href="http://hamafza.admc.ir/theme/Content/css/admc.css"/>
    @include('sections.header')

</head>
<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style="overflow: auto;">
<div hmfz-main-header="">
    {{--<nav id="header" class="navbar navbar-default" style="position: fixed;z-index: 10000;width: 100%;">--}}
    <nav id="header" class="navbar navbar-default">
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
            <div class="bootslider minislider" id="bootslider" style="margin-top: 55px;margin-bottom: -10px !important;">
                <!-- Bootslider Loader -->
                <div class="bs-loader">
                    <img src="homslider/loader.gif" width="31" height="31" alt="Loading{{App::make('url')->to('/')}}/theme/amid" id="loader"/>
                </div>
                <!-- /Bootslider Loader -->
                <!-- Bootslider Container -->
                <div id='bs-containers' class="bs-container" style="height: 390px !important">
                    <!-- Bootslider Slide -->


                    <!-- /Bootslider Slide -->
                    <div class="bs-slide active">
                        <div class="bs-foreground">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                        <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bs-background">

                            <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                 data-right="50" data-delay="500">
                            <img src="{{App::make('url')->to('/')}}/theme/amid/images/111.jpg" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="100%" data-height="330" data-left="0"
                                 data-top="0" data-delay="500">
                            <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="350">
                        </div>
                    </div>

                    <!-- Bootslider Slide -->
                    <div class="bs-slide">
                        <div class="bs-foreground">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                        <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bs-background">

                            <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                 data-right="50" data-delay="500">
                            <img src="{{App::make('url')->to('/')}}/theme/amid/images/2.jpg" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="100%" data-height="330" data-left="0"
                                 data-top="0" data-delay="500">
                            <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="350">
                        </div>
                    </div>
                    <!-- /Bootslider Slide -->

                    <div class="bs-slide">
                        <div class="bs-foreground">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                        <div data-animate-in="slideLeftReturn" data-animate-out="slideUp" data-delay="500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bs-background">

                            <img src="Content/icons/slider-log.png" class="bs-layer" data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157" data-height="206" data-top="100"
                                 data-right="50" data-delay="500">
                            <img src="{{App::make('url')->to('/')}}/theme/amid/images/3.jpg" class="bs-layer" data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="100%" data-height="330" data-left="0"
                                 data-top="0" data-delay="500">
                            <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                        </div>
                    </div>


                </div>
                <!-- /Bootslider Container -->


            </div>

            <div class="row main-container" style="top:-20px;margin-bottom:30px;">
                <div class="row">

                    <div class="col-xs-12 col-md-12">

                        <div class="col-md-6 col-sm-6 col-xs-12 noPadding pull-right">
                            <h1 class="blueHeader">اخبار و رویدادها</h1>
                            <div id="SecDiv1">

                                <div id="slider2_container" class="daneshSlider shadowBox" style="position: relative; top:0; left: 0; width: 790px; height: 340px; overflow: hidden;float:right; ">

                                    <!-- Loading Screen -->
                                    <div u="loading" style="position: absolute; top: 0; left: 0;">
                                        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                        </div>
                                        <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/amid/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                        </div>
                                    </div>

                                    <!-- Slides Container -->
                                    <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top:20px; width: 790px; height: 300px; overflow: hidden;">
                                        @if(is_array($news) && count($news)>0)
                                            @foreach($news as $item)
                                                <div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <img style="max-height: 250px;max-width: 250px;width: 100%" src="{{App::make('url')->to('/')}}/{{$item->defimage}}" class="pull-right"/>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <p class="pull-right">
                                                                    <a href="{{App::make('url')->to('/')}}/{{$item->id}}">

                                                                        {{$item->title}}
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif


                                    </div>

                                    <!-- Bullet Navigator Skin Begin -->
                                    <!-- jssor slider bullet navigator skin 01 -->
                                    <style>
                                        /*
                                        .jssorb01 div           (normal)
                                        .jssorb01 div:hover     (normal mouseover)
                                        .jssorb01 .av           (active)
                                        .jssorb01 .av:hover     (active mouseover)
                                        .jssorb01 .dn           (mousedown)
                                        */
                                        .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                                            filter: alpha(opacity=70);
                                            opacity: .7;
                                            overflow: hidden;
                                            cursor: pointer;
                                            border: #000 1px solid;
                                        }

                                        .jssorb01 div {
                                            background-color: gray;
                                        }

                                        .jssorb01 div:hover, .jssorb01 .av:hover {
                                            background-color: #d3d3d3;
                                        }

                                        .jssorb01 .av {
                                            background-color: #fff;
                                        }

                                        .jssorb01 .dn, .jssorb01 .dn:hover {
                                            background-color: #555555;
                                        }
                                    </style>
                                    <!-- bullet navigator container -->
                                    <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                                        <!-- bullet navigator item prototype -->
                                        <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;">
                                            <numbertemplate></numbertemplate>
                                        </div>
                                    </div>
                                    <!-- Bullet Navigator Skin End -->
                                    <!-- Arrow Navigator Skin Begin -->
                                    <style>
                                        /* jssor slider arrow navigator skin 02 css */
                                        /*
                                        .jssora02l              (normal)
                                        .jssora02r              (normal)
                                        .jssora02l:hover        (normal mouseover)
                                        .jssora02r:hover        (normal mouseover)
                                        .jssora02ldn            (mousedown)
                                        .jssora02rdn            (mousedown)
                                        */

                                        .jssorb03 {
                                            cursor: pointer;
                                        }

                                        .jssorb03 .av {
                                            background-color: #1b8ed1;
                                        }

                                        .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                            position: absolute;
                                            cursor: pointer;
                                            display: block;
                                            background: url({{App::make('url')->to('/')}}/theme/amid/css/images/a15.png) no-repeat;
                                            overflow: hidden;
                                        }

                                        .jssora02l {
                                            background-position: -3px -33px;
                                        }

                                        .jssora02r {
                                            background-position: -63px -33px;
                                        }

                                        .jssora02l:hover {
                                            background-position: -123px -33px;
                                        }

                                        .jssora02r:hover {
                                            background-position: -183px -33px;
                                        }

                                        .jssora02ldn {
                                            background-position: -243px -33px;
                                        }

                                        .jssora02rdn {
                                            background-position: -303px -33px;
                                        }
                                    </style>
                                    <!-- Arrow Left -->
                                    <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
                                                </span>
                                    <!-- Arrow Right -->
                                    <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
                                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 noLeftPadding">
                            <h1 class="blueHeader">حوزه‌های کسب و کار</h1>
                            <div id="SecDiv" class="daneshSlider shadowBox" style="width: 100%;padding-top: 10px">
                                <div id="SecDiv2" class="col-md-12 col-sm-12 col-xs-12 daneshSlider">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44520"> <img src="{{App::make('url')->to('/')}}/theme/amid/images/ico1.png"></a>
                                            <a href="{{App::make('url')->to('/')}}//44520"> <span>سیاست گذاری عمومی</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44530"> <img src="{{App::make('url')->to('/')}}/theme/amid/images/ico2.png"></a>
                                            <a href="{{App::make('url')->to('/')}}//44530"> <span>سیاست‌گذاری صنعت</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44540"> <img src="{{App::make('url')->to('/')}}/theme/amid/images/ico3.png"></a>
                                            <a href="{{App::make('url')->to('/')}}/44540"> <span>سیاست‌گذاری تکنولوژی</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44550"> <img class="img-responsive" src="{{App::make('url')->to('/')}}/theme/amid/images/ico4.png"></a>
                                            <a href="{{App::make('url')->to('/')}}/44550"> <span>برنامه ریزی استراتژیک سازمانی</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-xs-2 image-index">
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44560"> <img class="img-responsive" src="{{App::make('url')->to('/')}}/theme/amid/images/ico5.png"></a>
                                            <a href="{{App::make('url')->to('/')}}/44560"><span>مدیریت پروژه</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44570"> <img class="img-responsive" src="{{App::make('url')->to('/')}}/theme/amid/images/ico6.png"></a>
                                            <a href="{{App::make('url')->to('/')}}/44570"><span>آموزش</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 image-index">
                                            <a href="{{App::make('url')->to('/')}}/44580"> <img class="img-responsive" src="{{App::make('url')->to('/')}}/theme/amid/images/ico7.png"></a>
                                            <a href="{{App::make('url')->to('/')}}/44580"> <span>مدیریت دانش</span></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1 image-index">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>


                </div>

            </div>


        </div>
        <!-- end of Main Template -->
        <div class="col-md-12 footerPage">
            <p>
            <ul class="center-block" style="width: 800px;">
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
    jQuery(document).ready(function ($) {
        var options = {
            $AutoPlay: false, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
            $AutoPlaySteps: 1, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
            $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
            $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
            $HWA: false,
            $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
            $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
            $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
            //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
            //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
            $SlideSpacing: 5, //[Optional] Space between each slide in pixels, default value is 0
            $DisplayPieces: 1, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
            $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
            $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
            $PlayOrientation: 2, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
            $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always

                $ActionMode: 1, //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                $AutoCenter: 3, //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                $Lanes: 1, //[Optional] Specify lanes to arrange thumbnails, default value is 1
                $SpacingX: 0, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                $SpacingY: 0, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                $DisplayPieces: 5, //[Optional] Number of pieces to display, default value is 1
                $ParkingPosition: 0, //[Optional] The offset position to park thumbnail
                $Orientation: 2, //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                $DisableDrag: true                              //[Optional] Disable drag or not, default value is false
            }
        };
        var jssor_slider3 = new $JssorSlider$("slider3_container", options);
        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizes
        function ScaleSlider() {
            var parentWidth = jssor_slider3.$Elmt.parentNode.clientWidth;
            if (parentWidth) {
                var sliderWidth = parentWidth;
                //keep the slider width no more than 701
                sliderWidth = Math.min(sliderWidth, 792);
                jssor_slider3.$SetScaleWidth(sliderWidth);
            }
            else
                window.setTimeout(ScaleSlider, 30);
        }

        ScaleSlider();
        if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
            $(window).bind('resize', ScaleSlider);
        }


        //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
        //    $(window).bind("orientationchange", ScaleSlider);
        //}
        //responsive code end
    });            </script>

<script>
    var h1 = $("#slider2_container").height();
    var h2 = $("#SecDiv").height();
    if (h1 > h2) {
        $("#SecDiv").height($("#slider2_container").height());

    }
    else {
        $("#slider2_container").height($("#SecDiv").height());

    }
    $("#SecDiv").css('max-height', '300px');
    $("#slider2_container").css('max-height', '300px');

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
