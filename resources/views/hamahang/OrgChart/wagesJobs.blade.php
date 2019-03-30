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
        #WagesListGrid{
            width: 2200px !important;
            text-align: center;
        }
        #WagesListGrid th{
            text-align: center;
        }
        #WagesListGrid td{
            text-align: center;
        }
        .change_score{
            /*margin-right: 10px;*/
        }
        .DTFC_LeftBodyLiner{overflow-y:unset !important}
        .DTFC_RightBodyLiner{overflow-y:unset !important}
    </style>

    <link href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.bootstrap4.min.css" rel="stylesheet" />
    <div class="row-fluid">
        <div class="space-10"></div>
        <div class="col-xs-12">
            <fieldset>
                <div id="OrgList">
                    <div class="row-fluid">
                        <div class="col-lg-12">
                            <table id="WagesListGrid" class="table nowrap display text-center" cellspacing="0" width="3000px">
                                <thead>
                                    <tr>
                                        <th>{{ trans('org_chart.job') }}</th>
                                        <th>
                                            <div class="col-xs-12 nowrap text-center">تاثیر</div>
                                            <div class="col-xs-12 nowrap text-center">
                                                <div class="col-xs-2 nowrap noLeftPadding noRightPadding">تاثیر</div>
                                                <div class="col-xs-2 nowrap noLeftPadding noRightPadding">مشارکت</div>
                                                <div class="col-xs-4 nowrap noLeftPadding noRightPadding">امتیاز اولیه</div>
                                                <div class="col-xs-2 nowrap noLeftPadding noRightPadding">اندازه</div>
                                                <div class="col-xs-2 nowrap noLeftPadding noRightPadding">امتیاز</div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="col-xs-12 text-center">ارتباطات</div>
                                            <div class="col-xs-12 text-center">
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">نوع ارتباطات</div>
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">چارچوب</div>
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">امتیاز</div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="col-xs-12 text-center">حل مساله</div>
                                            <div class="col-xs-12 text-center">
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">نوآوری</div>
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">پیچیدگی</div>
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">امتیاز</div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="col-xs-12 text-center">دانش و مهارت</div>
                                            <div class="col-xs-12 text-center">
                                                <div class="col-xs-3 text-center noLeftPadding noRightPadding">دانش فنی</div>
                                                <div class="col-xs-3 text-center noLeftPadding noRightPadding">مهارت ارتباطات انسانی</div>
                                                <div class="col-xs-3 text-center noLeftPadding noRightPadding">گستردگی</div>
                                                <div class="col-xs-3 text-center noLeftPadding noRightPadding">امتیاز</div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="col-xs-12 text-center">خطرات</div>
                                            <div class="col-xs-12 text-center">
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">نوع خطرات</div>
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">احتمال وقوع</div>
                                                <div class="col-xs-4 text-center noLeftPadding noRightPadding">امتیاز</div>
                                            </div>
                                        </th>
                                        <th>امتیاز نهایی</th>
                                        <th>طبقه شغلی</th>
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
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
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

        function organs_wages_grid() {
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
            LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
            window.table_organs_wages_grid = $('#WagesListGrid').DataTable({
                "sScrollX": '100%',
                "sScrollY": '100%',
                "dom": window.CommonDom_DataTables,
                "serverSide": false,
                "ajax": {
                    "url": "{!! URL::route('hamahang.org_chart.wages_all_job',['username'=>$UName]) !!}",
                    "type": "POST"
                },
                "bSort": true,
                "aaSorting": [],
                "bSortable": true,
                "autoWidth": false,
                "searching": false,
                "pageLength": 10,
                // "scrollY": 400,
                "destroy": true,
                "language": LangJson_DataTables,
                "processing": false,
                "fixedColumns":   {
                    leftColumns: 1,
                    rightColumns: 0
                },
                "columnDefs": [
                    {
                        className: 'dt-body-nowrap dt-head-nowrap'
                    }
                ],
                columns: [
                    {
                        "data": "job",
                        "width": "10%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap text-center">' +
                                '   <div class="col-xs-2 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements effect_effect job_' + full.id + '" value="' + full.effect_effect + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=effect_effect&value=' + full.effect_effect + '"></a></div>' +
                                '   <div class="col-xs-2 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements effect_association job_' + full.id + '" value="' + full.effect_association + '"><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=effect_association&value=' + full.effect_association + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><span class="effect_first_score job_' + full.id + '">0</span></div>' +
                                '   <div class="col-xs-2 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements effect_num job_' + full.id + '" value="' + full.effect_size + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=effect_num&value=' + full.effect_size + '"></a></div>' +
                                '   <div class="col-xs-2 nowrap noLeftPadding noRightPadding"><span class="effect_score job_' + full.id + '">0</span> </div>' +
                                '</div>';

                        },
                        "width": "15%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap text-center">' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements connections_type job_' + full.id + '" value="' + full.connections_type + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=connections_type&value=' + full.connections_type + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements connections_frame job_' + full.id + '" value="' + full.connections_frame + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=connections_frame&value=' + full.connections_frame + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><span class="connections_score job_' + full.id + '">0</span> </div>' +
                                '</div>';

                        },
                        "width": "15%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap text-center">' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements problem_solving_innovation job_' + full.id + '" value="' + full.problem_solving_innovation + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=problem_solving_innovation&value=' + full.problem_solving_innovation + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements problem_solving_complexity job_' + full.id + '" value="' + full.problem_solving_complexity + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=problem_solving_complexity&value=' + full.problem_solving_complexity + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><span class="problem_solving_score job_' + full.id + '">0</span> </div>' +
                                '</div>';

                        },
                        "width": "10%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap text-center">' +
                                '   <div class="col-xs-3 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements skill_technical_knowledge job_' + full.id + '" value="' + full.skill_technical_knowledge + '"><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=skill_technical_knowledge&value=' + full.skill_technical_knowledge + '"></a></div>' +
                                '   <div class="col-xs-3 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements skill_communication_skills job_' + full.id + '" value="' + full.skill_communication_skills + '"><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=skill_communication_skills&value=' + full.skill_communication_skills + '"></a></div>' +
                                '   <div class="col-xs-3 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements skill_spread job_' + full.id + '" value="' + full.skill_spread + '"><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=skill_spread&value=' + full.skill_spread + '"></a></div>' +
                                '   <div class="col-xs-3 nowrap noLeftPadding noRightPadding"><span class="skill_score job_' + full.id + '">0</span> </div>' +
                                '</div>';

                        },
                        "width": "20%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap text-center">' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements risk_type job_' + full.id + '" value="' + full.risk_type + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=risk_type&value=' + full.risk_type + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><input class="form-control job_wages_elements risk_possibility job_' + full.id + '" value="' + full.risk_possibility + '"/><a class="jsPanels fa fa-edit" href="{!! route('modals.change_score') !!}?job_id=' + full.id + '&score=risk_possibility&value=' + full.risk_possibility + '"></a></div>' +
                                '   <div class="col-xs-4 nowrap noLeftPadding noRightPadding"><span class="risk_score job_' + full.id + '">0</span> </div>' +
                                '</div>';

                        },
                        "width": "15%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap noLeftPadding noRightPadding"><span class="total_score job_' + full.id + '">0</span> </div>';
                        },
                        "width": "2%"
                    },
                    {
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            return '<div class="col-xs-12 nowrap noLeftPadding noRightPadding"><span class="job_level job_' + full.id + '">0</span> </div>';
                        },
                        "width": "3%"
                    }
                ]
            });
        }
        $(document).ready(function () {
            organs_wages_grid();
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
