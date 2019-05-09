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
        <div class="tab-pane active tab-view" id="tab_t1">
            <div class="col-xs-12 form-group margin-top-20">
                <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding line-height-35">
                    <label for="item_title">شغل</label>
                </div>
                <div class="col-xs-11 noRightPadding noLeftPadding">
                    {{$job->title}}
                </div>
            </div>
            <div class="col-xs-12 form-group margin-top-20 ">
                <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding line-height-35">
                    <label for="item_title">توضیحات</label>
                </div>
                <div class="col-xs-11 noRightPadding noLeftPadding">
                    {{$job->lblDescription}}
                </div>
            </div>
        </div>
        <div class="tab-pane tab-view" id="tab_t2">
            <table class="table margin-top-20" style="width: 100%;">
                <thead>
                <th class="col-xs-4 text-right">مهارت</th>
                <th class="col-xs-3 text-right">توضیحات</th>
                </thead>
                <tbody id="list_positions">
                @foreach($job->skill as $skill)
                    <tr>
                        <td class="col-xs-4">{{isset($skill->skill->label) ? $skill->skill->label : ''}}</td>
                        <td class="col-xs-8">{{isset($skill->skill->description) ? $skill->skill->description : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane tab-view" id="tab_t3">
            <table class="table margin-top-20" style="width: 100%;">
                <thead>
                <th class="col-xs-4 text-right">توانایی</th>
                <th class="col-xs-3 text-right">توضیحات</th>
                </thead>
                <tbody id="list_positions">
                @foreach($job->ability as $ability)
                    <tr>
                        <td class="col-xs-4">{{isset($ability->ability->label) ? $ability->ability->label : ''}}</td>
                        <td class="col-xs-8">{{isset($ability->ability->description) ? $ability->ability->description : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane tab-view" id="tab_t4">
            <table class="table margin-top-20" style="width: 100%;">
                <thead>
                <th class="col-xs-4 text-right">توانایی</th>
                <th class="col-xs-3 text-right">توضیحات</th>
                </thead>
                <tbody id="list_positions">
                @foreach($job->knowledge as $knowledge)
                    <tr>
                        <td class="col-xs-4">{{isset($knowledge->knowledge->label) ? $knowledge->knowledge->label : ''}}</td>
                        <td class="col-xs-8">{{isset($knowledge->knowledge->description) ? $knowledge->knowledge->description : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
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
                                if(i<=10){
                                    sub_title = sub_title + ' ' + val;
                                }else if(i==11){
                                    sub_title = sub_title + ' ...';
                                }
                            });
                            return "<span class='text_ellipsis' data-toggle='tooltip' title='" + full.lblDescription + "'>" + sub_title + "</span>"
                        },
                        "width": "50%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;

                            window.RowData[id] = full;
                            return "<i class='fa fa-remove pointer ' ref=" + id + " add='{{ route('hamahang.org_chart.delete_item_job') }}'></i>" +
                                "<a class='cursor-pointer jsPanels white-space margin-right-10' href='/modals/ViewJobItem?sid="+full.id+"'><i class='fa fa-edit pointer'></i></a>" +
                                "<a class='margin-right-10' href='/"+full.sid+"0'><i class='fa fa-file pointer'></i></a>"

                        },
                        "width": "20%"
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
