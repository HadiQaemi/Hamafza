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
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3f39cf">پژوهش</div>
            <div class="panel-body no-padding mCustomScrollbar" style="height: 400px;">
                <ul class="underlined_menu nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1">پایان نامه</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_2">طرح های پژوهشی</a>
                    </li>
                    @foreach ($List_tabs_research as $key => $value)
                        <li >
                            <a data-toggle="tab" data_id="{{$value->id}}" href="#tab_{{$key+3}}">{{$value->title}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <div id="tab_1" class="tab-pane fade in active">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    <ul class="list-unstyled">
                                        @if (count($paya) > 0)
                                            @foreach ($paya as $item)
                                                <li class="col-md-12 no-padding" style="margin-bottom: 2px;">
                                                    <div class="col-md-3">
                                                        @if ($item->DefImageUrl)
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{$item->DefImageUrl}}">
                                                        @else
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(-1)])}}">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h3 class="no-margin" style="text-align:justify;font-size: 12px;">
                                                            <a title="{{$item->title}}" href="{{url(isset($item->pages[0]) ? $item->pages[0]->id : '')}}">{{mb_substr($item->title,0,70, "utf-8").'...'}}</a>
                                                        </h3>
                                                        <p class="no-margin">
                                                            @if (isset($item->pages[0]))
                                                                @if ($item->pages[0]->description)
                                                                    {{mb_substr($item->pages[0]->description,0,120, "utf-8").'...'}}
                                                                @endif
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
                    <div id="tab_2" class="tab-pane">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    <ul class="list-unstyled">
                                        @if (count($tarh) > 0)
                                            @foreach ($tarh as $item)
                                                <li class="col-md-12 no-padding" style="margin-bottom: 2px;">
                                                    <div class="col-md-3">
                                                        @if ($item->DefImageUrl)
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{$item->DefImageUrl}}">
                                                        @else
                                                            <img title="{{$item->title}}" style="width: 100%; height: 75px; border:1px dashed #eee;" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(-1)])}}">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-9">
                                                        <h3 class="no-margin" style="text-align:justify; font-size: 12px;">
                                                            <a title="{{$item->title}}" href="{{url(isset($item->pages[0]) ? $item->pages[0]->id : '')}}">{{mb_substr($item->title,0,70, "utf-8").'...'}}</a>
                                                        </h3>
                                                        <p class="no-margin">
                                                            @if (isset($item->pages[0]))
                                                                @if ($item->pages[0]->description)
                                                                    {{mb_substr($item->pages[0]->description,0,120, "utf-8").'...'}}
                                                                @endif
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
                    @foreach ($List_tabs_research as $key => $value)
                        <div id="tab_{{$key+3}}" class="tab-pane">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    @if (isset($value->items ) && $value->items->count())
                                        @foreach ($value->items as $item)
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                                <a href="@foreach ($item->attrs as $attr)@if ($attr->pivot->basicdata_attribute_id==12){{$attr->pivot->value}} @endif @endforeach" target="_blank">
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "
                                                         src="@foreach ($item->attrs as $attr)@if ($attr->pivot->basicdata_attribute_id==13) {{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(($attr->pivot->value) ? $attr->pivot->value:-1)])}} @endif @endforeach"
                                                         class="img-responsive">
                                                    <span> {{$item->title}}  </span>
                                                </a>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3acfe3;">فعالان حمل و نقل دریایی</div>
            <div class="panel-body no-padding text-center mCustomScrollbar" style="height: 400px;">
                <ul class="nav nav-tabs underlined_menu">
                    @foreach ($List_Tabs as $key => $value)
                        <li class="@if ($key == 0) active @endif">
                            <a data-toggle="tab" class="btn_show_tab_contents" data_id="{{$value->id}}" href="#networks_tab_{{$key+1}}">{{$value->title}}</a>
                        </li>
                    @endforeach
                    <li>
                        <a data-toggle="tab" href="#networks_static_tab_5">کانال ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_static_tab_6">گروه‌ها</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#networks_static_tab_7">کاربران </a>
                    </li>
                </ul>
                <div class="tab-content">
                    @foreach ($List_Tabs as $key => $value)
                        <div id="networks_tab_{{$key+1}}" class="tab-pane fade in @if ($key==0) active @endif">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    @if (isset($value->items ) && $value->items->count())
                                        @foreach ($value->items as $item)
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                                <a href="@foreach ($item->attrs as $attr)@if ($attr->pivot->basicdata_attribute_id==10){{$attr->pivot->value}} @endif @endforeach" target="_blank">
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "
                                                         src="@foreach ($item->attrs as $attr)@if ($attr->pivot->basicdata_attribute_id==11) {{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(($attr->pivot->value) ? $attr->pivot->value:-1)])}} @endif @endforeach"
                                                         class="img-responsive">
                                                    <span> {{$item->title}}  </span>
                                                </a>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div id="networks_static_tab_5" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    @if (isset($Channels) && count($Channels)>0)
                                        @foreach ($Channels as $item)
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                                <a href="{{App::make('url')->to('/')}}/{{$item->link}}">
                                                    @php
                                                    $pic = 'pics/group/Groups.png';
                                                    if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                                                        $pic = 'pics/group/' . $item->pic;
                                                    @endphp
                                                    <img style="width:80px; height: 80px; margin:auto;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; " src="{{$pic}}" class="img-responsive">
                                                    <span style="font-size: 11px; display: inline-block;">{{$item->name}}</span></a>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="networks_static_tab_6" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div style="padding: 5px;">
                                    @if (count($Groups)>0)
                                        @foreach ($Groups as $item)
                                            <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
                                                <a href="{{App::make('url')->to('/')}}/{{$item->link}}">
                                                    @php
                                                    $pic = 'pics/group/Groups.png';
                                                    if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                                                    {
                                                        $pic = 'pics/group/' . $item->pic;
                                                    }
                                                    @endphp
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
                    <div id="networks_static_tab_7" class="tab-pane fade in">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div>
                                    @if ( isset($Users) )
                                        @foreach ($Users as $user)
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
                </div>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
</div>
<div class="row">
    <!--
    {{--
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3f39cf;">اخبار</div>
            <div class="panel-body no-padding mCustomScrollbar" id="homepage_news" style="height: 400px; ">
                @if (count($news_tabs))
                    <ul class="nav nav-tabs underlined_menu">
                        <?php $j = 0 ?>
                        @foreach ($news_tabs as $key => $tab)
                            @if ($j == 0)
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
                        @foreach ($news_tabs as $tab)
                            @if ($i == 1)
                                <?php $class = 'active'; ?>
                            @else
                                <?php $class = ''; ?>
                            @endif
                            <div id="news_{{ $tab->id }}" class="tab-pane fade in {{ $class }}">
                                {!! homepage_news($tab) !!}
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
    --}}
    -->
    <div class="col-sm-6">
        <div class="panel panel-banader-index">
            <div class="panel-heading text-center" style="font-size: 14px; background-color: #3acfe3;">آمار</div>
            <div class="panel-body no-padding mCustomScrollbar" style="height: 400px;">
                <div id="chart_statistics" style="direction: ltr; text-align: center;"></div>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
</div>
<div class="space-30"></div>
