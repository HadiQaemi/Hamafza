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
    $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
        filter_tasks_priority();
    });
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
        @if(isset($filter_subject_id))
            send_info["subject_id"]= '{{ $filter_subject_id }}'
        @endif

        LangJson_DataTables = window.LangJson_DataTables;
        LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
        window.table_chart_grid2 = $('#MyTasksTable').DataTable({
            "dom": window.CommonDom_DataTables,
            "ajax": {
                "url": "{{ route('hamahang.tasks.my_tasks.fetch_all_task') }}",
                "type": "POST",
                "data": send_info
            },
            "autoWidth": false,
            "language": LangJson_DataTables,
            "processing": true,
            columns: [
                {
                    "data": "title",
                    "mRender": function (data, type, full) {
                        var id = full.id;
                        // return "<a class='task_info cursor-pointer' data-t_id = '"+full.id+"'>"+full.title+"</a>";<a style="float: right;" class="jsPanels" href="/modals/ShowTaskForm?tid='+id+'" title="{{trans('tasks.show_task')}}">{{trans('tasks.show_task')}}</a>
                        return "<a class='cursor-pointer jsPanels' href='/modals/ShowTranscriptTaskForm?tid="+full.id+"&aid="+full.assignment_id+"'>"+full.title+"</a>";
                        // return full.title;
                    }
                },
                {"data": "employee"},
                {"data": "assigner"},
                {"data": "immediate"},
                {"data": "respite"},
                {"data": "type"}

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
        })
    }

    var t2_default;
    var current_tab = '';
    var current_id = '';

</script>