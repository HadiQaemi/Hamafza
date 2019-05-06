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
    <div class="row" style="margin-top: -10px;background: #eee" >
        <form id="form_filter_priority">
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-search int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="onet_skill_search" name="onet_skill_search[]" class="select2_auto_complete_onet_skill col-xs-12"
                            data-placeholder="{{trans('org_chart.search_some_onet_skill')}}" multiple>
                    </select>
                </div>
                <i class="fa fa-search int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="onet_ability_search" class="select2_auto_complete_onet_ability" name="onet_ability_search[]"
                            data-placeholder="{{trans('org_chart.search_some_onet_ability')}}" multiple></select>
                </div>
                <i class="fa fa-search int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="onet_knowledge_search" name="onet_knowledge_search[]" class="select2_auto_complete_onet_knowledge col-xs-12"
                            data-placeholder="{{trans('org_chart.search_some_onet_knowledge')}}" multiple>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="row-fluid">
        <div class="space-10"></div>
        <div class="col-xs-12">
            <fieldset>
                <div id="OrgList">
                    <div class="row-fluid">
                        <div class="col-lg-12">
                            <table id="JobListGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{ trans('org_chart.job') }}</th>
                                    <th>{{ trans('org_chart.description') }}</th>
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

        function jobs_grid() {
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
            LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
            window.table_organs_grid = $('#JobListGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "serverSide": false,
                "ajax": {
                    "url": "{!! URL::route('hamahang.org_chart.portal_job_list') !!}",
                    "type": "POST"
                },
                "bSort": true,
                "order": [[ 1, "desc" ]],
                "aaSorting": [],
                "bSortable": true,
                "autoWidth": false,
                "searching": false,
                "pageLength": 25,
                // "scrollY": 400,
                "language": LangJson_DataTables,
                "processing": false,
                columns: [
                    {
                        "data": "title",
                        "width": "30%"
                    },
                    {
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            var lblDescription = full.lblDescription;
                            split = lblDescription.split(' ');
                            sub_title = '';
                            $.each(split,function(i,val){
                                if(i<=15){
                                    sub_title = sub_title + ' ' + val;
                                }else if(i==16){
                                    sub_title = sub_title + ' ...';
                                }
                            });
                            return "<span class='text_ellipsis' data-toggle='tooltip' title='" + full.lblDescription + "'>" + sub_title + "</span>"
                        },
                        "width": "60%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;

                            window.RowData[id] = full;
                            return "<i class='fa fa-remove pointer ' ref=" + id + " add='{{ route('hamahang.org_chart.delete_item_job') }}'></i>" +
                                "<a class='cursor-pointer jsPanels white-space margin-right-10' href='/modals/ViewJobFormss?sid="+full.id+"'><i class='fa fa-edit pointer'></i></a>"

                        },
                        "width": "10%"
                    }
                ]
            });
        }

        $(".select2_auto_complete_onet_skill").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.onet_skill')}}",
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
        $(".select2_auto_complete_onet_ability").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.onet_ability')}}",
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
        $(".select2_auto_complete_onet_knowledge").select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: "{{route('auto_complete.onet_knowledge')}}",
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
            jobs_grid();
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
