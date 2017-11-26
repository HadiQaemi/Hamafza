@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
@stop
@section('content')
    <div class="row margin-top-20">
        <div class="col-xs-12 line-height-30"></div>
        <div class="clearfix"></div>
    </div>
    <div class="row-fluid">
        <div class="col-lg-12">
            <table id="OrgChartsGrid" class="table table-striped table-bordered dt-responsive nowrap display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <th>{{ trans('org_chart.creator') }}</th>
                    <th>{{ trans('org_chart.organ') }}</th>
                    <th>{{ trans('app.title') }}</th>
                    <th>{{ trans('org_chart.create') }}</th>
                    <th>{{ trans('app.action') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>{{ trans('app.id') }}</th>
                    <th>{{ trans('org_chart.creator') }}</th>
                    <th>{{ trans('org_chart.organ') }}</th>
                    <th>{{ trans('app.title') }}</th>
                    <th>{{ trans('org_chart.create') }}</th>
                    <th>{{ trans('app.action') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        $(document).ready(function () {
            $('#OrgChartsGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{!! URl::route('hamahang.org_chart.ajax_org_charts',['OrgID'=>$OrgID]) !!}",
                    "type": "POST"
                },
                "language": window.LangJson_DataTables,
                "processing": true,
                columns: [
                    {"data": "id"},
                    {"data": "uid"},
                    {"data": "org_organs_id"},
                    {"data": "title"},
                    {"data": "description"},
                    {"data": "created_at"}
                ]
            });
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
