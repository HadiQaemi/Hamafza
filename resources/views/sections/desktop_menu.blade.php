@if(isset($desktop_menu))
    {!! $desktop_menu !!}
@else
    {!! menuGenerator(1,'tree') !!}
@endif