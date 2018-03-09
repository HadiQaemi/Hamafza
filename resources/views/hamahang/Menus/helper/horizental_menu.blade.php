<style>
    #header .quick-links .res-li {
        padding: 0px 10px;
    }
    #header .quick-links .res-li {
        padding: 0px 10px;
        border-bottom: 1px solid #FFF;
    }
    #header .quick-links .res-a {
        font-size: 15px;
    }

</style>
<ul class="nav navbar-nav navbar-right quick-links-res hidden-xs hidden-sm">
    @foreach($menus as $menu)
        <li><a href="{{$menu->href}}">{{$menu->title }}</a></li>
    @endforeach
</ul>
<ul class="nav navbar-nav navbar-right quick-links-res hidden-sm hidden-md hidden-lg">
    @foreach($menus as $menu)
        <li class="res-li" ><a class="res-a" href="{{$menu->href}}">{{$menu->title }}</a></li>
    @endforeach
</ul>
@php ($logged_in = session('Login') && session('Login') == 'TRUE')
@php ($style = $logged_in ? null : 'style="display: none;"')
@php ($unstyle = $logged_in ? null : 'style="width: 32%;"')
<ul class="nav navbar-nav quick-links quick-links-res hidden-sm hidden-md hidden-lg" style="margin-top: 20px">
    <li href="#tab1" class="res-li" {!! $style !!}><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">چوب‌های الف</span></a></li>
    <li href="#tab2" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">درگاه‌ها</span></a></li>
    <li href="#tab3" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">کلید واژه‌ها</span></a></li>
    <li href="#tab4" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">جستجو</span></a></li>
</ul>
@if(auth()->check())
    <ul class="nav navbar-nav quick-links-res hidden-lg hidden-md hidden-sm" style="margin-top: 15px;">
        <li href="#tab2" class="res-li">
            {{--<a href="#" id="avatar" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
            {{--{{ auth()->user()->Name .' '. auth()->user()->Family }}--}}
            {{--<span class="caret"></span>--}}
            {{--<img class="img-circle img-responsive jsPanels" href="{{route('modals.profile_avatar')}}" src="{{ auth()->user()->avatar_link }}"/>--}}
            {{--</a>--}}
            <a class="res-a" href="{{App::make('url')->to('/')}}/{{ auth()->user()->Uname }}">درباره</a>
        </li>
        <li href="#tab2" class="res-li">
            <a class="res-a" href="{{ url(auth()->user()->Uname . '/wall') }}" class="wall">دیوار @if(user_notifications_count('wall', auth()->id()) > 0)<span class="badge">{{ user_notifications_count('wall', auth()->id()) }}</span>@endif</a>
        </li>
        <li href="#tab2" class="res-li">
            <a class="res-a" href="{{ url(auth()->user()->Uname . '/desktop') }}" class="wall">میز کار @if(user_notifications_count('', auth()->id()) > 0)<span class="badge DesktopNotificaton">{{ user_notifications_count('', auth()->id()) }}</span>@endif</a>
        </li>
    </ul>
@endif
<ul class="nav navbar-nav quick-links-res hidden-sm hidden-md hidden-lg" style="margin-top: 20px">
    @if(auth()->check())
        <li href="#tab2" class="res-li">
            <a id="UserSet" class="jsPanels res-a" href="{{App::make('url')->to('/')}}/modals/setting?sid={{ auth()->user()->id }}&type=user" title="تنظیمات"> مشخصات</a>
        </li>
        <li href="#tab2" class="res-li">
            <a href="{{App::make('url')->to('/')}}/Logout" class="pull-left exit res-a">خروج</a>
        </li>
    @else
        <li class="login" data-toggle="modal" data-target="#login">ورود</li>
        <li class="register" data-toggle="modal" data-target="#register">ثبت نام</li>
    @endif
</ul>