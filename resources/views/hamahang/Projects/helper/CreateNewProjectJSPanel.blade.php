<script>
    function show_create_new_project_window() {
        var JSPanel_CN_Task = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 900, height: 500},
            headerTitle: "{{ trans('tasks.create_new_task') }}",
            contentAjax: {
                url: '{{route('Project.project_window', $uname)}}',
                autoload: true
            }
        });
    }
</script>