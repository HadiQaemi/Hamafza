<div class="navbar-header col-xs-12 col-sm-7 rtl-navbar">
    <a class="navbar-brand rtl-brand" href="{{App::make('url')->to('/')}}" style="padding: inherit !important; height: 47px!important;">
        @if (auth()->check())<span style="font-size: 20px;">{{ config('constants.SiteFullTitle') }}</span>@endif
        <img class="logo" src="{{App::make('url')->to('/')}}/{{ config('constants.SiteLogo') }}">
    </a>
    {{--@foreach($menu as $item)--}}
    {{--<a href="{{App::make('url')->to('/')}}/{{ $item->pid }}">--}}
        {{--{!! $item->title !!}--}}
    {{--</a>--}}
    {{--@endforeach--}}
    @if (auth()->check())
        {!! menuGenerator(3, 'horizontal') !!}
    @endif
</div>