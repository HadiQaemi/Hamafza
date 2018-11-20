<script>
    var window_use_type = '';
    var task_assigning_type = '';
    var current_use_type_item = '';
    /*------------------------------------------------------*/
    function show_select_tasks_window_modal( use_type , item_id ,  task_assign_type  ) {
        var send_info = [
            task_assigning_type = task_assign_type,
            window_use_type = use_type,
            current_use_type_item = item_id
        ];
        {{--var JSPanel_STW = $.jsPanel({--}}
            {{--position:    {my: "center-top", at: "center-top", offsetY: 15},--}}
            {{--contentSize: {width: 900, height: 500},--}}
            {{--headerTitle: "{{ trans('tasks.select_tasks_window') }}",--}}
            {{--contentAjax: {--}}
                {{--url:      '{{route('hamahang.tasks.select_task_window')}}',--}}
                {{--autoload: true,--}}
                {{--data: send_info,--}}
                {{--type: 'post'--}}
            {{--}--}}
        {{--});--}}
        $.ajax({
            url:'{{ URL::route('hamahang.tasks.select_task_window' )}}',
            type:'post',
            data: send_info,
            dataType:'json',
            autoload: true,
            success :function(data)
            {
                console.log(data);
                var JSPanel_STW = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 1000, height: 500},
                    headerTitle: data.header,
                    content :data.content ,
                    footerToolbar:data.footer
                });
            }
        });
    }

    function show_project_info(id)
    {
        var send_info = {
            p_id: id,
            pid: id
        }
        var h = $(window).height();
        var w = $(window).width();
        $.ajax({
            url:'{{ URL::route('hamahang.project.project_info_window' )}}',
            type:'post',
            data: send_info,
            dataType:'json',
            success :function(data)
            {
                    console.log(data);
                    calendarModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 120},
                    // contentSize: {width: 1000, height: 600},
                    panelSize: {width: w * 0.7, height: h * 0.7},
                    headerTitle: data.header,
                    content :data.content ,
                    footerToolbar:data.footer
                });
            }
        });
    }

    function show_project_tasks(id)
    {
        var send_info = {
            p_id: id,
            pid: id
        }
        var h = $(window).height();
        var w = $(window).width();
        $.ajax({
            url:'{{ URL::route('hamahang.project.show_project_tasks' )}}',
            type:'post',
            data: send_info,
            dataType:'json',
            success :function(data)
            {
                console.log(data);
                calendarModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 120},
                    // contentSize: {width: 1000, height: 600},
                    panelSize: {width: w * 0.7, height: h * 0.7},
                    headerTitle: data.header,
                    content :data.content ,
                    footerToolbar:data.footer
                });
            }
        });
    }

    function show_task_info(id) {
        var send_info = {
            t_id: id
        }
        $.ajax({
            url:'{{ URL::route('hamahang.tasks.task_info' )}}',
            type:'post',
            data: send_info,
            dataType:'json',
            success :function(data)
            {
                calendarModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 1000, height: 500},
                    headerTitle: data.header,
                    content :data.content ,
                    footerToolbar:data.footer
                });
            }
        });
        {{--var JSPanel_STInfo = $.jsPanel({--}}
            {{--position:    {my: "center-top", at: "center-top", offsetY: 15},--}}
            {{--contentSize: {width: 1000, height: 550},--}}
            {{--headerTitle: "{{ trans('tasks.modal_task_details_tabs_information') }}",--}}
            {{--contentAjax: {--}}
                {{--url:      '{{route('hamahang.tasks.task_info')}}',--}}
                {{--autoload: true,--}}
                {{--method: post,--}}
                {{--data: send_info--}}
            {{--}--}}
        {{--});--}}

    }
</script>