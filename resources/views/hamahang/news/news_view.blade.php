@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{ url('assets/Packages/DataTables/datatables.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ url('theme/Content/css/wall.css') }}">
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{ url('theme/Scripts/snetwork.js') }}"></script>
@stop
@section('inline_style')
    @include('hamahang.Enquiry.helper.css')
@stop
@section('content')
    @include('hamahang.Enquiry.helper.view')
@stop

@section('inline_scripts')
    @include('hamahang.Enquiry.helper.common-js')
    @include('hamahang.Enquiry.helper.view_js')
@stop
@section('position_right_col_3')
    @include('hamahang.Enquiry.helper.sidebar')
@stop
@include('sections.tabs')

