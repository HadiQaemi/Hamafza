{{--{{ dd($chart_feed) }}--}}
<div class="row">
    <div class="pull-right" style="margin-right:1%; height: 438px; width: 20%;">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3f39cf;">...دایره المعارف دریایی...</div>
            <div class="panel-body no-padding">
                <div class="vertical_menu">
                    <ul class="no-margin">
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد اول - دریانوردی و سفر دریایی" href="{{url('360150/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/darya1.png')}}">
                                <b><span class="homepage_right_menu text-overflow-ellipsis-100">دریانوردی و سفر دریایی</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد دوم- ساختمان كشتی‌ها، رده‌بندی و بازرسی آن‌ها، تجهيزات و سيستمهای مكانيكی و الكترونيكی كشتی" href="{{url('360160/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/sakht.png')}}">
                                <b><span class="homepage_right_menu text-overflow-ellipsis-100">ساختمان كشتی‌ها</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد سوم - مهندسی ساحل، مدیریت سواحل، طراحی و مدیریت بنادر" href="{{url('360240/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/sahel.png')}}">
                                <b><span class="homepage_right_menu"> مدیریت ساحل و بندر</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد چهارم - اقیانوس شناسی و اهداف آن" href="{{url('360250/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/ocean.png')}}">
                                <b><span class="homepage_right_menu">اقیانوس‌شناسی واهداف</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد پنجم - شیمی، آلودگی و زمین شناسی دریا" href="{{url('360260/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/shimi.png')}}">
                                <b><span class="homepage_right_menu">شیمی، آلودگی و زمین شناسی‌</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد ششم- زیست شناسی دریا و شیلات" href="{{url('360270/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/zist.png')}}">
                                <b><span class="homepage_right_menu">زیست شناسی دریا</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد هفتم -اصول ناوبری وهدایت کشتی، آب‌نگاری، نقشه برداری و نقشه خوانی" href="{{url('360280/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/nav.png')}}">
                                <b><span class="homepage_right_menu"> اصول ناوبری کشتی</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;">
                            <a title="دایره المعارف دریایی و بندری: جلد هشتم- حمل و نقل دریایی و بیمه های دریایی" href="{{url('360290/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/haml.png')}}">
                                <b><span class="homepage_right_menu">حمل ونقل و بیمه دریایی</span></b>
                            </a>
                        </li>
                        <li style="height: 45px;" class="list">
                            <a title="دایره المعارف دریایی و بندری: جلد نهم- حقوق و قوانین تجارت دریایی، اقتصاد دریایی" href="{{url('360300/OnlyTree')}}">
                                <img src="{{url('theme/newbanader/icons/law.png')}}">
                                <b><span class="homepage_right_menu"> قوانین تجارت دریایی</span></b>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pull-right" style="margin-right:1%; height: 445px; width: 49%;">
        {!! homepage_slider() !!}
    </div>
    <div class="pull-right" style="margin-right:1%; height: 445px; width: 27%">
        <div class="panel panel-banader-index" style="height: 100%;">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3acfe3;">...تبلیغات...</div>
            <div class="panel-body no-padding banader-ads text-center">
                {!! homepage_ads() !!}
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
</div>
<div class="row">
    <div class="space-10"></div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3f39cf;">اخبار</div>
            <div class="panel-body no-padding mCustomScrollbar" id="homepage_news" style="height: 400px; ">
                @if(count($news_tabs))
                    <ul class="nav nav-tabs underlined_menu">
                        <?php $j = 0 ?>
                        @foreach($news_tabs as $key => $tab)
                            @if($j == 0)
                                <?php $class = 'active'; ?>
                            @else
                                <?php $class = ''; ?>
                            @endif
                            <li class="{{ $class }}">
                                <a data-toggle="tab" href="#news_{{$tab->id}}">{{ $tab->title }}</a>
                            </li>
                            <?php $j++ ?>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <?php $i = 1 ?>
                        @foreach($news_tabs as $tab)
                            @if($i == 1)
                                <?php $class = 'active'; ?>
                            @else
                                <?php $class = ''; ?>
                            @endif
                            <div id="news_{{ $tab->id }}" class="tab-pane fade in {{ $class }}">
                                {{--*************************************************--}}
                                {{-------------------- Tab Content --------------------}}
                                {{--*************************************************--}}
                                {{--                                {{ dd($keyword) }}--}}
                                {!! homepage_news($tab) !!}
                                {{--*************************************************--}}
                                {{-------------------- Tab Content --------------------}}
                                {{--*************************************************--}}

                            </div>
                            <?php $i++ ?>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding-top: 10px;">
                        <span>داده‌های اولیه اخبار تنظیم نشده است.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3acfe3;">شبکه اجتماعی</div>
            <div class="panel-body no-padding text-center mCustomScrollbar" style="height: 400px;">
                <ul class="nav nav-tabs underlined_menu">
                    <li class="active">
                        <a data-toggle="tab" href="#networks_tab_3">سازمان‌ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_tab_4">شرکت‌ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_tab_5">انجمن ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_tab_6">دانشگاه ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_tab_7">کانال ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_tab_2">گروه‌ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_tab_1">کاربران </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="networks_tab_1" class="tab-pane fade in active">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    @if( isset($Users) )
                                        @foreach($Users as $user)
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                                <div>
                                                    {!! $user->LargAvatar !!}
                                                </div>
                                                <div>
                                                    <a href="{{App::make('url')->to('/')}}/{{$user->Uname}}">
                                                        <span style="display: inline-block;">{{$user->Name}} {{$user->Family}}</span>
                                                    </a>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="space-4"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="networks_tab_2" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">
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
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">

                                                    <span style="display: inline-block;">{{$item->name}}</span></a>
                                                <div class="clearfix"></div>
                                            </div>

                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="networks_tab_3" class="tab-pane fade in active">
                        <div class="panel panel-white">
                            <div class="panel-body">
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
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">

                                                    <span style="display: inline-block;">{{$item->name}}</span></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="networks_tab_4" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">
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
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">
                                                    <span style="display: inline-block;">{{$item->name}}</span></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="networks_tab_5" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">

                            </div>
                        </div>
                    </div>
                    <div id="networks_tab_6" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">

                            </div>
                        </div>
                    </div>
                    <div id="networks_tab_7" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    @if(isset($Channels) && count($Channels)>0)
                                        @foreach($Channels as $item)
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                                <a href="{{App::make('url')->to('/')}}/{{$item->link}}">
                                                    <?php
                                                    $pic = 'pics/group/Groups.png';
                                                    if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                                                        $pic = 'pics/group/' . $item->pic;
                                                    ?>
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">
                                                    <span style="display: inline-block;">{{$item->name}}</span></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3f39cf">پژوهش</div>
            <div class="panel-body no-padding mCustomScrollbar" style="height: 400px;">
                <ul class="underlined_menu nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1">نشریات</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_2">پایان‌نامه</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_3">طرح‌های پژوهشی</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_4">کتابخانه دیجیتال</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab_1" class="tab-pane fade in active">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div id="home_nashriyat_tab">
                                    <div class="col-xs-4">
                                        <a href="{{ url('/367590') }}" target="_blank"><img src="{{url('theme/banader/images/masir.jpg')}}" class="img-responsive"></a>
                                        <span style="display: inline-block;">
                                            <a href="{{ url('/367590') }}" target="_blank">ماهنامه مسیر</a>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4">
                                        <a href="{{ url('/367600') }}" target="_blank">
                                            <img src="{{url('theme/banader/images/modiriatdanesh.jpg')}}" class="img-responsive">
                                            <span style="display: inline-block;">
                                                <span>ماهنامه امواج دانش</span>
                                            </span>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-4">
                                        <a href="{{ url('/367610') }}" target="_blank">
                                            <img src="{{url('theme/banader/images/sanat.jpg')}}" class="img-responsive">
                                            <span style="display: inline-block;">
                                                <span>نشریه صنعت حمل و نقل دریایی</span>
                                            </span>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab_2" class="tab-pane">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    <ul class="list-unstyled">
                                        @if(count($paya)>0)
                                            @foreach($paya as $item)
                                                <li class="col-md-12 no-padding" style="margin-bottom: 2px;">
                                                    <div class="col-md-3">
                                                        @if($item->defimage)
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode($item->defimage)])}}">
                                                        @else
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(-1)])}}">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h3 class="no-margin" style="text-align:justify;font-size: 12px;" >
                                                            <a title="{{$item->title}}" href="{{url($item->id)}}">{{mb_substr($item->title,0,70, "utf-8").'...'}}</a>
                                                        </h3>
                                                        <p class="no-margin">
                                                            @if($item->description)
                                                                {{mb_substr($item->description,0,120, "utf-8").'...'}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <h6 style="font-size: 12px; position: absolute; bottom: 25px; left: 25px;"><a href="{{url('/367720')}}">فهرست پایان‌نامه‌ها</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab_3" class="tab-pane">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    <ul class="list-unstyled">
                                        @if( count($tarh)>0)
                                            @foreach($tarh as $item)
                                                <li class="col-md-12 no-padding" style="margin-bottom: 2px;">
                                                    <div class="col-md-3">
                                                        @if($item->defimage)
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode($item->defimage)])}}">
                                                        @else
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(-1)])}}">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h3 class="no-margin" style="text-align:justify; font-size: 12px;">
                                                            <a title="{{$item->title}}" href="{{url($item->id)}}">{{mb_substr($item->title,0,70, "utf-8").'...'}}</a>
                                                        </h3>
                                                        <p class="no-margin">
                                                            @if($item->description)
                                                                {{mb_substr($item->description,0,120, "utf-8").'...'}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <h6 style="font-size: 12px; position: absolute; bottom: 25px; left: 25px;"><a href="{{url('/367730')}}">فهرست طرح های پژوهشی</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab_4" class="tab-pane">
                        <div class="panel panel-white">
                            <div class="panel-body text-center">
                                <img src="{{url('theme/newbanader/img/library.png')}}">
                                <h3>
                                    <a href="http://library.pmo.ir/faces/home.jspx" target="_blank">کتابخانه دیجیتال سازمان بنادر و دریانوردی</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3acfe3;">آمار</div>
            <div class="panel-body no-padding mCustomScrollbar" style="height: 400px;">
                <div id="chartss"></div>
                {{--<ul class="nav nav-tabs underlined_menu">--}}
                    {{--<li class="active">--}}
                        {{--<a data-toggle="tab" href="#statistic_tab_1">نمودار </a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a data-toggle="tab" href="#statistic_tab_2">نمودار موضوعات</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}

                {{--<div class="tab-content">--}}
                    {{--<div id="statistic_tab_1" class="tab-pane fade in active">--}}
                        {{--<div class="panel panel-white">--}}
                            {{--<div class="panel-body">--}}
                                {{--<div id="chartss"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div id="statistic_tab_2" class="tab-pane fade in">--}}
                        {{--<div class="panel panel-white">--}}
                            {{--<div class="panel-body">--}}
                                {{--<div id="statistic_subjects_container"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
</div>
<div class="space-30"></div>