@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" type="text/css" media="all" href="{{url('/theme/Content/css/wall.css')}}" title="Aqua"/>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{url('/theme/Scripts/snetwork.js')}}"></script>
@stop
@section('content')
    <style>
        .panel-heading
        {
            display: none;
        }
        #pcol_32{
            padding-right: 0px !important;
            direction: rtl !important;
        }
        .scrl{
            margin-top: -5px !important;
        }
    </style>
    <div class="row" style="background-color:#eee; ">

        @foreach($desktop_sections as $section)
            <div class="row">
                @foreach($section['data'] as $sub_section)
                    @if($sub_section['active'])
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            {{--<div class="dashboard_box panel panel-default" style="margin-bottom: 10px">--}}
                                {{--<table>--}}
                                    {{--<tr>--}}
                                        {{--<td class="dashboard_box_icon">--}}
                                            {{--<i class="fa fa-5x {{$sub_section['icon']}}"></i>--}}
                                        {{--</td>--}}
                                        {{--<td class="dashboard_box_content">--}}
                                            {{--<div class="number">--}}
                                                {{--<a href="{{$sub_section['url']}}">{{$sub_section['value']}}</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="title">{{$sub_section['title']}}</div>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--</table>--}}
                                {{--@if($sub_section['new']!=-1)--}}
                                    {{--<div class="dashboard_box_new_number">--}}
                                        {{--<span>{{$sub_section['new']}}</span>--}}
                                        {{--<i class="fa fa-arrow-up"></i>--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                            <div class="desktop-tool">
                                <i class="img-responsive fa fa-4x {{$sub_section['icon']}}"></i>
                                <ul class="text-desktop-tool">
                                    <li id="text-desktop-tool" class="text-center"><a href="{{$sub_section['url']}}">{{$sub_section['value']}}</a></li>
                                    <li id="text-desktop-tool" class="text-center">{{$sub_section['title']}}</li>
                                </ul>
                                @if($sub_section['new']!=-1)
                                    <span class="badge">{{$sub_section['new']}}</span>
                                @endif
                            </div>
                        </div>
                    @else
                        {{--<div class="col-lg-4">--}}
                            {{--<div class="dashboard_box panel panel-default dashboard_box_disabled" style="margin-bottom: 10px">--}}
                                {{--<table>--}}
                                    {{--<tr>--}}
                                        {{--<td class="dashboard_box_icon">--}}
                                            {{--<i class="fa fa-5x {{$sub_section['icon']}}"></i>--}}
                                        {{--</td>--}}
                                        {{--<td class="dashboard_box_content">--}}
                                            {{--<div class="number">--}}
                                                {{--<a href="#{{$sub_section['url']}}">{{$sub_section['value']}}</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="title">{{$sub_section['title']}}</div>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--</table>--}}
                                {{--@if($sub_section['new']!=-1)--}}
                                    {{--<div class="dashboard_box_new_number">--}}
                                        {{--<span>{{$sub_section['new']}}</span>--}}
                                        {{--<i class="fa fa-arrow-up"></i>--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="desktop-tool dashboard_box_disabled">
                                <i class="img-responsive fa fa-4x {{$sub_section['icon']}}"></i>
                                <ul class="text-desktop-tool">
                                    <li id="text-desktop-tool" class="text-center"><a href="{{$sub_section['url']}}">{{$sub_section['value']}}</a></li>
                                    <li id="text-desktop-tool" class="text-center">{{$sub_section['title']}}</li>
                                </ul>
                                @if($sub_section['new']!=-1)
                                    <span class="badge">{{$sub_section['new']}}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="clearfixed"></div>
            </div>
        @endforeach
    </div>
    {{--<div class="ContentSec">{!!$content!!}</div>--}}
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
