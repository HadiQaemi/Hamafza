@extends('layouts.master')

@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('page_title')
    TODO supply a title
@stop

@section('specific_plugin_style')

    <link rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">
    <link type="text/css" rel="stylesheet"
          href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>

@stop


@section('content')
    <div class="container">
        <div style="text-align: center">
            <div class="row col-md-12" style="padding: 10px">
                <table id="select_task_window_table"
                       class="table table-striped table-bordered dt-responsive nowrap display col-md-11"
                       style="text-align: center;">
                    <thead>
                    <tr>
                        <th></th>
                        <th>عنوان وظیفه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop


@section('specific_plugin_scripts')
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            refresh_tasks_list();
        });
        function refresh_tasks_list() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (window.select_task_window)
                window.select_task_window.destroy();
            var sendInfo = {
                window_use_type: 200//,
                //task_types: selected_types,
                //assigning_type: task_assigning_type
            }
            window.select_task_window = $('#select_task_window_table').DataTable({
                {{--"url": "{{ route('hamahang.tasks.fetch_tasks_for_select_task_window',['username'=>$uname ,'id'=>'/' ]) }}" + "/" + id,--}}
                'language': window.LangJson_DataTables,
                //'processing': true,
                //'serverSide': true,
                'ajax': {
                    'url': "{!!  route('hamahang.library.fetch_tasks') !!}",
                    'type': "POST",
                    'data': sendInfo
                },
                'columnDefs': [{
                    'targets': 0,
                    'searchable': true,
                    'orderable': false,
                    'width': '1%',
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return '<input type="checkbox" />';
                    }
                }],
                'columns': [
                    {data: 'id'},
                    {data: 'title'},
                    {
                        "data": "title",
                        "mRender": function (data, type, full) {
                            return "<a class='cls3' style='margin: 2px' onclick='remove_task(" + full.id + ")' href=\"#\"><i >حذف</i></a>";

                        }
                    }
                ],
                'order': [[1, 'asc']],
                "pageLength": 5//,
                //"lengthChange": false
            });
        }
        function remove_task(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendInfo = {
                tid: id
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.library.remove_library_task') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    refresh_tasks_list();
                }
            });
        }
    </script>
@stop




@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop



