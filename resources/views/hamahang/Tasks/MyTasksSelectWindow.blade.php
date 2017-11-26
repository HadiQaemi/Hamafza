@extends('layout.master')

@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('page_title')
    TODO supply a title
@stop

@section('Specific_CSS_Plugin')

@stop

@section('content')

@stop

@section('SpecificJSPlugin')


@stop



@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop