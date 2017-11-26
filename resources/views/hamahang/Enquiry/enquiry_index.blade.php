@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('inline_style')
    @include('hamahang.Enquiry.helper.css')
@stop
@section('content')
    @include('hamahang.Enquiry.helper.content')
@stop

@section('inline_scripts')
    @include('hamahang.Enquiry.helper.common-js')
    @include('hamahang.Enquiry.helper.js')
@stop
@section('position_right_col_3')
    @include('hamahang.Enquiry.helper.sidebar')
@stop

@include('sections.tabs')
