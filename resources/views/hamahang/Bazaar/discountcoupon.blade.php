@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('inline_style')
    @include('hamahang.Bazaar.helper.discountcoupon-css')
@stop
@section('content')
    <div id="content" width="100%" style="padding: 10px;">
        @include('hamahang.Bazaar.helper.discountcoupon-content')
    </div>
@stop

@section('inline_scripts')
    @include('hamahang.Bazaar.helper.discountcoupon-js')
@stop
{{--@section('position_right_col_3')
    @include('hamahang.Bazaar.helper.discountcoupon-sidebar')
@stop--}}
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
