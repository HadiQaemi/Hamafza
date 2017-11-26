@extends('layouts.master')



{{--@section('specific_plugin_style') <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}"> @stop--}}
@section('inline_style') @include('hamahang.Bazaar.helper.bazaar-css') @stop
@section('inline_scripts') @include('hamahang.Bazaar.helper.bazaar-js') @stop


{{--

@section('position_right_col_3')
    @include('hamahang.Bazaar.helper.bazaar-sidebar')
@stop
--}}



@section('content')
    @include('hamahang.Bazaar.helper.bazaar-content')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop