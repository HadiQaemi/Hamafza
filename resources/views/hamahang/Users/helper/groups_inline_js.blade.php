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
    if (push_counters[key] === undefined){
    push_counters[key] = 0;
    }
    return push_counters[key]++;
    };
    $.each($(this).serializeArray(), function(){

    // skip invalid keys
    if (!patterns.validate.test(this.name)){
    return;
    }

    var k,
            keys = this.name.match(patterns.key),
            merge = this.value,
            reverse_key = this.name;
    while ((k = keys.pop()) !== undefined){

    // adjust reverse_key
    reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');
    // push
    if (k.match(patterns.push)){
    merge = self.build([], self.push_counter(reverse_key), merge);
    }

    // fixed
    else if (k.match(patterns.fixed)){
    merge = self.build([], k, merge);
    }

    // named
    else if (k.match(patterns.named)){
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
    {{--url: '{{ route('hamahang.users.fetchGroups') }}', --}}
    {{--method: 'GET', --}}
    {{--dataType: "json", --}}
    {{--data: $("#form_filter_priority").serialize(), --}}
    {{--success: function (res) {--}}
    {{--//console.log(res.success);--}}
    {{--if (res.success == true) {--}}
    {{--$('#priority_content_area').html(res.data); --}}
    {{--//messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});--}}
    {{--} else if (res.success == false) {--}}
    {{--messageModal('error', '{{trans('app.operation_is_failed')}}', res.error); --}}
    {{--}--}}
    {{--}--}}
    {{--}); --}}

    }

    //////////////////////////////////////////
    var send_info = {
    @if (isset($filter_subject_id))
            subject_id: '{{ $filter_subject_id }}'
            @endif

    };
    readTable($("#form_filter_priority").serializeObject());
    function  readTable(send_info) {
    LangJson_DataTables = window.LangJson_DataTables;
    LangJson_DataTables.searchPlaceholder = '{{trans('tasks.search_in_task_title_placeholder')}}';
    window.table_chart_grid2 = $('#MyTasksTable').DataTable({
    "dom": window.CommonDom_DataTables,
            "ajax": {
            "url": "{{route('hamahang.users.fetchGroups')}}",
                    "type": "GET",
                    "data": send_info
            },
            "autoWidth": false,
            "language": LangJson_DataTables,
            "processing": true,
            columns: [
            {
            "data": "name",
                    "mRender": function (data, type, full) {

                    // return "<a class='task_info cursor-pointer' data-t_id = '"+full.id+"'>"+full.title+"</a>";<a style="float: right;" class="jsPanels" href="/modals/ShowTaskForm?tid='+id+'" title="{{trans('tasks.show_task')}}">{{trans('tasks.show_task')}}</a>

                    return "<a class='cursor-pointer' href='/" + full.link + "'>" + full.name + "</a>";
                    }
            },
            {"data": "reg_date"},
            {"data": "memcount"},
            {"data": "postcount"},
            {
            "data": "icon",
                    "mRender": function (data, type, full) {

                    // return "<a class='task_info cursor-pointer' data-t_id = '"+full.id+"'>"+full.title+"</a>";<a style="float: right;" class="jsPanels" href="/modals/ShowTaskForm?tid='+id+'" title="{{trans('tasks.show_task')}}">{{trans('tasks.show_task')}}</a>

                   // return "<span style='border:0px; cursor:pointer' id='del_" + full.id + "' onclick='deletegroup(this)'  class='fonts GridIcon icon-hazv'></span>";
                    return '<button style="margin-right: 3px;"  title="حذف" type="button" class="btn btn-xs bg-danger fa fa-remove btn_grid_destroy_item" id="del_' + full.id + '"></button>';
                    }
            }


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

    $(document).on('click', '.btn_grid_destroy_item', function () {
    var id = $(this).attr('id').substr(4);
    var that = $(this);
    confirmModal({
    title: '{{trans('access.remove_group')}}',
            message: '{{trans('access.are_you_sure')}}',
            onConfirm: function () {
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var sendInfo = {
            groupid: id,
            };
            $.ajax({
            type: "POST",
                    url: '{{ route('hamahang.users.removeGroup') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function(result){
                        that.parent().parent().remove();
                    }
            });
            },
            afterConfirm: 'close'
    });
    });

    var t2_default;
    var current_tab = '';
    var current_id = '';

</script>