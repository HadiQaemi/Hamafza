<?php $menu = explode(',', config('constants.APP_STATIC_TOP_MENU')); ?>
<div class="navbar-header col-xs-12 col-sm-7 rtl-navbar">
    @if(isset($error))
        <a class="navbar-brand rtl-brand" href="{{App::make('url')->to('/')}}" style="padding: inherit !important; height: 47px!important; margin-right: 80%">
            <span style="font-size: 20px;">{{ config('constants.SiteFullTitle') }}</span>
            <img class="logo" src="{{App::make('url')->to('/')}}/{{ config('constants.SiteLogo') }}">
        </a>

    @else
        <a class="navbar-brand rtl-brand" href="{{App::make('url')->to('/')}}" style="padding: inherit !important; height: 47px!important;">
            <span style="font-size: 20px;">{{ config('constants.SiteFullTitle') }}</span>
            <img class="logo" src="{{App::make('url')->to('/')}}/{{ config('constants.SiteLogo') }}">
        </a>
        <ul class="nav navbar-nav navbar-right col-xs-6">
            @foreach($menu as $item)
                <?php $e_item = explode('-', $item) ?>
                <li><a href="{{ $e_item[1] }}">{{ $e_item[0]  }}</a></li>
            @endforeach
        </ul>
    @endif
</div>