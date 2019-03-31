@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <style>
        .base_tabs{
            padding: 10px;
        }
    </style>
    <div class="row-fluid">
        <div class="space-10"></div>
        <div class="col-xs-12">
            <fieldset>
                <div id="OrgList">
                    {{--<legend>--}}
                        {{--<h3>--}}
{{--                            <span>{{ trans('org_chart.organizations_list') }}</span>--}}
{{--                            <a href="{!! route('modals.assign_new_staff') !!}" class="jsPanels btn btn-default pull-left jspa btn-primary btn fa fa-plus"></a>--}}
                            {{--<div class="clearfix"></div>--}}
                        {{--</h3>--}}
                    {{--</legend>--}}
                    <div class="row-fluid">
                        <div class="col-lg-12">
                            <table id="StaffListGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ trans('org_chart.clerk') }}</th>
                                    <th>{{ trans('org_chart.organization') }}</th>
                                    <th>{{ trans('org_chart.organizational_unit') }}</th>
                                    <th>{{ trans('org_chart.job') }}</th>
                                    <th>{{ trans('org_chart.post') }}</th>
                                    <th>{{ trans('app.action') }}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="clearfix"></div>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        var table_organs_grid = "";
        var table_chart_grid = "";
        var RowData = [];
        var cur_org_id = '';

        function organs_grid() {
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
            LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
            window.table_organs_grid = $('#StaffListGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "serverSide": false,
                "ajax": {
                    "url": "{!! URL::route('hamahang.org_chart.fetch_all_staff_list',['username'=>$UName]) !!}",
                    "type": "POST"
                },
                "bSort": true,
                "order": [[ 5, "desc" ]],
                "aaSorting": [],
                "bSortable": true,
                "autoWidth": false,
                "searching": false,
                "pageLength": 25,
                // "scrollY": 400,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    {"data": "user"},
                    {"data": "org"},
                    {"data": "item"},
                    {"data": "job"},
                    {"data": "post"},
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            var oid = full.oid;
                            var title = full.title;
                            var description=full.description;

                            window.RowData[id] = full;
                            return "<i class='fa fa-remove pointer'></i><i class='fa fa-edit pointer margin-right-10'></i>"
                        }
                    }
                ]
            });
        }

        $(document).ready(function () {
            organs_grid();
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
