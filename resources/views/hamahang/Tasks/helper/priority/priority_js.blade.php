<script>

    $(".DatePicker").persianDatepicker({
        autoClose: true,
        format: 'YYYY-MM-DD'
    });

    $(document).ready(function () {

        initDraggable();
        $('#form_filter_priority').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            filter_tasks_priority();
        });
        $('#form_filter_priority_time').on('keyup change', 'input, select, textarea', 'checkbox', function () {
            filter_tasks_priority_time();
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
                daySplit = day.split('-');
                var dropped = ui.draggable;
                var task_id = dropped.data('task_id');
                var Drag_Action = dropped.data('action');
                var title = dropped.data('title');
                if(Drag_Action=='task_timing')
                {
                    var droppedOn = $(this);
                    showTimeAndTask(title,day,day,hour,hour,droppedOn,task_id);
                    subClass = '';
                    for(sd=1;sd<daySplit[2];sd++)
                    {
                        subClass += ' subClass'+sd;
                    }
                    $('#table_task_time').append(
                            '<li class="draggable task_item_'+task_id+' ui-draggable ui-draggable-handle dynamic-add-task '+subClass+'" data-action="task_timing" data-title="'+title+'" data-task_id="'+task_id+'">'+
                                $('.task_item_'+task_id).html()+
                            '</li>');

                    x = $('#'+Drag_Destination).position();
                    startdate = day.split('-');
                    starttime = hour.split(':');
                    var table_task_time = $('#table_task_time').width();
                    var start_stamo = parseInt(starttime[0]*60)+parseInt(starttime[1]);

                    $('#table_task_time .task_item_'+task_id).css('position','absolute');
                    $('#table_task_time .task_item_'+task_id).css('right',Math.floor((table_task_time*start_stamo)/(24*60)-table_task_time/24)+'px');
                    $('#table_task_time .task_item_'+task_id).css('width',parseInt(table_task_time/12)+'px');
                    $('#table_task_time .task_item_'+task_id).css('top',x.top+'px');

                }else{
                    submit_change_priority(Drag_Destination, task_id);
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

    function showTimeAndTask(title, startdate, enddate, starttime, endtime, droppedOn,task_id) {
        console.log(droppedOn);
        startdate = startdate.split("/");
        starttime = starttime.split("-");
        endtime = starttime[0];
        starttime = starttime[1];

        newEventModal = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 800, height: 300},
            contentAjax: {
                url: '{{ URL::route('modals.task_time' )}}',
                method: 'POST',
                dataType: 'json',
                done: function (data, textStatus, jqXHR, panel) {
                    this.headerTitle(data.header);
                    this.content.html(data.content);
                    this.toolbarAdd('footer', [{item: data.footer}]);

                    $('#form-multi-tasking input[name="startdate"]').val(startdate);
                    $('#form-multi-tasking input[name="enddate"]').val(enddate);
                    $('#form-multi-tasking input[name="starttime"]').val(starttime);
                    $('#form-multi-tasking input[name="endtime"]').val(endtime);
                    $('#form-multi-tasking #take_title').text("{{trans('calendar.modal_calendar_setting_title')}} : " + title);
                    $('#form-multi-tasking form').append('<input type="hidden" name="mode" value="calendar"/>');
                    $('#form-multi-tasking #title_time_task').val(title);
                    $('#form-multi-tasking #droppedOn').val(droppedOn);
                    $('#form-multi-tasking #task_id').val(task_id);
                }
            }
        });

        newEventModal.content.html('<div class="loader"></div>');

    }
    function filter_tasks_priority(data) {
        console.log(data);
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.filter') }}',
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
    function filter_tasks_priority_time(data) {
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
    function submit_change_priority(type, task_id) {
        $.ajax({
            url: '{{ route('hamahang.tasks.priority.change') }}',
            method: 'POST',
            dataType: "json",
            data: {type: type, task_id: task_id},
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