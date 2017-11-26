@extends('layouts.master')

{{--
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
--}}

@section('inline_style')
    @include('hamahang.news.helper.css')
@stop



@section('content')
    @include('hamahang.news.helper.content')
@stop

@section('position_right_col_3')
    @include('hamahang.news.helper.sidebar')
@stop



@section('inline_scripts')
    @include('hamahang.news.helper.common-js')
    @include('hamahang.news.helper.js')
@stop

@include('sections.tabs')
