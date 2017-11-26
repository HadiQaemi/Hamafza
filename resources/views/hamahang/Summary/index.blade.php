@extends('layouts.master')

@section('specific_plugin_style')
@stop

@section('content')
    <div >
        <div >
            <style>
                .floatleft
                {
                    float: left;
                    text-align: left;
                }
            </style>
            <table id="grid" width="100%" class="table table-condensed table-striped table-hover" style="text-align: right;">
                <thead>
                    <th style="text-align: right; width: 55%">{{ trans('tools.title') }}</th>
                    <th style="text-align: right; width: 20%">{{ trans('tools.count') }}</th>
                    <th style="text-align: right; width: 25%">{{ trans('tools.total') }}</th>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('specific_plugin_scripts')
@stop

@section('inline_scripts')
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('hamahang.Summary.helper.list')
    @include('sections.desktop_menu')
@stop
