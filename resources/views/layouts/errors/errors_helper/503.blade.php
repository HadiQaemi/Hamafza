@extends('layouts.errors.index')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/error_pages.css')}}">
@stop
@section('html_class','banader banader_homepage')
@section('content')
    <div class="error_title">
        <div class="error_title_inner">در حال به ‌روز رسانی...</div>
    </div>
@stop
