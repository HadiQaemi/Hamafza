<script>
    {{--function show_create_new_task_window() {--}}
        {{--var JSPanel_CN_Task = $.jsPanel({--}}
            {{--position: {my: "center-top", at: "center-top", offsetY: 15},--}}
            {{--contentSize: {width: 900, height: 500},--}}
            {{--headerTitle: "{{ trans('tasks.create_new_task') }}",--}}
            {{--contentAjax: {--}}
                {{--url: '{{route('Tasks.CreateNewTaskWindow', $uname)}}',--}}
                {{--autoload: true--}}
            {{--}--}}
        {{--});--}}
    {{--}--}}
    function show_create_new_task_window() {
        $.ajax({
            url:'{{ URL::route('Tasks.CreateNewTaskWindow', $uname )}}',
            type:'post',
            dataType:'json',
            success :function(data)
            {
                console.log(data);
                calendarModal = $.jsPanel({
                    position: {my: "center-top", at: "center-top", offsetY: 15},
                    contentSize: {width: 1000, height: 500},
                    headerTitle: data.header,
                    content :data.content,
                    footerToolbar:data.footer
                });
            }
        });
    }
</script>