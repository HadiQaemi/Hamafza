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
    @if (1 == $sub_kind)
        @include ('hamahang.Enquiry.helper.view_comment')
    @elseif (3 == $sub_kind)
        @include ('hamahang.Enquiry.helper.view_idea')
    @elseif (4 == $sub_kind)
        @include ('hamahang.Enquiry.helper.view_experience')
    @else
        @include('hamahang.Enquiry.helper.view')
    @endif
@stop

@section('inline_scripts')
    @include('hamahang.Enquiry.helper.common-js')
    @include('hamahang.Enquiry.helper.view_js')
@stop
@section('position_right_col_3')
    @include('hamahang.Enquiry.helper.sidebar')
@stop
@include('sections.tabs')

