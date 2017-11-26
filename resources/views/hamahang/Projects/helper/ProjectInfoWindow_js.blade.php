<script type="text/javascript">
    current_id = {{ $p_id }};
    $(document).ready(function () {
        project_info('Hi');
    })
    function project_info(title) {
//        $('#t2').html(t2_default);
        $('#header_project_title').html(title);
//        current_id = id;
        var sendInfo = {
            pid: current_id
        };
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.project.info') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                $('#project_title').val(data[1]['project_info'][0].title);
                $('#project_desc').val(data[1]['project_info'][0].desc);
                $('#project_manager').val(data[1]['project_info'][0].full_name);
                var type = '{{ trans('general.unofficial') }}'
                if (data[1]['project_info'][0].type == 1) {
                    type = '{{ trans('general.official') }}';
                }
                $('#project_type').val(type);
                var schedule_on = '{{ trans('projects.base_on_start') }}'
                if (data[1]['project_info'][0].schedule_on == 1) {
                    schedule_on = '{{ trans('projects.base_on_end') }}';
                }
                $('#project_schedule_base').val(schedule_on);
                if(typeof data[2]['pages'][0] != 'undefined')
                $('#project_page').val(data[2]['pages'][0].title);
                $('#project_start_date').val(data[1]['project_info'][0].start_date.mday + ' / ' + data[1]['project_info'][0].start_date.mon + ' / ' + data[1]['project_info'][0].start_date.year);
                $('#project_end_date').val(data[1]['project_info'][0].end_date.mday + ' / ' + data[1]['project_info'][0].end_date.mon + ' / ' + data[1]['project_info'][0].end_date.year);
                $('#project_base_calendar').val(data[1]['project_info'][0].c_title);

                RefreshRelation();
                //RefreshHirericalView(id);

                var first_task = '<select name="first_task" id="first_task" onchange="disable_second(this)" class="form-control col-xs-3"><option value="n">انتخاب کنید ...</option>';
//console.log(data[0].project_tasks[0].title);
                for (var i = 0; i < data[0].project_tasks.length; i++) {
                    first_task += '<option value="' + data[0].project_tasks[i].id + '">' + data[0].project_tasks[i].title + '</option>';
                }
                first_task += '</select>';
                var second_task = '<select name="second_task" id="second_task" class="form-control col-xs-3"><option value="n">انتخاب کنید ...</option>';
                for (var i = 0; i < data[0].project_tasks.length; i++) {
                    second_task += '<option value="' + data[0].project_tasks[i].id + '">' + data[0].project_tasks[i].title + '</option>';
                }
                second_task += '</select>';
                var relation_type = '<select name="relation_type" id="relation_type" class="form-control col-xs-3">';
                relation_type += '<option value="end_end">پایان - پایان</option>';
                relation_type += '<option value="start_end">شروع - پایان</option>';
                relation_type += '<option value="end_start">پایان - شروع</option>';
                relation_type += '<option value="start_start">شروع - شروع</option>';
                relation_type += '</select>';
                $('#f_task').html(first_task);
                $('#s_task').html(second_task);
                $('#r_type').html(relation_type);
                var t = '';
//                    console.log(data[0].project_tasks[1].title);
                t = '<table class="table table-bordered"><thead><th>عنوان</th></thead>';
                for (var i = 0; i < data[0].project_tasks.length; i++) {
                    t += '<tr>';
                    t += '<td><a class="task_info" data-t_id = "'+ data[0].project_tasks[i].id +'"> ' + data[0].project_tasks[i].title + '</a></td>';
                    t += '</tr>';
                }
                t += '</table>';
                $('#linked_tasks').html(t);
            }
        });
        $('#project_details').modal({show: true});

    }
    function SaveRelation() {
        var sendInfo = {
            f_task: $('#first_task').val(),
            s_task: $('#second_task').val(),
            r_type: $('#relation_type').val(),
            id: current_id
        };

        $.ajax({
            type: "POST",
            url: '{{ route('hamahang.project.add_project_task_relation') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {

                RefreshRelation();

            }
        });
    }
    function remove_relation(id) {
        var confirmi = confirm('آیا از حذف این رابطه مطمئن هستید ؟');
        if (confirmi == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendInfo = {
                id: id
                //f_task: $('#first_task').val(),
                // s_task: $('#second_task').val(),
                // r_type: $('#relation_type').val()
            };

            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.project.remove_project_task_relation') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    RefreshRelation();


                }
            });
        }
    }
    function add_task_to_project() {
        if (selectedrow.length > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendInfo = {
                s_arr: selectedrow,
                pid: current_project
            };

            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.project.add_project_task') }}',
                dataType: "json",
                data: sendInfo,
                success: function () {

                }
            });
        }

        $('#select_tasks').modal('hide');
        setTimeout(function () {
            location.reload();
        }, 1000)


    }
    function disable_second(item) {
        $('#second_task').children('option[value="' + prev_id + '"]').attr('disabled', false);
        prev_id = item.value;
        $('#second_task').children('option[value="' + item.value + '"]').attr('disabled', true);
        if ($('#second_task').val() != 'n')
            $('#second_task').val('n');
    }
    function select_task_modal(id) {
        current_package = id;
        $('#select_tasks').modal({show: true});
    }
    function add_task(id) {
        current_project = id;
        $('#select_task').modal({show: true});
    }
    function RefreshRelation() {

        window.table_chart_grid3.destroy();
        send_info = {
            id: current_id
        }
        setTimeout(function () {
            window.table_chart_grid3 = $('#grid3').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": "{{ route('hamahang.project.fetch_relation') }}",
                    "type": "POST",
                    "data": send_info
                },
                "autoWidth": false,
                "language": LangJson_DataTables,
                "processing": true,
                "serverside": true,
                columns: [
                    {"data": "id"},
                    {"data": "title_f"},
                    {"data": "relation"},
                    {"data": "title_s"},
                    {
                        "data": "id", "width": "8%",
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return "<i class='cursor-pointer' onclick='remove_relation("+full.id+")'>حذف</i></a>";
                        }
                    }
                ]
            });
        }, 100);
    }
</script>