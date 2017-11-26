@extends('layouts.master')
@section('content')
    <div class="panel-body text-decoration">
        <div class='text-content'>
            <form method="get" action="{{App::make('url')->to('/')}}/{{Session::get('Uname')}}/desktop/user_list?sr=">
                <div style="padding: 5px;">
                    <input type="text" value="{{$sr}}" id="list-search" name="sr" placeholder="غربال بر اساس نام، نام خانوادگی و یا نام کاربری" style="display: inline-block ;max-width: 300px;">
                    <button type="submit" class="btn" name="search" value="ok">بیاب</button>
                </div>
            </form>
            {!!$content!!}
        </div>
    </div>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
