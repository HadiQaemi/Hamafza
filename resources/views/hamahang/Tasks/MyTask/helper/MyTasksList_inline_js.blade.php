<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
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
    $('#new_task_users_all_tasks, #new_task_keywords').on('change', function () {
        filter_tasks_priority();
    });
    $('#title, .task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_fianl[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"]').on('keyup change', function () {
        filter_tasks_priority();
    });

    // $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
    //     filter_tasks_priority();
    // });
    // $('#new_task_keywords').on('change', function () {
    //     filter_tasks_priority();
    // });
    function filter_tasks_priority(data) {
        window.table_chart_grid2.destroy();
        readTable($("#form_filter_priority").serializeObject());
        {{--$.ajax({--}}
        {{--url: '{{ route('hamahang.tasks.my_tasks.fetch') }}',--}}
        {{--method: 'POST',--}}
        {{--dataType: "json",--}}
        {{--data: $("#form_filter_priority").serialize(),--}}
        {{--success: function (res) {--}}
        {{--//console.log(res.success);--}}
        {{--if (res.success == true) {--}}
        {{--$('#priority_content_area').html(res.data);--}}
        {{--//messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});--}}
        {{--} else if (res.success == false) {--}}
        {{--messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}

    }
    function ShowErrorModal(data) {
        err_list_txt = '';
        $.each(data, function (key, value) {
            err_list_txt += '';
            switch (value.relation) {
                case 0: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 1: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 2: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
                case 3: {
                    err_list_txt += '<li>' + 'وظیفه ' + '<span style="color: limegreen">' + value.task_title + '(' + value.id + ')' + '</span>' + ' هنوز {{trans('tasks.status_not_started')}} است' + '</li>';
                    break;
                }
            }
        });
        $('#errors').html(err_list_txt);
        $('#change_statuts_err').modal({show: true});
        $("#r1").prop("checked", true);
    }
    //////////////////////////////////////////
    var send_info = {
        @if(isset($filter_subject_id))
        subject_id: '{{ $filter_subject_id }}'
        @endif

    };
    readTable($("#form_filter_priority").serializeObject());
    function  readTable(send_info) {
        // alert('asdasd');
        @if(isset($filter_subject_id))
            send_info["subject_id"]= '{{ $filter_subject_id }}'
        @endif
        if($('#new_task_keywords').val())
        {
            send_info["search_task_keywords"]= $('#new_task_keywords').val();
        }
        LangJson_DataTables = window.LangJson_DataTables;
        LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
        LangJson_DataTables.emptyTable = '{{trans('tasks.no_task_inserted')}}';

        window.table_chart_grid2 = $('#MyTasksTable').DataTable({
            "dom": window.CommonDom_DataTables,
            "ajax": {
                "url": "{{ route('hamahang.tasks.my_tasks.fetch') }}",
                "type": "POST",
                "data": send_info
            },
            "bSort": true,
            "bSortable": true,
            "autoWidth": false,
            "searching": false,
            "pageLength": 25,
            "language": LangJson_DataTables,
            "processing": true,
            columns: [
                {
                    "data": "title",
                    "mRender": function (data, type, full) {
                        var id = full.id;
                        // return "<a class='task_info cursor-pointer' data-t_id = '"+full.id+"'>"+full.title+"</a>";<a style="float: right;" class="jsPanels" href="/modals/ShowTaskForm?tid='+id+'" title="{{trans('tasks.show_task')}}">{{trans('tasks.show_task')}}</a>
                        return "<a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid="+full.id+"&aid="+full.assignment_id+"'>"+full.title+"</a>";
                    }
                },
                {
                    "data": "employee",
                    "mRender": function (data, type, full) {
                        var keywords = full.keywords.replace(/&quot;/g,'"');
                        keywords = JSON.parse(keywords);
                        data2 = "";
                        $.each(keywords, function(index) {
                            data2 += '<span class="bottom_keywords one_keyword task_keywords" data-id="'+keywords[index].id+ '" ><i class="fa fa-tag"></i> <span style="color: #6391C5;">'+keywords[index].title+'</span></span>';
                        });
                        return full.employee+"<div class='' style='margin: 2px 0px;padding: 5px;'>"+data2+"</div>";
                    }},
                {"data": "immediate",
                    "mRender": function (data, type, full) {
                        return "<img class='immediate-pic' src='/assets/images/"+full.immediate+".png'/>";
                    }},
                {"data": "respite"},
                {"data": "type"},
                {"data": "operation",
                    "mRender": function (data, type, full) {
                        return '<a class="jsPanels fa fa-copy pointer margin-right-10" data-toggle="tooltip" title="کپی وظیفه" href="/modals/CreateNewTask?tid='+full.id+'" title="وظیفه جدید"></a><a class="fa fa-clock-o pointer margin-right-10 disabled"  data-toggle="tooltip" title="پیگیری"></a>'+(full.pages[0] != undefined ? '<a class="fa fa-file pointer margin-right-10" target="_blank" data-toggle="tooltip" title="صفحه" href="/'+ full.pages[0] +'"></a>' : '<a class="fa fa-file pointer margin-right-10" target="_blank" data-toggle="tooltip" title="صفحه"></a>')+'<a class="fa fa-trash pointer margin-right-10" data-toggle="tooltip" title="حذف" onclick="confirm(\'آیا از حذف صفحه اطمینان دارید؟\')"></a>';
                    }}

//            , {
//                "data": "id", "width": "8%",
//                "bSearchable": false,
//                "bSortable": false,
//                "mRender": function (data, type, full) {
//                    var id = full.id;
//                    return "<a class='cls3' style='margin: 2px' onclick='f(" + full.id + ")' href=\"#\"><i class='fa fa-edit'></i></a><a style='margin:2px;' class='cls3' \
//                                                                                                                                                                                                                                onclick='del(" + full.id + ")' href=\"#\"><i class='fa fa-trash'></i></a>";
//                }
//            }
            ]
        });
        $("#MyTasksTable").on('DOMNodeInserted DOMNodeRemoved', function() {
            if ($(this).find('tbody tr td').first().attr('colspan')) {
                $('#MyTasksTable_wrapper').hide();
                $('.no-task-div').removeClass('hidden');
                $('.message').html("{{trans('tasks.no_task_inserted')}}");
            } else {
                $('#MyTasksTable_wrapper').show();
                $('.no-task-div').addClass('hidden');
            }
        });
    }
    function call_modal(title, message, callback_function) {
        $('#confirm_modal_massage').html(message);
        $('#confirm_modal_title').html(title);
        $("#confirm_ok").attr("onclick", callback_function + "(1)");
        $('#confirm_modal').modal({show: true});
    }
    function close_modal() {

        $('#confirm_modal').modal('hide');

    }
    function RemovePackage(id) {
        $('#new_package').modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            id: id,
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.remove_from_package') }}',
            dataType: "json",
            data: sendInfo
        });
    }

    function RemoveKeyword(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            kid: id,
            id: current_id
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.remove_keyword') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                // console.log(data);
                var cur_kw = '';
                $.each(data, function (key, value) {
                    cur_kw += '<a class="btn btn-default"  style="margin-right: 3px"><i class="fa fa-remove" style="margin-left: 5px" onclick="RemoveKeyword(' + value.id + ')"></i>'
                        + value.keyword + '</a>';
                })
                $('#current_kw').html(cur_kw);
            }
        });
    }
    function RemoveFromPackage(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            pid: id,
            id: current_id

        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.remove_from_package') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                var cur_pkg = '';
                $.each(data, function (key, value) {
                    cur_pkg += '<a class="btn btn-default"  style="margin-right: 3px"><i class="fa fa-remove" style="margin-left: 5px" onclick="RemoveFromPackage(' + value.id + ')"></i>' + value.title + '</a>';
                })
                $('#current_packages').html(cur_pkg);
            }
        });
    }
    function AddNewPackage() {
        $('#new_package').modal('hide');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var sendInfo = {
            title: $('#packagetitle').val(),
        };
        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.tasks.my_tasks.new_package') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                var p = '';
                for (var i = 0; i < data.length; i++) {
                    p += '<option id="' + data[i]['id'] + '">' + data[i]['title'] + '</option>';
                }
                $('#packages').html(p);
            }
        });
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
    var t2_default;
    var current_tab = '';
    var current_id = '';


    Grid_Table = $('#subjectsGrid').DataTable({
        "dom": window.CommonDom_DataTables,
        "processing": true,
        "serverSide": true,
        "language": window.LangJson_DataTables,
        ajax: {
            url: '{!! route('hamahang.subjects.get_subjects') !!}',
            type: 'POST'
        },
        columns: [
            {
                mRender: function (data, type, full) {
                    return '';
                }
            },
            {
                data: 'name',class:'name',
                mRender: function (data, type, full) {
                    return full['name'];
                }
            },
            {
                data: 'comment',
                mRender: function (data, type, full) {
                    return full['comment'];
                }
            },
            {
                mRender: function (data, type, full) {
                    return '<a title="صفحات" href="{!! route('modals.view_subject')  !!}?sid=' + full['id'] + ' "  class="jsPanels viewSubjects">' + full['get_subject_count'] + '</a>';
                }
            },
            {
                mRender: function (data, type, full) {
                    return full['jdate'];
                }
            },
            {
                mRender: function (data, type, full) {
                    var result = '';


                    result += '' +
                        '<button style="margin-right: 3px;" title="ویرایش موضوع" type="button" class="btn btn-xs bg-warning-400 fa fa-edit btn_grid_item_edit" ' +
                        '   data-grid_item_id="' + full['id'] + '" ' +
                        '   data-grid_item_title="' + full['name'] + '" ' +
                        '   data-grid_item_description="' + full['comment'] + '">' +
                        '</button>';


                    result += '' +
                        '<button style="margin-right: 3px;" title="حذف موضوع" type="button" class="btn btn-xs bg-danger-800 fa fa-remove btn_grid_destroy_item" data-grid_item_id="' + full['id'] + '"></button>';

                    return result;
                }
            }
        ]
    });
    Grid_Table.on('draw.dt order.dt search.dt', function () {
        Grid_Table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
</script>