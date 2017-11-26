<script>
    function show_create_new_process_window() {
        var JSPanel_CN_Task = $.jsPanel({
            position: {my: "center-top", at: "center-top", offsetY: 15},
            contentSize: {width: 900, height: 500},
            headerTitle: "{{ trans('process.new_process') }}",
            contentAjax: {
                url: '{{route('Process.process_window')}}',
                autoload: true,
                type: 'post'
            }
        });
    }
</script>