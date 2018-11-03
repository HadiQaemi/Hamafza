@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">

            <fieldset id="fieldset_noData">

            </fieldset>
            <fieldset id="fieldset">
                {{--<legend>لیست پروژه ها</legend>--}}
{{--                {{dd(Session::get('uid'))}}--}}
                <div class="col-md-12">
                    <table id="ProjectList" class="table dt-responsive nowrap display dataTable no-footer"
                           style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{trans('projects.title')}}</th>
                            <th>{{trans('projects.project_manager')}}</th>
                            <th>{{trans('projects.start_date')}}</th>
                            <th>{{trans('projects.end_date')}}</th>
                            <th>{{trans('projects.progress')}}</th>
                            <th>{{trans('projects.status')}}</th>
                            {{--<th>عملیات</th>--}}
                        </tr>
                        </thead>
                    </table>
                </div>
            </fieldset>
        </div>
        {{--<div class="row">--}}
            {{--<a class="btn btn-primary fa fa-plus jsPanels margin-bottom-30" href="/modals/CreateNewProject?uid={{Session::get('uid')}}&sid=0" title="{{trans('projects.create_new_project')}}"></a>--}}
        {{--</div>--}}
    </div>

@stop



@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            window.table_chart_grid3 = $('#grid3').DataTable();
            var send_info = {
                @if(isset($filter_subject_id))
                subject_id: '{{ $filter_subject_id }}'
                @endif
            };
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.emptyTable = '{{trans('projects.no_project_inserted')}}';
            window.ProjectList = $('#ProjectList').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.projects.list') }}",
                    "type": "POST",
                    "data": send_info
                },
                "autoWidth": false,
                "processing": true,
                "language": window.LangJson_DataTables,
                "serverside": true,
                columns: [
                    // {"data": "id"},
//                    {"data": "title"},
                    {
                        "data": "title",
                        "mRender": function (data, type, full) {
                            return "<a class='project_info cursor-pointer' data-p_id= '"+ full.id +"' >"+ full.title +"</a>";
                        }
                    },
                    {"data": "full_name"},
                    {
                        "data": "start_date",
                        "mRender": function (data, type, full) {
                            return full.start_date;
                        }
                    },
                    {
                        "data": "end_date",
                        "mRender": function (data, type, full) {
                            return full.end_date;
                        }},
                    {"data": "end_date",
                        "mRender": function (data, type, full) {
                            return "";
                        }
                    },
                    {"data": "end_date",
                        "mRender": function (data, type, full) {
                            return "";
                        }
                    }
                    // {
                    //     "data": "project_id",
                    //     "mRender": function (data, type, full) {
                    //         return "<a class='cls3' style='margin: 2px' onclick='show_select_tasks_window_modal(1," + full.id + ",0)' href=\"#\"><i class=''></i>افزودن وظیفه جدید به پروژه</a>";
                    //     }
                    // }
                ],
                fnInitComplete : function() {
                    // alert($(this).find('tbody tr').length);
                    // if ($(this).find('tbody tr').length<=1) {
                    //     $('#fieldset').hide();
                    //     $('#fieldset_noData').text(LangJson_DataTables.emptyTable);
                    // }
                }
            });
            window.table_hirerical_view = $('#hirerical_view').DataTable();
            $('#hirerical_view').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    //var virtual_task_id = row.data()[0];
                    //var subtable_id = "subtable-"+virtual_task_id;
                    row.child(format()).show();
                    /* HERE I format the new table */
                    tr.addClass('shown');
                    //sub_DataTable(virtual_task_id, subtable_id); /*HERE I was expecting to load data*/
                }
            });

            window.table_hirerical_view.rows().every(function () {
                this.child('Row details for row: ' + this.index());
            });
            $('#hirerical_view tbody').on('click', 'td.details-control', function () {
                alert($(this).closest('table').attr('id'));
                var tr = $(this).closest('tr');
                var row = table_hirerical_view.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    var virtual_task_id = row.data()['task_id'];
                    var subtable_id = "subtable_" + virtual_task_id;
                    row.child(format(subtable_id)).show();
                    /* HERE I format the new table */
                    tr.addClass('shown');
                    sub_DataTable(virtual_task_id, subtable_id);
                    /*HERE I was expecting to load data*/
                }
            });
        });
        function format(table_id) {
            // `d` is the original data object for the row
            return '<table id="' + table_id + '" class="display" border="0" style="padding-left:50px; width:100%;">' +
                '</table>';
        }

        var selectedrow = [];
        var t2_default;
        var current_tab = '';
        var current_id = '';
        var r;
        $('.nav-tabs a').click(function (e) {
            current_tab = $($(this).attr('href')).index();
        });
        var prev_id = '';

        $("#tags").select2({
            minimumInputLength: 1,
            dir: "rtl",
            width: "100%",
            tags: true
        });
    </script>
@stop

@include('sections.tabs')

@section('position_right_col_3')
    {!!userProjectsWidget()!!}
    @include('sections.desktop_menu')
@stop
