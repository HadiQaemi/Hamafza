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
    #header .quick-links-res .res-li {
        padding: 0px 10px;
    }
    #header .quick-links-res .res-li {
        padding: 0px 10px;
        border-bottom: 1px solid #FFF;
    }
    #header .quick-links-res .res-a {
        font-size: 15px;
    }
    #header .quick-links-res  {
        margin-top: 20px;
    }






    #header .quick-links-res {
        margin-left: 10px;
        margin-bottom: 0;
    }

    @media screen and (min-width: 480px) {
        #header .quick-links-res {
            margin-left: 20px;
        }
    }

    #header .quick-links-res li {
        float: right;
    }

    #header .quick-links-res a {
        font-size: 18px;
        color: #fff;
        cursor: pointer;
        line-height: 28px;
    }

    #header .quick-links-res a:hover {
        opacity: 0.8;
    }




</style>
<ul class="nav navbar-nav navbar-right hidden-xs">
    @foreach($menus as $menu)
        <li><a href="{{$menu->href}}">{{$menu->title }}</a></li>
    @endforeach
</ul>
<ul class="nav navbar-nav navbar-right quick-links-res hidden-sm hidden-md hidden-lg">
    @foreach($menus as $menu)
        <li class="res-li"><a href="{{$menu->href}}">{{$menu->title }}</a></li>
    @endforeach
</ul>
@php ($logged_in = session('Login') && session('Login') == 'TRUE')
@php ($style = $logged_in ? null : 'style="display: none;"')
@php ($unstyle = $logged_in ? null : 'style="width: 32%;"')
<ul class="nav navbar-nav quick-links quick-links-res hidden-sm hidden-md hidden-lg">
    <li href="#tab1" class="res-li" {!! $style !!}><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">چوب‌های الف</span></a></li>
    <li href="#tab2" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">درگاه‌ها</span></a></li>
    <li href="#tab3" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">کلید واژه‌ها</span></a></li>
    <li href="#tab4" class="res-li"><a class="res-a"><span class="" title="" data-placement="top" data-toggle="tooltip">جستجو</span></a></li>
</ul>
<ul class="nav navbar-nav quick-links-res hidden-sm hidden-md hidden-lg">
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