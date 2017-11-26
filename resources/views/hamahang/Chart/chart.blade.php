@extends('layouts.master')
@section('specific_plugin_scripts')@stop
@section('content')
    <div class="col-xs-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="highchartfont" id="container" style="min-width: 310px; height: 400px; margin: 0 auto ;direction:ltr"></div>
            </div>
        </div>
    </div>
@stop
@section('inline_scripts')
    @include('hamahang.Chart.helper.chart_inline_js')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop