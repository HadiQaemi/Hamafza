<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
?>
@extends('api.master')
@section('css')
<link type="text/css" rel="stylesheet" href="{{$base_url. '/assets/css/reset-browser.css'}}"/>
<link rel="stylesheet" type="text/css" href="{{$base_url.'/theme/Content/css/jquery.ui.datepicker1.8-all.css'}}" />
<link rel="stylesheet" type="text/css" href="{{$base_url.'/assets/Packages/bootstrap/css/bootstrap.css'}}"/>
<link rel="stylesheet" type="text/css" href="{{$base_url.'/assets/Packages/bootstrap/css/bootstrap-rtl.css'}}"/>
<link rel="stylesheet" type="text/css" href="{{$base_url.'/theme/Content/css/content.css'}}"/>
<link rel="stylesheet" type="text/css" href="{{$base_url.'/theme/Content/css/public.css'}}"/>
<link href='http://www.fontonline.ir/css/BZar.css' rel='stylesheet' type='text/css'>

<style>
    body {
        overflow: auto;
        background:  #fff;
        font-size: 1.4em;
        font-family: BZar,'BZar',tahoma;;
        margin: 10px 20px 10px 20px;
    }
    img {
        max-width: 100%;
        max-height: 100%;
        height: inherit !important;
    }
</style>
@stop

@section('content')
<div id = "TextSection">{!! $content_main !!}</div>
@stop