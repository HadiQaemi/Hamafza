<div id="add_form_error"></div>
<form id="calendar_add_info_form">
    <input type="hidden" id="form_add_item" name="item_id" value=""/>
    <table class="table table-bordered table-striped col-md-12">
        <tbody>
        <tr>
            <td class="col-md-2">
                <label>
                    <span class="required">*</span>
                    <span>{{trans('calendar.modal_calendar_title_field_label')}}</span>
                </label>
            </td>
            <td class="col-md-10">
                <input name="title" id="add_item_title" class="form-control" placeholder="">
            </td>
        </tr>
        <tr>
            <td class=" col-md-2">
                <label>
                    <span class="require">*</span>
                    <span>{{trans('calendar.modal_calendar_type_field_label')}}</span>
                </label>
            </td>
            <td class="col-md-10">
                <label>
                    <input name="type" type="radio" id="add_item_type" value="1">
                    <span>{{trans('calendar.modal_calendar_type_field_ch1')}}</span>
                </label>
                <label>
                    <input name="type" type="radio" id="item_type" value="2">
                    <span>{{trans('calendar.modal_calendar_type_field_ch2')}}</span>
                </label>

            </td>
        </tr>
        <tr>
            <td class="col-md-2">
                <label class="form-check-label">
                    <span>{{trans('calendar.modal_calendar_default_field_label')}}</span>
                </label>
            </td>
            <td class="col-md-10">
                <div class="form-check">
                    <input name="is_default" type="checkbox" id="is_default" class="form-check-input" value="1">
                </div>
            </td>
        </tr>
        <tr>
            <td class=" col-md-2">
                <label>{{trans('calendar.modal_calendar_descriotion_field_label')}}</label>
            </td>
            <td class="col-md-10">
                <textarea name="description" class="form-control" id="item_descriotion"></textarea>
            </td>
        </tr>
        <tr>
            <td class="col-md-12" colspan="2">
                <div class="form-check">
                    <label class="form-check-label">
                        <span>{{trans('calendar.modal_calendar_addConfig_field_label')}}</span>
                        <input name="addConfig" type="checkbox" class="form-check-input" value="1">
                    </label>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>
<script>
    $(document).ready(function () {
        $('.add-calendar').click(function () {
            var postObj = {};
            parid = $('.add-calendar').parent().parent().attr('id');
            postObj.htype = $('#calendar_add_info_form  input[name ="type"]:checked').val();
            postObj.htitle = $('#calendar_add_info_form  input[name ="title"]').val();
            if ($('input[name="is_default"]').is(':checked')) {
                postObj.his_default = 1;
            }
            else {
                postObj.his_default = 0
            }
            postObj.description = $(' #calendar_add_info_form  textarea[name ="description"]').val();
            postObj.showConfig = $('#calendar_add_info_form input[name="addConfig"]').is(':checked') ? 1 : 0;
            loading({id: 'personalCalendarGrid'}, 1);
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.add_new_calendar' )}}',
                type: 'post', // Send post dat
                data: postObj,
                async: false,
                success: function (s) {
                    s = JSON.parse(s);
                    if (s.success == false) {
                        $('#add_form_error').empty();
                        errorsFunc('', s.error, {id: 'add_form_error'}, 'calendar_add_info_form');
                        // $('#add_form_error').html(warning);
                    }
                    else {
                        if (isFunction(window.reloadGrid)) {
                            window.reloadGrid();
                        }else
                        {
                            window.location = '{{route('ugc.desktop.hamahang.calendar.index',['username'=>auth()->user()->Uname])}}'
                        }
                        loading({id: 'personalCalendarGrid'}, 0);
                        // $('#item_add').modal('hide');
                        //console.log(parid);
                        $("#" + parid + " .jsPanel-btn-close").click();
                        //calendarModal.close();
                        if (s.sowConfig == 1) {
                            if (isFunction(window.ediPersonalCalendar)) {
                                window.ediPersonalCalendar(s.id);
                            }else
                            {
                                window.location = '{{route('ugc.desktop.hamahang.calendar.index',['username'=>auth()->user()->Uname])}}'
                            }
                        }
                    }
                }
                ,
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err);
                }
            });
        });
    });
</script>