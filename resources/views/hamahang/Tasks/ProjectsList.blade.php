@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div style="position: absolute;top:10px; width: 250px;left:0px;">
                @include('hamahang.Tasks.projects.project_related_pages')
            </div>
            {{--<fieldset id="fieldset_noData"></fieldset>--}}
            <fieldset id="fieldset_info" class="hidden">
                <div class="col-xs-12"><i class="fa fa-backward pointer" id="BackToProjects"></i></div>
                <div id="ProjectInfoList"></div>
            </fieldset>
            <fieldset id="fieldset">
                {{--<legend>لیست پروژه ها</legend>--}}
{{--                {{dd(Session::get('uid'))}}--}}
                <div class="col-md-12">
                    <table id="ProjectList" class="table dt-responsive nowrap display dataTable no-footer"
                           style="text-align: center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{trans('projects.title')}}</th>
                            <th>{{trans('projects.project_manager')}}</th>
                            <th>{{trans('projects.start_date')}}</th>
                            <th>{{trans('projects.end_date')}}</th>
                            <th>{{trans('projects.progress')}}</th>
                            <th>{{trans('projects.status')}}</th>
                            <th>{{trans('projects.operation')}}</th>
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
            $('[data-toggle="tooltip"]').tooltip();
            var send_info = {
                @if(isset($filter_subject_id))
                subject_id: '{{ $filter_subject_id }}'
                @endif
            };
            LangJson_DataTables = window.LangJson_DataTables;
            LangJson_DataTables.emptyTable = '{{trans('projects.no_project_inserted')}}';
            window.ProjectList = $('#ProjectList').DataTable({
                "order": [[ 0, "desc" ]],
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
                    {
                        "data": "id",
                        "visible": false
                    },
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
                    },
                    {"data": "end_date",
                        "mRender": function (data, type, full) {
                            return "<a class='fa fa-edit margin-right-10 pointer project_info cursor-pointer' data-p_id= '"+ full.id +"' data-toggle='tooltip' title='ویرایش'></a><a class='fa fa-list margin-right-10 pointer pointer project_tasks_list' data-p_id= '"+ full.id +"' data-toggle='tooltip' title='وظایف'></a><a class='fa fa-area-chart margin-right-10 pointer pointer project_tasks_chart' data-p_id= '"+ full.id +"' data-toggle='tooltip' title='وظایف'></a>"+ (full.pages[0] != undefined ? '<a class="fa fa-file margin-right-10 pointer" data-toggle="tooltip" title="صفحه" href="/'+ full.pages[0] +'"></a>' : '<a class="fa fa-file margin-right-10 pointer" data-toggle="tooltip" title="صفحه"></a>')+"<a class='fa fa-remove margin-right-10 pointer' data-toggle='tooltip' title='حذف' onclick='confirm(\"آیا حذف شود؟\")'></a>";
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
        $(document).on('click', ".project_tasks_list", function () {
            var send_info = {
                p_id: $(this).data("p_id"),
                pid: $(this).data("p_id")
            }
            $.ajax({
                url:'<?php echo e(URL::route('hamahang.project.show_project_tasks_list' )); ?>',
                type:'post',
                data: send_info,
                dataType:'json',
                success :function(data)
                {
                    $('#ProjectInfoList').html(data.content);
                    $('#fieldset_info').removeClass('hidden');
                    $('#fieldset').addClass('hidden');
                }
            });
        });
        $(document).on('click', "#BackToProjects", function () {
            $('#fieldset').removeClass('hidden');
            $('#fieldset_info').addClass('hidden');
        });
        $(document).on('click', ".task_project_remove", function () {var id = $(this).attr('rel');

            confirmModal({
                title: 'حذف ارتباط',
                message: 'آیا از حذف مطمئن هستید؟',
                onConfirm: function () {
                    if (id != null) {
                        // var bookmark_id = $('#bookmark_' + id);
                        // var bookmark_id_parent = bookmark_id.parent();
                        // $.ajax
                        // ({
                        //     type: 'post',
                        //     url: Baseurl + 'bookmarks/delete',
                        //     dataType: 'html',
                        //     data: ({id: id}),
                        //     success: function (response) {
                        //         bookmark_id.remove();
                        //         if (0 == bookmark_id_parent.find('li').length) {
                        //             bookmark_id_parent.remove();
                        //             $('#' + bookmark_id_parent.attr('class')).remove()
                        //         }
                        //         jQuery.noticeAdd
                        //         ({
                        //             text: 'حذف با موفقیت انجام شد.',
                        //             stay: false,
                        //             type: 'success'
                        //         });
                        //         //$('[href=#page1]').trigger('click');
                        //     }
                        // });
                    }
                },
                afterConfirm: 'close'
            });
        });
        $(document).on('click', ".task_remove", function () {var id = $(this).attr('rel');

            confirmModal({
                title: 'حذف وظیفه',
                message: 'آیا از حذف وظیفه مطمئن هستید؟',
                onConfirm: function () {
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::route('hamahang.tasks.task_delete') }}',
                        dataType: "json",
                        data: {id:$(this).attr('t')},
                        success: function (data) {
                        }
                    });
                    {{--messageModal('success','حذف وظیفه' , {0:'{{trans('app.operation_is_success')}}'});--}}

                },
                afterConfirm: 'close'
            });
        });
        $(document).on('click', ".task_project_save_status", function () {
            weight = $('.process'+$(this).attr("t")+' .text-project-weight').val();
            progress = $('.process'+$(this).attr("t")+' .text-project-progress').val();
            parent = $(this).attr("parent");
            id = $(this).attr("t");
            precent = $('.progress-'+id).val();
            $('.child_of_'+id + '').each(function() {
                if($(this).hasClass('text-project-weight')){
                    weight = $(this).val();
                }
                if($(this).hasClass('text-project-progress')){
                    $(this).val(Math.floor(precent*weight/100));
                }
            });
            precent = 0;
            weight = 0;
            progress = 0;
            $('.child_of_'+parent).each(function() {
                if($(this).hasClass('text-project-weight')){
                    weight = $(this).val();
                }
                if($(this).hasClass('text-project-progress')){
                    progress = $(this).val();
                }
                if(weight != 0 && progress != 0) {
                    precent += progress * weight;
                    progress = weight = 0;
                }
            });
            $(".progress-"+parent+"").val(precent/100);
            $('.process' + parent).each(function() {
                if($(this).hasClass('text-project-weight')){
                    weight = $(this).val();
                }
                if($(this).hasClass('text-project-progress')){
                    $(this).val(Math.floor(precent*weight/100));
                }
            });

            var send_info = {
                form: $('.list-project-tasks').serialize(),
                t: $(this).attr("t"),
                tp: $(this).attr("tp"),
                pid: $(this).attr("pid"),
                parent: parent,
                weight: weight,
                progress: progress,
                rel: $(this).attr("rel")
            }
            $.ajax({
                url:'<?php echo e(URL::route('hamahang.project.change_task_relation' )); ?>',
                type:'post',
                data: $('.list-project-tasks').serialize() + '&pid=' + $(this).attr("pid"),
                dataType:'json',
                success :function(data)
                {
                    $('#project_progress').html(data);
                }
            });
        });
    </script>

@stop

@include('sections.tabs')

@section('position_right_col_3')
    {!!userProjectsWidget()!!}
    @include('sections.desktop_menu')
@stop
