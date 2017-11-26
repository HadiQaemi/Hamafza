@extends('layouts.master')

@section('content')
    <div class="basicdata_content" style="min-height: 250px;">
        <div class="loader"></div>
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.Basicdata.helper.js')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('hamahang.Basicdata.helper.sidebar')
    @include('sections.desktop_menu')
@stop
