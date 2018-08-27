<!DOCTYPE html>
<html>
<head lang="en">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{App::make('url')->to('/')}}/theme/itrak/css/Style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/newbanader/css/style.css">
    <script src="{{App::make('url')->to('/')}}/theme/newbanader/js/tab.js" type="text/javascript"></script>

    @include('sections.header')
</head>
<body class="mstr-clr" dir="rtl" style="overflow: auto;">
<div hmfz-main-header="">
    {{--<nav id="header" class="navbar navbar-default" style="position: fixed;z-index: 10000;width: 100%;">--}}
    <nav id="header" class="navbar navbar-default">
        <div class="container-fluid">
            @include('sections.menu')
            @include('sections.loginregister_bandar')
        </div>
    </nav>
    @include('layouts.helpers.common.sections.helpers.nav_bar.left_nav_bar_h_sid')
</div>

<div id="main">
    <section class="col-md-12 col-sm-12 col-xs-12">
        <div class="row">

            <div class="daneshnameh col-xs-12  col-lg-2" style="margin-bottom: 5px;">
                <div class="knowledge-repository">
                    <p class="knowledge-repository-title">دایره المعارف دریایی</p>


                    <div class="list">
                        <a href="360150/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/darya1.png">

                            <p style="font-size: 1.1em;">دریانوردی و سفر دریایی</p></a>
                    </div>


                    <div class="list">
                        <a href="360160/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/sakht.png">

                            <p style="font-size: 1.1em;">ساختمان كشتی‌ها</p></a>
                    </div>


                    <div class="list">
                        <a href="360240/OnlyTree">
                            <img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/sahel.png">

                            <p style="font-size: 1.1em;"> مدیریت ساحل و بندر</p></a>
                    </div>


                    <div class="list">
                        <a href="360250/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/ocean.png">

                            <p style="font-size: 1.1em;">اقیانوس‌شناسی واهداف</p></a>
                    </div>


                    <div class="list">
                        <a href="360260/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/shimi.png">

                            <p style="font-size: 11px;">شیمی،آلودگی و زمین شناسی‌</p></a>
                    </div>


                    <div class="list">
                        <a href="360270/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/zist.png">

                            <p style="font-size: 1.1em;">زیست شناسی دریا</p></a>
                    </div>


                    <div class="list">
                        <a href="360280/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/nav.png">

                            <p style="font-size: 1.1em;"> اصول ناوبری کشتی</p></a>
                    </div>


                    <div class="list">
                        <a href="360290/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/haml.png">

                            <p style="font-size: 1.1em;">حمل ونقل و بیمه دریایی</p></a>
                    </div>
                    <div class="list">
                        <a href="360300/OnlyTree"><img src="{{App::make('url')->to('/')}}/theme/newbanader/icons/law.png">

                            <p style="font-size: 1.1em;"> قوانین تجارت دریایی</p></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-8">
                <section id="banner">
                    <script src="{{App::make('url')->to('/')}}/theme/newbanader/sliderengine/jquery.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/newbanader/sliderengine/amazingslider.js"></script>
                    <link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/newbanader/sliderengine/amazingslider-1.css">
                    <script src="{{App::make('url')->to('/')}}/theme/newbanader/sliderengine/initslider-1.js"></script>
                    <div id="amazingslider-wrapper-1" style="display:block;position:relative;max-width:100%;margin:0px auto 51px;">
                        <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                            <ul class="amazingslider-slides" style="display:none;">
                                @if( count($slides)>0)
                                    @foreach($slides as $item)
                                        <li>
                                            <img src="{{App::make('url')->to('/')}}/{{$item->defimage}}" alt="Page1" title="<a style='color:#FFF;' href='{{$item->id}}'>{{$item->title}}</a>"/>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

            <div class="hidden-xs  col-lg-2 hidden-sm">
                <div class="Advertising">
                    <p class="Advertising-title">تبلیغات</p>
                    <img src="{{url('theme/newbanader/img/Advertising1.png')}}">
                    <img src="{{url('theme/newbanader/img/Advertising2.png')}}">
                    <img src="{{url('theme/newbanader/img/Advertising3.png')}}">
                    <img src="{{url('theme/newbanader/img/Advertising4.png')}}">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-left: 4px">
                <div class="news">
                    <p class="news-title">اخبار</p>
                    <ul class="tabs" data-persist="true">
                        <li>
                            <a href="#view1">اخبار</a>
                        </li>
                        <li>
                            <a href="#view2">رویدادها</a>
                        </li>
                        <li>
                            <a href="#view3">آمار</a>
                        </li>
                    </ul>
                    <div class="tabcontents">
                        <div id="view1" style="z-index: 100">
                            <div class="ScrollNew" style="direction: rtl;;height: 375px;z-index: 1">
                                @if( count($news)>0)
                                    @foreach($news as $item)
                                        <?php $kind = $item->kind;?>
                                        <div class="list-tab">
                                            <img src="{{App::make('url')->to('/')}}/{{$item->defimage}}">
                                            <div class="tab-text">
                                                <h3><a href="{{App::make('url')->to('/')}}/{{$item->id}}">{{$item->title}}</a></h3>
                                                <p>{{$item->description}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <a href="{{url('/')}}/rss/{{$kind}}" target="_blank"><img src="img/rss.png"> </a>
                                    <a href="{{url('/')}}/rss/{{$kind}}" target="_blank" style="margin-left:10px;;float:left"><img src="img/ellipsis.png"> </a>

                                @endif


                            </div>
                        </div>
                        <div id="view2">
                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">
                                <div class="tab-text">
                                    <h3>اجازه عبور کشتی ها صادر شد</h3>
                                    <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                                </div>
                            </div>
                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">

                                <div class="tab-text">
                                    <h3>اجازه عبور کشتی ها صادر شد</h3>


                                    <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                                </div>
                            </div>


                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">

                                <div class="tab-text">
                                    <h3>اجازه عبور کشتی ها صادر شد</h3>


                                    <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                                </div>
                            </div>
                        </div>


                        <div id="view3">
                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">

                                <div class="tab-text">
                                    <h3>اجازه عبور کشتی ها صادر شد</h3>


                                    <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                                </div>
                            </div>


                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/news.png">

                                <div class="tab-text">
                                    <h3>اجازه عبور کشتی ها صادر شد</h3>


                                    <p>و دریانوردی قشم از ترابری 9.3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون کالای نفتی و غیر نفتی در بنادر این جزیره در ابتدای سال جاری تا کنون خبر داد.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--============tab============-->
                </div>


            </div>


            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-right: 4px">
                <div class="news">
                    <p class="news-title">شبکه اجتماعی</p>
                    <ul class="tabss">
                        <li class="selected" href="#viewSN4">
                            <a>افراد</a>
                        </li>
                        <li href="#viewSN5">
                            <a>گروه‌ها</a>
                        </li>
                        <li href="#viewSN6">
                            <a>سازمان‌ها</a>
                        </li>
                        <li href="#viewSN7">
                            <a>شرکت‌ها</a>
                        </li>
                    </ul>
                    <script>

                    </script>

                    <div class="tabcontentss">
                        <div class="tabcontentssDiv" id="viewSN4" style="display: block;">


                            <div style="padding: 5px;">
                                @if( count($Users)>0)
                                    @foreach($Users as $item)
                                        <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                            <a href="{{App::make('url')->to('/')}}/{{$item->uname}}">
                                                <?php
                                                $pic = 'pics/person/defuser.png';
                                                if (trim($item->Pic) != '' && file_exists('pics/user/' . $item->id . '-' . $item->Pic))
                                                    $pic = 'pics/user/' . $item->id . '-' . $item->Pic;
                                                else if (trim($item->Pic) != '' && file_exists('pics/user/' . $item->Pic))
                                                    $pic = 'pics/user/' . $item->Pic;
                                                ?>
                                                <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">
                                                <span style="display: inline-block;">{{$item->Name}} {{$item->Family}}</span></a>
                                            <div class="clearfix"></div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>


                        </div>
                        <div class="tabcontentssDiv" id="viewSN5" style="display: none;">
                            <div style="padding: 5px;">
                                @if(count($Groups)>0)
                                    @foreach($Groups as $item)
                                        <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                            <a href="{{App::make('url')->to('/')}}/{{$item->link}}">
                                                <?php
                                                $pic = 'pics/group/Groups.png';
                                                if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                                                    $pic = 'pics/group/' . $item->pic;
                                                ?>
                                                <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">

                                                <span style="display: inline-block;">{{$item->name}}</span></a>
                                            <div class="clearfix"></div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tabcontentssDiv" id="viewSN6" style="display: none;">


                            <div style="padding: 5px;">

                                @if(count($Orgs)>0)
                                    @foreach($Orgs as $item)
                                        <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                            <a href="{{App::make('url')->to('/')}}/{{$item->link}}">
                                                <?php
                                                $pic = 'pics/group/Groups.png';
                                                if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                                                    $pic = 'pics/group/' . $item->pic;
                                                ?>
                                                <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">

                                                <span style="display: inline-block;">{{$item->name}}</span></a>
                                            <div class="clearfix"></div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="tabcontentssDiv" id="viewSN7" style="display: none;">
                            <div style="padding: 5px;">
                                @if(count($Coms)>0)
                                    @foreach($Coms as $item)
                                        <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                            <a href="{{App::make('url')->to('/')}}/{{$item->link}}">
                                                <?php
                                                $pic = 'pics/group/Groups.png';
                                                if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                                                    $pic = 'pics/group/' . $item->pic;
                                                ?>
                                                <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">
                                                <span style="display: inline-block;">{{$item->name}}</span></a>
                                            <div class="clearfix"></div>
                                        </div>

                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!--------------tab-------------->
                    </div>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-left: 4px">
                <div class="news" style="margin-top: 8px;margin-bottom:20px;width:100%;">
                    <p class="news-title">پژوهش</p>
                    <ul class="tabs" data-persist="true">
                        <li>
                            <a href="#viewp1">نشریات</a>
                        </li>
                        <li>
                            <a href="#viewp2">پایان‌نامه</a>
                        </li>
                        <li>
                            <a href="#viewp3">طرح‌های پژوهشی</a>
                        </li>
                        <li>
                            <a href="#viewp4">تازه‌های نشر</a>
                        </li>
                        <li class="selected">
                            <a href="#view4">کتابخانه دیجیتال</a>
                        </li>
                    </ul>
                    <div class="tabcontents">
                        <div id="viewp1">
                            <div style="padding: 5px;display: inline-block;text-align: center;">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{App::make('url')->to('/')}}/theme/banader/images/masir.jpg"
                                         class="img-responsive">
                                    <span style="display: inline-block;"><a href="http:/www.pmo.ir/fa/publications/masir-%D9%85%D8%A7%D9%87%D9%86%D8%A7%D9%85%D9%87-%D9%85%D8%B3%DB%8C%D8%B1" target="_blank">ماهنامه مسیر</a></span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "
                                         src="{{App::make('url')->to('/')}}/theme/banader/images/modiriatdanesh.jpg" class="img-responsive">

                                    <span style="display: inline-block;"><a href="http:/www.pmo.ir/fa/publications/amvajedanesh-%D9%85%D8%A7%D9%87%D9%86%D8%A7%D9%85%D9%87-%D8%A7%D9%85%D9%88%D8%A7%D8%AC-%D8%AF%D8%A7%D9%86%D8%B4"
                                                                            target="_blank">ماهنامه امواج دانش</a></span>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <img style="width:100px; height: 100px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{App::make('url')->to('/')}}/theme/banader/images/sanat.jpg"
                                         class="img-responsive">
                                    <span style="display: inline-block;"><a
                                                href="http:/www.pmo.ir/fa/publications/sanat-%D9%86%D8%B4%D8%B1%DB%8C%D9%87-%D8%B5%D9%86%D8%B9%D8%AA-%D8%AD%D9%85%D9%84-%D9%88-%D9%86%D9%82%D9%84-%D8%AF%D8%B1%DB%8C%D8%A7%DB%8C%DB%8C"
                                                target="_blank">نشریه صنعت حمل و نقل دریایی</a></span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div id="viewp2">
                            <div style="padding: 5px;display: inline-block;text-align: center;">
                                <ul class="list-unstyled">
                                    @if(count($paya)>0)
                                        @foreach($paya as $item)
                                            <li class="col-md-12">
                                                <div class="col-md-3">
                                                    <img src="{{App::make('url')->to('/')}}/{{$item->defimage}}">
                                                </div>
                                                <div class="col-md-9">
                                                    <h3><a href="{{App::make('url')->to('/')}}/{{$item->id}}">{{$item->title}}<a></h3>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div id="viewp3">
                            <div style="padding: 5px;display: inline-block;text-align: center;">
                                <ul class="list-unstyled">
                                    @if( count($tarh)>0)
                                        @foreach($tarh as $item)
                                            <li class="col-md-12">
                                                <div class="col-md-3">
                                                    <img src="{{App::make('url')->to('/')}}/{{$item->defimage}}">
                                                </div>
                                                <div class="col-md-9">
                                                    <h3><a href="{{App::make('url')->to('/')}}/{{$item->id}}">{{$item->title}}<a></h3>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div id="view4" style="display: block;">
                            <div class="list-tab">
                                <img src="{{App::make('url')->to('/')}}/theme/newbanader/img/library.png">
                                <div class="tab-text">
                                    <h3><a href="http:/library.pmo.ir/faces/home.jspx" target="_blank">کتابخانه دیجیتال سازمان بنادر و دریانوردی</a></h3>
                                    <p></p>
                                </div>
                            </div>
                        </div>

                        <div id="viewp4">
                            <div id="chartss">
                            </div>
                            <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                            <script src="https://code.highcharts.com/highcharts.js"></script>

                            <script>
                                var chart = Highcharts.chart('chartss', {

                                    chart: {
                                        type: 'column'
                                    },

                                    title: {
                                        text: 'مقایسه تعداد نشریات، مجلات و کتابها'
                                    },


                                    legend: {
                                        align: 'right',
                                        verticalAlign: 'middle',
                                        layout: 'vertical'
                                    },

                                    xAxis: {
                                        categories: ['کتاب', 'مقاله', 'نشریه'],
                                        labels: {
                                            x: -10
                                        }
                                    },

                                    yAxis: {
                                        allowDecimals: false,
                                        title: {
                                            text: 'تعداد'
                                        }
                                    },

                                    series: [{
                                        name: 'فروردین',
                                        data: [1, 4, 3]
                                    }, {
                                        name: 'اردیهشت',
                                        data: [6, 4, 2]
                                    }, {
                                        name: 'خرداد',
                                        data: [8, 4, 3]
                                    }],

                                    responsive: {
                                        rules: [{
                                            condition: {
                                                maxWidth: 500
                                            },
                                            chartOptions: {
                                                legend: {
                                                    align: 'center',
                                                    verticalAlign: 'bottom',
                                                    layout: 'horizontal'
                                                },
                                                yAxis: {
                                                    labels: {
                                                        align: 'left',
                                                        x: 0,
                                                        y: -5
                                                    },
                                                    title: {
                                                        text: null
                                                    }
                                                },
                                                subtitle: {
                                                    text: null
                                                },
                                                credits: {
                                                    enabled: false
                                                }
                                            }
                                        }]
                                    }
                                });


                            </script>
                        </div>
                    </div>
                    <!--============tab============-->
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-right: 4px">
                <div class="library" style="margin-bottom: 20px;width: 100%">
                    <p class="library-title">آمار</p>
                    <!--============tab============-->
                    <ul class="tabs" data-persist="true">
                        <li class="selected">
                            <a href="#view4">نمودار موضوعات</a>
                        </li>


                        {{--<li class="">--}}
                        {{--<a href="#view5">کتابخانه سازمان</a>--}}
                        {{--</li>--}}
                    </ul>


                    <div class="tabcontents">
                        <div id="highChartSubjects" class="col-xs-12" style="display:none">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div id="container"></div>
                                </div>
                            </div>
                        </div>
                    {{--<div id="view4" style="display: block;">--}}
                    {{--<div class="list-tab">--}}
                    {{--<img src="{{App::make('url')->to('/')}}/theme/newbanader/img/library.png">--}}
                    {{--<div class="tab-text">--}}
                    {{--<h3><a href="http:/library.pmo.ir/faces/home.jspx" target="_blank">کتابخانه دیجیتال سازمان بنادر و دریانوردی</a></h3>--}}
                    {{--<p></p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div id="view5" style="display: none;">--}}
                    {{--<div class="list-tab">--}}
                    {{--<img src="{{App::make('url')->to('/')}}/theme/newbanader/img/library.png">--}}
                    {{--<div class="tab-text">--}}
                    {{--<h3><a href="http:/library.pmo.ir/faces/home.jspx" target="_blank">کتابخانه دیجیتال سازمان بنادر و دریانوردی</a></h3>--}}
                    {{--<p></p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <!--------------tab-------------->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="col-md-12 col-sm-12 col-xs-12 container-fluid">
        <ul id="footer">
            <li><a href="#">درباره ما</a></li>
            <li><img src="{{App::make('url')->to('/')}}/theme/itrak/Img/li-icon.png"></li>
            <li><a href="http:/www.hamafza.ir" target="_blank">مبتنی بر هم افزا</a></li>
            <li><img src="{{App::make('url')->to('/')}}/theme/itrak/Img/li-icon.png"></li>
            <li><a href="http:/www.hamafza.co" target="_blank">پشتیبانی : فناوران مدیریت علم هم افزا</a></li>
        </ul>
    </footer>
</div>
<script type="text/javascript" src="http://enscrollplugin.com/releases/enscroll-0.6.0.min.js"></script>
<style>


    .track3 {
        width: 10px;
        background: rgba(0, 0, 0, 0);
        margin-right: 2px;
        border-radius: 10px;
        -webkit-transition: background 250ms linear;
        transition: background 250ms linear;
    }

    .track3:hover,
    .track3.dragging {
        background: #d9d9d9;
        background: rgba(0, 0, 0, 0.15);
    }

    .handle3 {
        width: 7px;
        right: 0;
        background: #999;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 7px;
        -webkit-transition: width 250ms;
        transition: width 250ms;
    }

    .track3:hover .handle3,
    .track3.dragging .handle3 {
        width: 10px;
    }
</style>
<script>
    //        $(".ScrollNew").mCustomScrollbar({theme: "dark-3"});
    $('.ScrollNew').enscroll({
        showOnHover: false,
        verticalTrackClass: 'track3',
        verticalHandleClass: 'handle3',
        verticalScrollerSide: 'left'
    });
    $(document).on("click", ".tabss li", function () {
        $(".tabss li").removeClass("selected");
        $(this).toggleClass("selected");
        var h = $(this).attr('href');
        $(".tabcontentssDiv").hide();
        $(h).show();
// /       $(".back-li").removeClass("active2");
//  /      $(this).toggleClass("active2");
//         $(".arrow").hide();
//        $(this).find(".arrow").show();
    });

    $(document).on("mousemove", ".list", function () {
        $(".list").css('background-color', '#fff');
        $(".list").css('border-right', 'none');


        $(".list").removeClass("list2");

        $(this).css('border-right', '2px solid #002bc3');

        $(this).css('background-color', '#4C99BF');
        $(this).toggleClass("list2");

    });

</script>
@if(Session::get('message')!='')
    <script>
        jQuery.noticeAdd({
            text: '{{ Session::get('message') }}',
            stay: false,
            type: '{{ Session::get("mestype") }}'
        });
        /
        if (Session::get('message') == 'کاربر ناشناس') {
            /            window.location = "{{App::make('url')->to('/')}}/
            Logout
            ";
            /
        }
    </script>

@endif

@include('index.helper.newbanader_inline_js')

</body>
</html>