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
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="1" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #ce8923" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.non-immediate')}}"></span>
                    </label>
                </div>
                <div class="checkbox pull-right margin-right-10">
                    <label class="container-checkmark">
                        <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="2" name="task_important_immediate[]" checked>
                        <span class="checkmark" style="background: #caca2b" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.immediate')}}"></span>
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
                        <input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks"/>
                        <label for="completed_tasks" class="completed"></label>
                    </div>
                    <div class="checkboxVertical pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}">
                        <input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks"/>
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

    <div class="container-fluid noLeftPadding noRightPadding task-list-height" id="base_items_div">
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
                            <th>{{trans('projects.title')}}</th>
                            <th>{{trans('projects.project_manager')}}</th>
                            <th>{{trans('projects.start_date')}}</th>
                            <th>{{trans('projects.end_date')}}</th>
                            <th>{{trans('projects.progress')}}</th>
                            <th>{{trans('projects.priority')}}</th>
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
                filter_project_list();
            });
            $('.task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_final[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"], input[name="task_important_immediate[]"]').on('keyup change', function () {
                filter_project_list();
            });
            $('#title').on('keypress change', function () {
                if($('#title').val().length >= 3){
                    filter_project_list();
                }
            });

            // $('#new_task_keywords').on('change', function () {
            //     filter_project_list();
            // });

            function filter_project_list(data) {
                window.ProjectList.destroy();
                readTable($("#form_filter_priority").serializeObject());
            }
            readTable($("#form_filter_priority").serializeObject());
            $(".select2_auto_complete_keywords").select2({
                minimumInputLength: 3,
                dir: "rtl",
                width: "100%",
                tags: true,
                ajax: {
                    url: "{{route('auto_complete.keywords')}}",
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
            function  readTable(send_info) {
                // alert('asdasdasd');
                // runWaitMe($('#master_inner_rtl_div'));
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
                LangJson_DataTables.sLoadingRecords = '<div class="loader preloader"></div>';
                window.ProjectList = $('#ProjectList').DataTable({
                    "dom": '<"bottom">rt<"bottom"ipl><"clear">',
                    "ajax": {
                        "url": "{{ route('hamahang.projects.list') }}",
                        "type": "POST",
                        "data": send_info
                    },
                    "bSort": true,
                    "order": [[ 2, "desc" ]],
                    "aaSorting": [],
                    "bSortable": true,
                    "autoWidth": false,
                    "searching": false,
                    "pageLength": 25,
                    "serverSide": true,
                    // "scrollY": 400,
                    "language": LangJson_DataTables,
                    "processing": false,
                    columns: [
                        {
                            "data": "title",
                            "mRender": function (data, type, full) {
                                // split = full.title.split(' ');
                                // sub_title = '';
                                // $.each(split,function(i,val){
                                //     if(i<=10){
                                //         sub_title = sub_title + ' ' + val;
                                //     }else if(i==11){
                                //         sub_title = sub_title + ' ...';
                                //     }
                                // });
                                return "<a class='pointer project_tasks_list white-space' data-p_id= '"+ full.pid +"' data-toggle='tooltip' title='" + full.title + "'>" + full.title + "</a>";
                            },
                            "width": "40%"
                        },
                        {
                            "data": "full_name",
                            "mRender": function (data, type, full) {
                                var keywords = full.keywords.replace(/&quot;/g,'"');
                                keywords = JSON.parse(keywords);
                                data2 = "";
                                $.each(keywords, function(index) {
                                    data2 += '<span class="bottom_keywords one_keyword task_keywords" data-id="'+keywords[index].id+ '" ><i class="fa fa-tag"></i> <span style="color: #6391C5;">'+keywords[index].title+'</span></span>';
                                });
                                return "<div style='height: 20px'>" + (full.full_name !== null ? full.full_name : '') + "</div>" +"<div class='project_keywords'>"+data2+"</div>";
                            },
                            "width": "20%"
                        },
                        {
                            "data": "start_date",
                            "mRender": function (data, type, full) {
                                return full.start_date;
                            },
                            "width": "5%"
                        },
                        {
                            "data": "end_date",
                            "mRender": function (data, type, full) {
                                return full.end_date;
                            },
                            "width": "5%"
                        },
                        {
                            "data": "progress",
                            "mRender": function (data, type, full) {
                                return full.progress<1 ? 0 : full.progress;
                            },
                            "width": "5%"
                        },
                        {
                            "data": "end_date",
                            "mRender": function (data, type, full) {
                                return "<img class='immediate-pic' src='/assets/images/"+full.immediate.output_image+".png' title='"+full.immediate.output+"' data-toggle='tooltip'/>";
                            },
                            "width": "5%"
                        },
                        {
                            "data": "end_date",
                            "mRender": function (data, type, full) {
                                return "<a class='fa fa-cog margin-right-10 pointer project_info cursor-pointer' data-p_id= '"+ full.pid +"' data-toggle='tooltip' title='{{trans('projects.settings')}}'></a><a class='fa fa-list margin-right-10 pointer pointer project_tasks_list' data-p_id= '"+ full.pid +"' data-toggle='tooltip' title='{{trans('projects.hierarchical')}}'></a><a class='fa fa-area-chart margin-right-10 pointer project_tasks_chart' data-p_id= '"+ full.pid +"' data-toggle='tooltip' title='{{trans('projects.MyTaskPackages')}}'></a>"+ (full.pages[0] != undefined ? '<a class="fa fa-file margin-right-10 pointer" data-toggle="tooltip" title="{{trans('projects.page')}}" href="/'+ full.pages[0] +'"></a>' : '<a class="fa fa-file margin-right-10 pointer" data-toggle="tooltip" title="صفحه"></a>')+"<a class='fa fa-trash margin-right-10 pointer color_red delete_project' data-toggle='tooltip' pid='"+ full.pid +"' title='{{trans('projects.delete')}}'></a>" + "<a class='jsPanels margin-right-10 fa fa-plus' href='{{url('/modals/CreateNewTask?pid=')}}"+full.id +"' data-toggle='tooltip' title='{{trans('tasks.create_new_task')}}'></a>";
                            },
                            "width": "10%"
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
                // $('#master_inner_rtl_div').waitMe('hide');
            }

            $(document).on('click', '#create_rapid_task_to_project_btn_submit', function () {
                var sendInfo = $('#form_create_rapid_task').serialize();
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.rapid_new_task_to_project') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        if (data.success == 'success') {
                            $('#create_rapid_task_title').val('');
                            $('#create_rapid_task_multi_selected_users').val('');
                            loadTaskList({p_id: $('#pid').val(),pid: $('#pid').val()});
                        }
                        else {
                            messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                        }
                    }
                });
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
            $('#base_items_div').css('overflow-y','hidden');
            loadTaskList(send_info);
        });
        $(document).on('click', ".project_tasks_chart", function () {
            var send_info = {
                p_id: $(this).data("p_id"),
                pid: $(this).data("p_id")
            }
            loadGanttTasks(send_info);

        });
        function loadGanttTasks(send_info){
            $.ajax({
                url:'{{ URL::route('hamahang.project.show_project_gantt_tasks') }}',
                type:'post',
                data: send_info,
                dataType:'json',
                success :function(data)
                {
                    if (data.success == false) {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }else{
                        $('#form_filter_priority').addClass('hidden');
                        $('#ProjectInfoList').html(data.content);
                        $(".for-dynamic-help").html(data.HelpLink);
                        $('#fieldset_info').removeClass('hidden');
                        $('#fieldset').addClass('hidden');
                    }
                }
            });
        }
        function loadTaskList(send_info){
            $.ajax({
                url:'<?php echo e(URL::route('hamahang.project.show_project_tasks_list' )); ?>',
                type:'post',
                data: send_info,
                dataType:'json',
                success :function(data)
                {
                    if (data.success == false) {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }else{
                        $('#form_filter_priority').addClass('hidden');
                        $('#ProjectInfoList').html(data.content);
                        $(".for-dynamic-help").html(data.HelpLink);
                        $('#fieldset_info').removeClass('hidden');
                        $('#fieldset').addClass('hidden');
                    }
                }
            });
        }
        $(document).on('click', "#BackToProjects", function () {
            $('#fieldset').removeClass('hidden');
            $('#fieldset_info').addClass('hidden');
            $('#form_filter_priority').removeClass('hidden');
            $('#base_items_div').css('overflow-y','scroll');
        });
        $(document).on('click', ".task_project_remove", function () {
            var tid = $(this).attr('t');
            var pid = $(this).attr('pid');
            confirmModal({
                title: 'حذف ارتباط',
                message: 'آیا از حذف مطمئن هستید؟',
                onConfirm: function () {
                    if (tid != null && pid != null) {
                        $.ajax({
                            type: "POST",
                            url: '{{ URL::route('hamahang.project.delete_task_project') }}',
                            dataType: "json",
                            data: {tid:tid, pid:pid},
                            success: function (data) {
                                if (data.success == true) {
                                    $('#create_rapid_task_title').val('');
                                    $('#create_rapid_task_multi_selected_users').val('');
                                    loadTasks({p_id: pid,pid: pid});
                                }else{
                                    messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                                }
                            }
                        });
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
        $(document).on('click', ".delete_project", function () {
            var id = $(this).attr('pid');
            confirmModal({
                title: '{{trans('projects.delete_project')}}',
                message: '{{trans('projects.confirm_delete_project')}}',
                onConfirm: function () {
                    $.ajax({
                        type: "POST",
                        url: '{{ URL::route('hamahang.projects.project_delete') }}',
                        dataType: "json",
                        data: {pid:id},
                        success: function (data) {
                            if (data.success == true) {
                                // window.ProjectList.ajax.reload();
                            }else{
                                messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                            }
                        }
                    });
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
                    if (data.success == true) {
                        if(data.project>0) {
                            $('#project_progress').html(data.project);
                        }
                        messageModal('success', '{{trans('app.operation_is_success')}}', '{{trans('app.operation_is_success')}}');
                    }else{
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.message);
                    }
                }
            });
        });
    </script>

@stop

@include('sections.tabs')

@section('position_right_col_3')
    {{--{!!userProjectsWidget()!!}--}}
    @include('sections.desktop_menu')
@stop
