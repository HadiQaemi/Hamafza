@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('inline_style')
    @include('hamahang.Enquiry.helper.css')
@stop
@section('content')
    @if (3 == $sub_kind)
        @include ('hamahang.Enquiry.helper.content_idea')
    @elseif (4 == $sub_kind)
        @include ('hamahang.Enquiry.helper.content_experience')
    @else
        @include ('hamahang.Enquiry.helper.content')
    @endif
@stop

@section('inline_scripts')
    @include('hamahang.Enquiry.helper.common-js')
    @include('hamahang.Enquiry.helper.js')
@stop
@section('position_right_col_3')
    @include('hamahang.Enquiry.helper.sidebar')
@stop

@include('sections.tabs')
