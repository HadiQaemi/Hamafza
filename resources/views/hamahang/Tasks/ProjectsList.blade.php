@extends('layouts.master')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/DataTables/datatables.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
@stop
<style>
    .hd-body{
        overflow: hidden !important;
    }
</style>
@section('content')
    <div class="row opacity-7" style="margin-top: -10px;background: #eee">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}"
                            multiple="multiple"></select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('tasks.official')}}</span>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="pull-right" style="margin-top: 10px;">
                    <span>{{trans('tasks.unofficial')}}</span>
                </div>
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<label class="container-checkmark">--}}
                {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" id="task_final_1" value="1" checked>--}}
                {{--<span class="checkmark"></span>--}}
                {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<span>{{trans('tasks.final')}}</span>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<label class="container-checkmark">--}}
                {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" id="task_final_0" value="0">--}}
                {{--<span class="checkmark"></span>--}}
                {{--</label>--}}
                {{--</div>--}}
                {{--<div class="pull-right hidden" style="margin-top: 10px;">--}}
                {{--<span>{{trans('tasks.draft')}}</span>--}}
                {{--</div>--}}
                <div class="pull-right" style="margin-top: 10px;margin-right: 15px">
                    <span>{{trans('tasks.priority')}}</span>
                </div>
                <div class="checkbox pull-right margin-right-15" style="margin-top: -5px">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="3" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: red;" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.immediate')}}"></span>
                    </label>
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="2" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #caca2b" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.immediate')}}"></span>
                    </label>
                </div>
                <div class="checkbox pull-right margin-right-10">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="1" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #ce8923" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="0" name="task_important_immediate[]" checked>
                        <span class="checkmark" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                </div>

                <div class="checkbox pull-right margin-right-20">
                    <div class="pull-right">
                        <span style="margin-top: 10px;display: block;">{{trans('tasks.stage')}}</span>
                    </div>
                    <div class="checkboxVertical draft pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.draft')}}">
                        <input type="checkbox" class="form-check-input" value="10" name="task_status[]" id="draft_tasks" />
                        <label for="draft_tasks" class="draft"></label>
                    </div>
                    <div class="checkboxVertical not_started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}">
                        <input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked/>
                        <label for="not_started_tasks" class="not_started"></label>
                    </div>
                    <div class="checkboxVertical started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_started')}}">
                        <input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked/>
                        <label for="started_tasks" class="started"></label>
                    </div>
                    <div class="checkboxVertical done pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_done')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks"/>
                        <label for="done_tasks" class="done"></label>
                    </div>
                    <div class="checkboxVertical completed pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="completed_tasks"/>
                        <label for="completed_tasks" class="completed"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}">
                        <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="stoped_tasks"/>
                        <label for="stoped_tasks"></label>
                    </div>
                </div>
            </div>

            @if(isset($filter_subject_id))
                <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
            @endif
            {{--</div>--}}
        </form>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div style="position: absolute;top:10px; width: 250px;left:0px;">
                @include('hamahang.Tasks.projects.project_related_pages')
            </div>
            {{--<fieldset id="fieldset_noData"></fieldset>--}}
            <fieldset id="fieldset_info" class="hidden">
                <div class="col-xs-12"><i class="fa fa-arrow-left pointer" id="BackToProjects" style="margin-top: 10px;"></i></div>
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
        (function($){
            $.fn.serializeObject = function(){

                var self = this,
                    json = {},
                    push_counters = {},
                    patterns = {
                        "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                        "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                        "push":     /^$/,
                        "fixed":    /^\d+$/,
                        "named":    /^[a-zA-Z0-9_]+$/
                    };


                this.build = function(base, key, value){
                    base[key] = value;
                    return base;
                };

                this.push_counter = function(key){
                    if(push_counters[key] === undefined){
                        push_counters[key] = 0;
                    }
                    return push_counters[key]++;
                };

                $.each($(this).serializeArray(), function(){

                    // skip invalid keys
                    if(!patterns.validate.test(this.name)){
                        return;
                    }

                    var k,
                        keys = this.name.match(patterns.key),
                        merge = this.value,
                        reverse_key = this.name;

                    while((k = keys.pop()) !== undefined){

                        // adjust reverse_key
                        reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                        // push
                        if(k.match(patterns.push)){
                            merge = self.build([], self.push_counter(reverse_key), merge);
                        }

                        // fixed
                        else if(k.match(patterns.fixed)){
                            merge = self.build([], k, merge);
                        }

                        // named
                        else if(k.match(patterns.named)){
                            merge = self.build({}, k, merge);
                        }
                    }

                    json = $.extend(true, json, merge);
                });

                return json;
            };
        })(jQuery);
        $(document).ready(function () {
            $('#new_task_users_all_tasks, #new_task_keywords').on('change', function () {
                filter_tasks_priority();
            });
            $('#title, .task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_final[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"], input[name="task_important_immediate[]"]').on('keyup change', function () {
                filter_tasks_priority();
            });
            // $('#new_task_keywords').on('change', function () {
            //     filter_tasks_priority();
            // });

            function filter_tasks_priority(data) {
                window.ProjectList.destroy();
                readTable($("#form_filter_priority").serializeObject());
            }
            readTable($("#form_filter_priority").serializeObject());

            function  readTable(send_info) {
                if($('#new_task_keywords').val())
                {
                    send_info["search_task_keywords"]= $('#new_task_keywords').val();
                }
                window.ProjectList = $('#grid3').DataTable();
                $('[data-toggle="tooltip"]').tooltip();
                @if(isset($filter_subject_id))
                    send_info["subject_id"] = '{{ $filter_subject_id }}';
                @endif
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
                                return "<a class='pointer project_tasks_list' data-p_id= '"+ full.id +"' data-toggle='tooltip' title='وظایف'>"+ full.title +"</a>";
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
            }


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
        $(".select2_auto_complete_user").select2({
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
                    $('#form_filter_priority').addClass('hidden');
                    $('#ProjectInfoList').html(data.content);
                    $('#fieldset_info').removeClass('hidden');
                    $('#fieldset').addClass('hidden');
                }
            });
        });
        $(document).on('click', "#BackToProjects", function () {
            $('#fieldset').removeClass('hidden');
            $('#fieldset_info').addClass('hidden');
            $('#form_filter_priority').removeClass('hidden');
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
