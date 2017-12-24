@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
@stop
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="tab-content">
                <table id="help_grid" width="100%" class="table table-condensed table-bordered table-striped table-hover td-center-align">
                    <thead>
                    <tr>
                        <th>{{trans('help.row')}}</th>
                        <th>{{trans('help.title')}}</th>
                        <th>{{trans('help.help_id')}}</th>
                        <th>{{trans('help.usages')}}</th>
                        <th>{{trans('help.see_also')}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="clearfixed"></div>
    </div>
@stop
@section('specific_plugin_scripts')
    {{--    <script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>--}}
@stop
@section('inline_scripts')
    @include('hamahang.help.helpers.js')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop