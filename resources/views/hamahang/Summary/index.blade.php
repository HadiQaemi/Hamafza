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
            <table id="grid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
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
