@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{ URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css') }}">
@stop

@include('hamahang.Scheduler.helper.content')

@section('specific_plugin_scripts')
    @include('hamahang.Scheduler.helper.js-plugins')
@stop
@section('inline_scripts')
    @include('hamahang.Scheduler.helper.js-inline')
@stop
