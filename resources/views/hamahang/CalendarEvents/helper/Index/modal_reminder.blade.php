<!--- new Reminder modal-------------->
{{--<div class="modal fade" id="new_reminder_dialog" ->
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans('calendar_events.ce_modal_reminder_header_title')}} </span>:
                    <span class="bg-warning"
                          style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
                <ul class='nav nav-wizard'>

                    <li class='active'><a href='#step1'>{{trans('calendar_events.ce_modal_reminder_navbar_nav1')}} </a></li>

                    <li><a href='#step2'>{{trans('calendar_events.ce_modal_reminder_navbar_nav2')}} </a></li>


                </ul>
            </div><!-- end modal header -->
            <div class="modal-body">
<ul class='nav nav-wizard'>

    <li class='active'><a href='#step1'>{{trans('calendar_events.ce_modal_reminder_navbar_nav1')}} </a></li>

    <li><a href='#step2'>{{trans('calendar_events.ce_modal_reminder_navbar_nav2')}} </a></li>


</ul>--}}
<div class="container table-bordered" style="width: 95%">
    <div class="reminder_errorMsg"></div>

    <form id="reminder_form" role="form" class="form-horizontal">
        <div id="form-user-event-reminder">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#step1" data-toggle="tab">
                        <span>{{trans('calendar_events.ce_modal_reminder_navbar_nav1')}}</span>
                    </a>
                </li>
                <li>
                    <a href="#addR" data-toggle="tab">{{traNS('calendar_events.ce_modal_reminder_added')}}</a>
                </li>
                <li>
                    <a href="#listR" data-toggle="tab">{{traNS('calendar_events.ce_modal_reminder_registerd_list')}}</a>
                </li>
            </ul>
            <div class="tab-content" style="overflow: auto;max-height: 300px; ">
                <div id="step1" class="tab-pane fade in active">
                    <div class="panel panel-info col-md-12">
                        <div class="panel-body">
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>
                                        <span class="required">*</span>
                                        {{trans('calendar_events.ce_modal_events_title_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="title" class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>
                                        {{trans('calendar_events.ce_modal_events_cid_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="cid" class="chosen-rtl"> </select>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">

                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_startdate_label')}}</label>

                                </div>
                                <div class="col-xs-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text"
                                                   class="form-control DatePicker  clsDatePicker col-xs-3"
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
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">

                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_enddate_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            <input type="text"
                                                   class="form-control DatePicker  clsDatePicker col-xs-3"
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
                                                   placeholder="{{trans('calendar_events.ce_hour_label')}}"
                                                   name="endtime"
                                                   aria-describedby="endtime">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">

                                    <label
                                            class="form-check-label">{{trans('calendar_events.ce_allday_label')}}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="allDay" type="checkbox"
                                           class="form-check-input" value="1">
                                </div>
                            </div>

                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>{{trans('calendar_events.ce_description_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <textarea name="descriotion" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--    <div id="step2" class="tab-pane fade">
                        <div class="panel panel-info col-md-12">
                            <div class="panel-body">
                                <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20 line-height-35">

                                    {{--<tfoot>
                                    <tr>
                                        <td colspan="2" class="col-md-12">
                                            <button type="button" name="saveReminderUserEvent" id="saveReminderUserEvent"
                                                    class="btn btn-info pull-left">
                                                <i class="glyphicon  glyphicon-arrow-left bigger-125"><span>{{trans('calendar_events.x')}}</span></i>
                                            </button>
                                        </td>
                                    </tr>

                                    </tfoot>--
                                    </table>
                                </div>

        </form>
    </div>
    <div id="form-reminder-content" class="form-reminder-content">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#addR" data-toggle="tab">{{traNS('calendar_events.ce_modal_reminder_added')}}</a>
            </li>
            <li><a href="#listR" data-toggle="tab">{{traNS('calendar_events.ce_modal_reminder_registerd_list')}}</a>
            </li>
        </ul>
        <div class="tab-content clearfix">
            <div class="tab-pane" id="addR">--}}
                <div id="addR" class="tab-pane">
                    <div class="col-md-12 text-center">
                        <label class="form-radio-label ">{{trans('calendar_events.ce_modal_reminder_first_type')}}
                            <input name="reminderType" type="radio"
                                   class="form-radio-input" value="1" checked>
                        </label>
                        <label class="form-radio-label ">{{trans('calendar_events.ce_modal_reminder_second_type')}}
                            <input name="reminderType" type="radio"
                                   class="form-radio-input" value="2">
                        </label>
                    </div>
                    <div class="clearfixed"></div>
                    <div class="add-reminder-row-firstType panel panel-primary">
                        <div class="panel-heading"><h4
                                    class="panel-title">{{trans('calendar_events.ce_modal_reminder_first_type')}} </h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">

                                <div class="col-xs-2">
                                    <label>
                                        {{trans('calendar_events.ce_modal_reminder_in_day')}}
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group pull-right clsDatePicker">
                                         <span class="input-group-addon">
                                             <i class="fa fa-calendar"></i>
                                         </span>
                                        <input type="text"
                                               class="form-control DatePicker clsDatePicker col-xs-2"
                                               value=" "
                                               name="in_day[]"
                                               aria-describedby="in_day[]">
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <label>{{trans('calendar_events.ce_hour_label')}}</label>
                                </div>
                                <div class="col-md-4">
                                    <div class=' form-horizontal input-group date'>
                                             <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-time"></span>
                                         </span>


                                        <input type="text" class="form-control TimePicker"
                                               placeholder="ا"
                                               name="firstTyp_term[]"
                                               placeholder=""
                                               aria-describedby="term">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20 line-height-35">
                                <div class="col-md-2">
                                    <label> {{trans('calendar_events.ce_modal_reminder_notice_type')}}</label></div>
                                <div class="col-md-8" colspan="2">

                                    <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_in_events')}}
                                        <input name="firstType_in_event[]" type="checkbox"
                                               class="form-check-input" value="1">
                                    </label>
                                    <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_in_notification')}}
                                        <input name="firstType_notification[]" type="checkbox"
                                               class="form-check-input" value="1">
                                    </label>
                                    <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_sms')}}
                                        <input name="firstType_sms[]" type="checkbox"
                                               class="form-check-input" value="1">
                                    </label>
                                    <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_email')}}
                                        <input name="firstType_email[]" type="checkbox"
                                               class="form-check-input" value="1">
                                    </label>

                                </div>
                                <div class="col-md-2">

                                    <a class="center-block btn btn-info btn-block fa fa-floppy-o "
                                       href="#"
                                       style="margin-top:20px;"
                                       onclick="addFirstType(this);"> {{trans('calendar_events.saved')}}</a>


                                    <!-- <a class="center-block btn btn-default btn-xs fa fa-close" href="#"
                                        style="margin-top:20px;" onclick="removeFirstType(this);"></a>-->

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="add_secondType_nav">
                        <div class="add-reminder-row-secondType panel panel-primary">
                            <div class="panel-heading"><h4
                                        class="panel-title">{{trans('calendar_events.ce_modal_reminder_second_type')}}</h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                    <div class="col-xs-2">

                                        <label>{{trans('calendar_events.ce_modal_reminder_befor_of')}}</label>
                                    </div>
                                    <div class="col-xs-4">

                                        <select name="befordays[]" class="form-control col-md-6">
                                            <option value="0">{{trans('calendar_events.ce_selected')}}</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="1">4</option>
                                            <option value="1">5</option>
                                            <option value="1">6</option>

                                        </select>
                                        <select name="beforType[]" class="form-control col-md-6">
                                            <option value="0">{{trans('calendar_events.ce_selected')}}</option>
                                            <option value="1">{{trans('calendar_events.ce_modal_reminder_day')}}</option>
                                            <option value="2">{{trans('calendar_events.ce_modal_reminder_week')}}</option>
                                            <option value="3">{{trans('calendar_events.ce_modal_reminder_month')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{trans('calendar_events.ce_modal_reminderin_hour')}}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class=' form-horizontal input-group date'>
                                             <span class="input-group-addon">
                                             <span class="glyphicon glyphicon-time"></span>
                                         </span>


                                            <input type="text" class="form-control TimePicker"
                                                   placeholder="ا"
                                                   name="secondType_term[]"
                                                   aria-describedby="term">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">

                                    <div class="col-md-2">
                                        <label>{{trans('calendar_events.ce_modal_reminder_notice_type')}}</label>
                                    </div>
                                    <div class="col-md-8" colspan="2">
                                        <div class="form-check">
                                            <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_in_events')}}
                                                <input name="secondType_in_event[]" type="checkbox"
                                                       class="form-check-input" value="1">
                                            </label>
                                            <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_in_notification')}}
                                                <input name="secondType_notification[]" type="checkbox"
                                                       class="form-check-input" value="1">
                                            </label>
                                            <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_sms')}}
                                                <input name="secondType_sms[]" type="checkbox"
                                                       class="form-check-input" value="1">
                                            </label>
                                            <label class="form-check-label ">{{trans('calendar_events.ce_modal_reminder_email')}}
                                                <input name="secondType_email[]" type="checkbox"
                                                       class="form-check-input" value="1">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">


                                        <a class="center-block btn btn-info btn-block fa fa-floppy-o "
                                           href="#"
                                           style="margin-top:20px;"
                                           onclick="addSecondType(this);">  {{trans('calendar_events.saved')}} </a>


                                        <!--<a class="center-block btn btn-default btn-xs fa fa-close" href="#"
                                           style="margin-top:20px;" onclick="removeSecondType(this);"></a>-->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="listR">
                    <table class=" col-md-12 table table-bordered  " id="reminderList">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th>  {{trans('calendar_events.ce_date_label')}} </th>
                            <th>  {{trans('calendar_events.ce_hour_label')}} </th>
                            <th>  {{trans('calendar_events.ce_action_label')}} </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <input name="event_id" type="hidden" value=""/>
        </div>
        {{-- </div>
        </div>
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
                dataType: 'json',
                success: function (s) {

                    var options = '';
                    $('select[name="cid"]').empty();
                    for (var i = 0; i < s.length; i++) {
                        if (s[i].is_default == 1) {
                            options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                        }
                        else {
                            options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                        }


                    }

                    $('select[name="cid"]').append(options);
                    $('select[name="cid"]').select2({
                        dir: "rtl",
                        width: '100%',
                    });
                }
            });

            /*############################################################################################*/
            /*---------------------------------------------------------------------------------------------*/
            /*---------------------------------clone of reminder type2--------------------------------------*/
            /*---------------------------------------------------------------------------------------------*/

            $('.add-reminder-row-secondType2').hide();
            $('input[name="reminderType2"]').change(function () {

                if ($('input[name="reminderType2"]:checked').val() == 1) {
                    $('.add-reminder-row-firstType2').show();
                    $('.add-reminder-row-secondType2').hide();
                } else {
                    $('.add-reminder-row-firstType2').hide();
                    $('.add-reminder-row-secondType2').show();
                }
            });
            /*################################################################################################*/
            /*-----------------------------------------------------------------------------------------------*/
            /*---------------------------------clone of reminder type2--------------------------------------*/
            /*---------------------------------------------------------------------------------------------*/
            $('.add-reminder-row-secondType').hide();
            $('input[name="reminderType"]').change(function () {

                if ($('input[name="reminderType"]:checked').val() == 1) {
                    $('.add-reminder-row-firstType').show();
                    $('.add-reminder-row-secondType').hide();
                } else {
                    $('.add-reminder-row-firstType').hide();
                    $('.add-reminder-row-secondType').show();
                }
            });


        </script>