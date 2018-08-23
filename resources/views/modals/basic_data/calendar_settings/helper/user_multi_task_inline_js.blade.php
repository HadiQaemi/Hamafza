<script>
    var f=[];
    var name_array=[];
    var family_array=[];
    function send_tasks(e, event) {

        var strs = $(e).val();
        var n = strs.length;
        if (n > 2) {
            $(".div_scroll_serchad_user").hide();
            $("#div_loader_searched").show();
            $('#SearchedUsers').empty();
            var mytimeout;
            clearTimeout(mytimeout);
            mytimeout=setTimeout($.post('{!! route('search_list_task') !!}', {'term': strs,selected_array:f}, function (data) {
                $("#SearchedUsers").html(data);
                $("#SearchedUsers").show();
                $('#SelectedTasks_div').empty();
                $(".div_scroll_serchad_user").show();
                $("#div_loader_searched").hide();

            }), 5000);
        }
    }
    function Select_users(e) {
        var family = $(e).attr("data_family");
        var name = $(e).attr("data_name");
        var user_id = $(e).attr("data_id");
        if (f.includes(user_id)) {
            $('li[data_id="' + user_id + '"]').removeClass('li_selected_listuser');
            var index = f.indexOf(user_id);
            f.splice(index, 1);
            var index_name = name_array.indexOf(name);
            name_array.splice(index, 1);
            var index_family = family_array.indexOf(family);
            family_array.splice(index, 1);
            $("#span_count_selected").html(f.length);
        }
        else
        {
            f.push(user_id);
            name_array.push(name);
            family_array.push(family);
            $('li[data_id="' + user_id + '"]').addClass('li_selected_listuser');


            $("#span_count_selected").html( f.length);
        }
    }
    var instance;
    $(document).ready(function(){

        function showTimeAndMultiTask(startdate, enddate, starttime, endtime, multiTaskTime) {
            startdate = startdate.split("/");
            starttime = starttime.split("-");
            newEventModal.close();
            newEventModal = $.jsPanel({
                position: {my: "center-top", at: "center-top", offsetY: 120},
                contentSize: {width: 800, height: 300},
                contentAjax: {
                    url: '{{ URL::route('modals.task_time' )}}',
                    method: 'POST',
                    dataType: 'json',
                    done: function (data, textStatus, jqXHR, panel) {
                        this.headerTitle(data.header);
                        this.content.html(data.content);
                        this.toolbarAdd('footer', [{item: data.footer}]);

                        $('input[name="startdate"]').val(startdate);
                        $('input[name="enddate"]').val(enddate);
                        $('#form-multi-tasking input[name="starttime"]').val(starttime);
                        $('#form-multi-tasking input[name="endtime"]').val(endtime);
                        $('#form-multi-tasking form').append('<input type="hidden" name="mode" value="calendar"/>');
                        $('#form-multi-tasking #title_time_task').val("");
                        $('#task_id').val(multiTaskTime);
                        $('#InsertBtn_task_time').attr('act','multiTask');
                    }
                }
            });
            newEventModal.content.html('<div class="loader"></div>');
        }

        $("#InsertBtn_task").click(function () {
            startdate = $('#startdate').val();
            starttime = $('#starttime').val();
            enddate = $('#enddate').val();
            endtime = $('#endtime').val();
            multiTaskTime = f;

            {{--messageModal('success','{{trans('tasks.create_new_task')}}' , {0:'{{trans('app.operation_is_success')}}'});--}}
            showTimeAndMultiTask(startdate,enddate,starttime,endtime,multiTaskTime);

            {{--alert('InsertBtn_task');--}}
            {{--var res = '';--}}
            {{--$.ajax({--}}
                {{--url: '{{ URL::route('hamahang.calendar_events.save_selected_task_event')}}',--}}
                {{--type: 'POST', // Send post dat--}}
                {{--data: saveObj,--}}
                {{--async: false,--}}
                {{--success: function (s) {--}}
                    {{--res = JSON.parse(s);--}}
                    {{--if (res.success == false) {--}}
                        {{--$('#' + errorMsg_id).empty();--}}
                        {{--errorsFunc('{{trans('calendar_events.ce_error_label')}}', res.error, {id: errorMsg_id}, form_id);--}}
                        {{--// $('#' + errorMsg_id).html(warning);--}}
                    {{--} else {--}}
                        {{--eventInfo = JSON.parse(res.event);--}}
                        {{--console.log(eventInfo);--}}
                        {{--console.log(eventInfo.title);--}}
                        {{--(function ($) {--}}
                            {{--$("#calendar").fullCalendar('addEventSource', [{--}}
                                {{--start: eventInfo.startdate,--}}
                                {{--end: eventInfo.enddate,--}}
                                {{--title: eventInfo.title,--}}
                                {{--color: eventInfo.bgColor,--}}
                                {{--block: true--}}
                            {{--}]);--}}
                        {{--})(jQuery_2);--}}
                        {{--sessionModal.close();--}}
                        {{--var html = '{{trans("calendar.calendar_saveSession_clicked_success_msg1")}}' + eventInfo.title + '{{trans("calendar.calendar_saved_success_msg2")}}';--}}
                        {{--messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', html);--}}
                        {{--messageModal('success', '{{trans("calendar.calendar_saveSession_clicked_success_msg_header")}}', '{!! trans("calendar.calendar_saveSession_success") !!}');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
            // for(var i=0;f[i];i++)
            // {
            //     $('#'+select).append('<option selected="selected" value='+f[i]+'>'+name_array[i]+' '+family_array[i]+'</option>').change();
            //
            // }
            // $(this).parent().parent().parent().parent().find('.jsglyph-close').click();
        });
        $('#html1').jstree({
            'core' : {
                'data' : [
                    {"id" : 1, "text" : "همه وظایف" ,"state" : { "selected" : true }},
                    // {"id" : 2, "text" : "گروه ها","state" : { "disabled" : true }},
                    // {"id" : 3, "text" : "کانال ها","state" : { "disabled" : true }},
                ]
            }
        });
        instance = $('#html1').jstree(true);
        instance.deselect_all();
        instance.select_node('1');
        $('#html1').on("select_node.jstree", function (e, data) {
            $("#div_count_selected").removeClass('selected_element');
            $("#SearchDiv").show();
            $("#SelectedDiv").hide();
        });
    });

$('#span_selected_select').click(function(){
    $("#SelectedTasks_div").hide();
    $("#div_loader").show();
    $("#div_count_selected").addClass('selected_element');
    $.post('{!! route('selected_list_task') !!}', {selected_array:f}, function (info) {

        $("#SelectedTasks_div").html(info);
        $("#SelectedTasks_div").show();
        $("#div_loader").hide();
    });
    instance.deselect_all()
    $("#SearchDiv").hide();
    $("#SelectedDiv").show();
    $("#span_close_selected").show();
    });
$("#span_close_selected").click(function(){
    $("#div_count_selected").removeClass('selected_element');
        $("#SearchDiv").show();
        $("#SelectedDiv").hide();
        instance.deselect_all();
        instance.select_node('1');

});


</script>
