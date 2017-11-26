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
    </style>
    <div class="row" style="background-color:#eee; ">
        @foreach($desktop_sections as $section)
            <div class="row">
                @foreach($section['data'] as $sub_section)
                    @if($sub_section['active'])
                        <div class="col-lg-4">
                            <div class="dashboard_box panel panel-default" style="margin-bottom: 10px">
                                <table>
                                    <tr>
                                        <td class="dashboard_box_icon">
                                            <i class="fa fa-5x {{$sub_section['icon']}}"></i>
                                        </td>
                                        <td class="dashboard_box_content">
                                            <div class="number">
                                                <a href="{{$sub_section['url']}}">{{$sub_section['value']}}</a>
                                            </div>
                                            <div class="title">{{$sub_section['title']}}</div>
                                        </td>
                                    </tr>
                                </table>
                                @if($sub_section['new']!=-1)
                                    <div class="dashboard_box_new_number">
                                        <span>{{$sub_section['new']}}</span>
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="col-lg-4">
                            <div class="dashboard_box panel panel-default dashboard_box_disabled" style="margin-bottom: 10px">
                                <table>
                                    <tr>
                                        <td class="dashboard_box_icon">
                                            <i class="fa fa-5x {{$sub_section['icon']}}"></i>
                                        </td>
                                        <td class="dashboard_box_content">
                                            <div class="number">
                                                <a href="#{{$sub_section['url']}}">{{$sub_section['value']}}</a>
                                            </div>
                                            <div class="title">{{$sub_section['title']}}</div>
                                        </td>
                                    </tr>
                                </table>
                                @if($sub_section['new']!=-1)
                                    <div class="dashboard_box_new_number">
                                        <span>{{$sub_section['new']}}</span>
                                        <i class="fa fa-arrow-up"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="clearfixed"></div>
            </div>
        @endforeach
    </div>
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop