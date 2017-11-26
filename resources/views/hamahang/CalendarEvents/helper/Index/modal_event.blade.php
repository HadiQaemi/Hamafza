<!-- modal for the new user event--->
{{--<div class="modal fade" id="add_event_dialog">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans('calendar_events.ce_modal_event_header_title')}}</span>:
                    <span class="bg-warning"
                          style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div><!-- end modal header -->
            <div class="modal-body">--}}
                <div id="errMSg"></div>
                <form class="form-controller " id="form-event">
                    <table class="table table-bordered table-striped col-md-12" style="width: 95%">
                            <tbody>
                            <tr>
                                <td class="col-md-2">
                                    <label>
                                        <span class="required">*</span>
                                        {{trans('calendar_events.ce_modal_events_title_field_lable')}}
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <input name="title" class="form-control"
                                           placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td class=" col-md-2">
                                    <label>
                                        <span class="required">*</span>
                                        {{trans('calendar_events.ce_modal_events_cid_field_lable')}}
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <select name="cid" class="chosen-rtl">

                                    </select>
                                </td>
                            </tr>
                            <tr>

                                <td class="col-md-2">

                                    <label class="line-height-30 pull-right"> {{trans('calendar_events.ce_startdate_label')}}</label>
                                </td>
                                <td class="col-md-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                                <span class="input-group-addon" id="startdate-session ">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text"
                                                   class="form-control DatePicker  clsDatePicker col-xs-4"
                                                   name="startdate"
                                                   placeholder="{{trans('calendar_events.ce_date_label')}}"
                                                   aria-describedby="startdate-session">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2"></div>
                                    <div class="col-sm-5 col-xs-5">
                                        <div class=' input-group date'>
                                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>


                                            <input type="text" class="form-control TimePicker"
                                                    placeholder="{{trans('calendar_events.ce_hour_label')}}"
                                                   name="starttime"
                                                   aria-describedby="starttime">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <td class="col-md-2">

                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_enddate_label')}}</label>
                                </td>
                                <td class="col-md-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                                <span class="input-group-addon" id="enddate-session ">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text"
                                                   class="form-control DatePicker  clsDatePicker col-xs-4"
                                                   name="enddate"
                                                   placeholder="{{trans('calendar_events.ce_date_label')}}"
                                                   aria-describedby="enddate-session">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2"></div>
                                    <div class="col-sm-5 col-xs-5">
                                        <div class=' input-group date'>
                                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>


                                            <input type="text" class="form-control TimePicker"
                                                   placeholder=" {{trans('calendar_events.ce_hour_label')}}"
                                                   name="endtime"
                                                   aria-describedby="endtime">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class=" col-md-3">

                                        <label
                                                class="form-check-label">{{trans('calendar_events.ce_allday_label')}}
                                        </label>
                                </td>
                                <td class="col-md-10">
                                    <input name="allDay" type="checkbox"
                                           class="form-check-input" value="1">

                                </td>
                            </tr>
                            <tr>

                                <td class="col-md-2">
                                    <label>{{trans('calendar_events.ce_description_label')}}</label>
                                </td>
                                <td class="col-md-10">
                            <textarea name="descriotion" class="form-control"
                            ></textarea>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </form>
       {{--</div><!-- end modal body-->
        <div class="modal-footer">
            <button type="button" name="saveEvent" id="saveEvent" value="save"
                    class="btn btn-success"
                    type="button">
                <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                <span>{{trans('calendar_events.ce_saved_label')}}</span>
            </button>
        </div>
    </div><!-- end modal-content--->
</div>
</div>--}}
<script>
    $(".DatePicker").persianDatepicker({

        autoClose: true,
        format: 'YYYY-MM-DD',

    });
    $(".DatePicker").val('');
    $(".TimePicker").persianDatepicker({
        format: "HH:mm",
        timePicker: {
            //showSeconds: false,
        },
        onlyTimePicker: true
    });
    $(".TimePicker").val('');
    $.ajax({
        url: '{{ URL::route('auto_complete.get_user_calendar')}}',
        type: 'Post', // Send post dat

        success: function (s) {
            s = JSON.parse(s);

            var options = '';
            $('select[name="cid"]').empty();
            for (var i = 0; i < s.length; i++) {
                if(s[i].is_default ==1)
                {
                    options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                }
                else{
                    options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                }


            }
            $('select[name="cid"]').append(options);
            $('select[name="cid"]').select2({
                dir: "rtl",
                width: '100%',
            });
        }
    })
</script>