@extends('layouts.master')
@section('content')
    <div class="panel-body text-decoration">
        <div class='text-content'>
            {!!$content!!}
        </div>
    </div>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

