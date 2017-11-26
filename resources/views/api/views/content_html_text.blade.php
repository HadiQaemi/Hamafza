@extends('api.master')
@section('css')
    <link type="text/css" rel="stylesheet" href="https://srfatemi.ir/assets/css/reset-browser.css"/>
    <link rel="stylesheet" type="text/css" href="https://srfatemi.ir/theme/Content/css/jquery.ui.datepicker1.8-all.css" />
    <link rel="stylesheet" type="text/css" href="https://srfatemi.ir/assets/Packages/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="https://srfatemi.ir/assets/Packages/bootstrap/css/bootstrap-rtl.css"/>
    <link rel="stylesheet" type="text/css" href="https://srfatemi.ir/theme/Content/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="https://srfatemi.ir/theme/Content/css/content.css"/>
@stop

@section('content')
<div>{!! $content_main !!}</div>
@stop