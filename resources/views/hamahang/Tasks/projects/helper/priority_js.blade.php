<script>

    $(".DatePicker").persianDatepicker({
        autoClose: true,
        format: 'YYYY-MM-DD'
    });

    $(document).ready(function () {
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
        initDraggable();
        $('#new_task_users_all_tasks, #new_task_keywords').on('change', function () {
            filter_projects_priority();
        });
        $('#title, .task_status, .task_immediate, .task_important, .official_type, input[name="task_status[]"], input[name="task_final[]"], input[name="task_immediate[]"], input[name="official_type[]"], input[name="task_important[]"]').on('keyup change', function () {
            filter_projects_priority();
        });

        // $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
        //     filter_projects_priority();
        // });
        $('#form_filter_priority_time').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            filter_projects_priority_time();
        });
        $("#states-multi-select-users").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.users') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
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
    });
</script>
<script>
    function initDraggable() {
        $(".draggable").draggable({
            cursor: "all-scroll",
            zIndex: 100,
            revert: 'invalid',
            helper: 'clone',
            drag: function (event, ui) {
            }
        });
        $(".droppable").droppable({
            accept: ".draggable",
            drop: function (event, ui) {
                $(this).removeClass("border").removeClass("over");
                var Drag_Destination = $(this).attr('id');
                var hour = $('#'+Drag_Destination).attr('hour');
                var day = $('#'+Drag_Destination).attr('day');

                var dropped = ui.draggable;
                var project_id = dropped.data('project_id');
                var Drag_Action = dropped.data('action');
                var title = dropped.data('title');
                if(Drag_Action=='task_timing')
                {
                    daySplit = day.split('-');
                    var droppedOn = $(this);
                    showTimeAndTask(title,day,day,hour,hour,droppedOn,project_id);
                    subClass = '';
                    for(sd=1;sd<daySplit[2];sd++)
                    {
                        subClass += ' subClass'+sd;
                    }
                    $('#table_task_time').append(
                            '<li class="draggable task_item_'+project_id+' ui-draggable ui-draggable-handle dynamic-add-task '+subClass+'" data-action="task_timing" data-title="'+title+'" data-project_id="'+project_id+'">'+
                                $('.task_item_'+project_id).html()+
                            '</li>');

                    x = $('#'+Drag_Destination).position();
                    startdate = day.split('-');
                    starttime = hour.split(':');
                    var table_task_time = $('#table_task_time').width();
                    var start_stamo = parseInt(starttime[0]*60)+parseInt(starttime[1]);

                    $('#table_task_time .task_item_'+project_id).css('position','absolute');
                    $('#table_task_time .task_item_'+project_id).css('right',Math.floor((table_task_time*start_stamo)/(24*60)-table_task_time/24)+'px');
                    $('#table_task_time .task_item_'+project_id).css('width',parseInt(table_task_time/12)+'px');
                    $('#table_task_time .task_item_'+project_id).css('top',x.top+'px');

                }else{
                    var action = $('#source').val();
                    submit_change_priority(Drag_Destination, project_id,action);
                    var droppedOn = $(this);
                    $(dropped).detach().appendTo(droppedOn);
                }
            },
            over: function (event, elem) {
                $(this).data('id');
                $(this).addClass("over");
                //console.log($(this).attr('id'));
                //console.log("over");
            },
            out: function (event, elem) {
                $(this).removeClass("over");
                //console.log($(this).attr('id'));
                //console.log("out");
            }
        });
        $(".droppable").sortable();
    }

    function filter_projects_priority(data) {
        var form_filter_priority = $("#form_filter_priority").serialize() + '&filter_subject_id=' + $('#filter_subject_id').val() + '&act=' + $('#act_form').val();
        $.ajax({
            url: '{{ route('hamahang.project.project_filter_priority') }}',
            method: 'POST',
            dataType: "json",
            data: form_filter_priority,
            success: function (res) {
                console.log(res.data);
                if (res.success == true) {
                    $('#priority_content_area').html(res.data);
                    initDraggable();
                    //messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});
                } else if (res.success == false) {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                }
            }
        });
    }
    function filter_projects_priority_time(data) {
        console.log(data);
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.filter_time') }}',
            method: 'POST',
            dataType: "json",
            data: $("#form_filter_priority").serialize(),
            success: function (res) {
                //console.log(res.success);
                if (res.success == true) {
                    $('#priority_content_area').html(res.data);
                    initDraggable();
                    //messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});
                } else if (res.success == false) {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                }
            }
        });
    }
    function submit_change_priority(type, project_id, action) {
        $.ajax({
            url: '{{ route('hamahang.projects.priority.change') }}',
            method: 'POST',
            dataType: "json",
            data: {type: type, project_id: project_id, action: action},
            success: function (res) {
                console.log(res.success);
                if (res.success == true) {
                    //messageModal('success', '{{trans('app.operation_is_success')}}', {0: '{{trans('access.succes_insert_data')}}'});
                } else if (res.success == false) {
                    messageModal('error', '{{trans('app.operation_is_failed')}}', res.error);
                }
            }
        });
    }

</script>