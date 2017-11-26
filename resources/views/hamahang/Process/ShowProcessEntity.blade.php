@extends('layouts.master')


@section('specific_plugin_style')
    <link href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/TagsInput/css/jquery.tagsinput.rtl.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="space-14"></div>
            <fieldset>
                <legend>{{ trans('process.process_entity_list') }}</legend>
                <div class="col-md-12">
                    <table id="ProcessEntityList" class="table table-striped table-bordered dt-responsive nowrap display"
                           style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>{{ trans('process.id') }}</th>
                            <th>{{ trans('process.current_level') }}</th>
                            {{--<th>{{ trans('app.action') }}</th>--}}
                        </tr>
                        </thead>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>


@stop




@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript"
            src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/TagsInput/js/jquery.tagsinput.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.fa.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            window.ProcessEntityList = $('#ProcessEntityList').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.Process.entity_list',['name'=>'' ]) }}" + "/{{ $process_c_id }}",
                    "type": "POST"
                },
                "autoWidth": false,
                "processing": true,
                "language": window.LangJson_DataTables,
                "serverside": true,
                columns: [

                    {"data": "id"},
                    {
                        "data": "current_tasks",
                        "mRender": function (data, type, full) {
                            var tasks = '';
                            $.each(data, function (key, value) {

                                tasks += '<a class="cursor-pointer task_info" data-t_id="'+value.task_id+'" onclick="" >' + value.task_title + '</a><br/>';

                            });
                            return tasks;
                        }
                    }//,
//                    {
//                        "data": "task_id",
//                        "mRender": function (data, type, full) {
//                            // var id = full.id;
//
//                            return "<a class='cls3' style='margin: 2px' onclick='process_info(" + full.id + ",\"" + full.title + "\")' href=\"#\"><i class='fa fa-edit'></i></a><a \
//                            class='cls3' style='margin: 2px' onclick='add_task(" + full.id + ")' href=\"#\"><i class='fa fa-plus'></i></a>";
//
//                        }
//                    }
                ]
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


        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

