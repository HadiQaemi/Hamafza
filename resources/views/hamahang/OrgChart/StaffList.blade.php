@extends('layouts.master')

@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/OrgChart/dist/css/jquery.orgchart.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <style>
        .hd-body{
            overflow: hidden !important;
        }
        .base_tabs{
            padding: 10px;
        }
    </style>
    <div class="row-fluid">
        <div class="row" style="margin-top: -10px;background: #eee" >
            <form id="form_filter_priority">
                <div class="row padding-bottom-20 opacity-7">
                    <i class="fa fa-user int-icon3"></i>
                    <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                        <select id="organs_staff_search" name="organs_staff_search[]" class="select2_auto_complete_staff col-xs-12"
                                data-placeholder="{{trans('org_chart.search_some_staff')}}" multiple>
                        </select>
                    </div>
                    <i class="fa fa-sitemap int-icon2"></i>
                    <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                        <select id="organs_organs_search" class="select2_auto_complete_organs" name="select_org_lists[]"
                                data-placeholder="{{trans('org_chart.select_org_list')}}" multiple></select>
                    </div>
                    <i class="fa fa-sitemap int-icon1"></i>
                    <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                        <select id="organs_units_search" name="organs_units_search[]" class="select2_auto_complete_organ_units col-xs-12"
                                data-placeholder="{{trans('org_chart.search_some_unit')}}" multiple>
                        </select>
                    </div>
                </div>
                <div class="row padding-bottom-20 opacity-7">
                    <i class="fa fa-sitemap int-icon3"></i>
                    <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                        <select id="organs_jobs_search" name="organs_jobs_search[]" class="select2_auto_complete_onet_jobs_item col-xs-12"
                                data-placeholder="{{trans('org_chart.search_some_job')}}" multiple>
                        </select>
                    </div>
                    <i class="fa fa-sitemap int-icon2"></i>
                    <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                        <select id="organs_posts_search" name="organs_posts_search[]" class="select2_auto_complete_organ_posts col-xs-12"
                                data-placeholder="{{trans('org_chart.search_some_post')}}" multiple>
                        </select>
                    </div>
                    <div class="pull-right search-task-keywords margin-right-10 width-30-pre">

                    </div>
                </div>
            </form>
        </div>

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
                    {"data": "staff"},
                    {"data": "org"},
                    {"data": "item"},
                    {"data": "job"},
                    {"data": "post"},
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;

                            window.RowData[id] = full;
                            return "" +
                                "" +
                                "<a class='cursor-pointer jsPanels white-space margin-right-10' href='/modals/ViewStaffForm?sid="+full.staffId+"'><i class='fa fa-edit pointer'></i></a>" +
                                "<a class='cursor-pointer jsPanels white-space margin-right-10' href='/modals/ViewStaffDoc?sid="+full.staffId+"'><i class='fa fa-file-text-o pointer'></i></a>" +
                                "<i class='fa fa-remove pointer margin-right-10 remove_staff_position' title='حذف سمت' data-toggle='tooltip' ref=\" + full.staffId + \" add='{{ route('hamahang.org_chart.delete_staff_position') }}'></i>" +
                                "<i class='fa fa-trash pointer remove_staff margin-right-10 color_red' title='حذف کارمند' data-toggle='tooltip' ref=" + full.staffId + " add='{{ route('hamahang.org_chart.delete_staff') }}'></i>" +
                                ""
                        }
                    }
                ]
            });
        }
        $(".select2_auto_complete_organ_posts").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.org_charts_posts')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        item_id: $(this).attr('rel')
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(".select2_auto_complete_onet_jobs_item").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.onet_jobs_items')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term,
                        item_id: $(this).attr('rel')
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(".select2_auto_complete_organs").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.organs')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(".select2_auto_complete_organ_units").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.units')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(".select2_auto_complete_staff").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.users')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $(document).ready(function () {
            organs_grid();
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
