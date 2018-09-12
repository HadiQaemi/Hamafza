<div>
    <div id="edit_form_error"></div>
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#t1" id="pan_t1" data-toggle="tab">
                <span>{{trans("calendar.modal_calendar_define")}}</span>
            </a>
        </li>
        {{--<li>--}}
            {{--<a href="#t2" id="pan_t2" data-toggle="tab">--}}
                {{--<span>{{trans("calendar.modal_calendar_time_template")}}</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="#t3" id="pan_t3" data-toggle="tab">--}}
                {{--<span>{{trans("calendar.modal_calendar_new_time_border")}}</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        <li>
            <a href="#t4" id="pan_t4" data-toggle="tab">
                <span>{{trans("calendar.modal_calendar_edit_monasebat_field_label")}}</span>
            </a>
        </li>
        {{--<li >--}}
            {{--<a href="#t5" data-toggle="tab">--}}
                {{--<span>{{trans('calendar.modal_calendar_setting_default_event')}}</span>--}}
            {{--</a>--}}
        {{--</li>--}}
    </ul>
    <div class="tab-content">
        <div id="t1"  class="tab-pane fade in active">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_edit" style="overflow: -webkit-paged-x;">
                    <form id="calendar_info_form">
                        <input type="hidden" id="form_edit_item_item_id" name="item_id" value=""/>
                        <div class="row line-height-35 margin-top-10">
                            <div class="col-xs-1"><label for="item_title">{{trans("calendar.modal_calendar_setting_title")}}</label></div>
                            <div class="col-xs-3"><input name="title" id="item_title" class="form-control" placeholder=""></div>
                            <div class="col-xs-3">
                                <input name="type" type="radio" id="item_type_v1" value="1">
                                <label class="" for="">{{trans("calendar.modal_calendar_type_field_ch1")}}</label>
                                <input name="type" type="radio" id="item_type_v2" value="2">
                                <label class="" for="">{{trans("calendar.modal_calendar_type_field_ch2")}}</label>
                            </div>
                            <div class="col-xs-5">
                                <label class="" for="is_default"> {{trans("calendar.modal_calendar_default_field_label")}}</label>
                                <input name="is_default" type="checkbox" id="is_default" class="form-check-input" value="1">
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-xs-2 line-height-35">
                                <label class="" for="">{{trans('calendar.modal_calendar_edit_viewPermissions_field_label')}}</label>
                            </div>
                            <div class="col-xs-10">
                                <select id="states-multi-select-users" name="viewPermissions[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar.calendar_select_user')}}" multiple>
                                    <option value=""></option>
                                    <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-xs-2 line-height-35">
                                <label class="" for="">{{trans('calendar.modal_calendar_edit_editPermissions_field_label')}}</label>
                            </div>
                            <div class="col-xs-10">
                                <select id="states-multi-select-users_edit" name="editPermissions[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar.calendar_select_user')}}" multiple>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row margin-top-10">
                            <div class="col-xs-2 line-height-35">
                                <label> {{trans("calendar.modal_calendar_descriotion_field_label")}}</label>
                            </div>
                            <div class="col-xs-10">
                                <textarea name="descriotion" class="form-control" id="item_descriotion"></textarea>
                            </div>
                        </div>
                        <div class="row margin-top-10 line-height-35">
                            <div class="col-xs-2">
                                <label> {{trans('calendar.modal_calendar_edit_prayer_times_field_label')}}</label>
                            </div>
                            <div class="col-xs-3 noLeftPadding noRightPadding">
                                <div class="col-xs-5 noLeftPadding noRightPadding">
                                    <input name="prayer_times" type="radio" id="item_prayer_times_v1" class="" value="1">
                                    <label for="item_prayer_times_v1">{{trans('calendar.modal_calendar_edit_prayer_times_radio1_label')}}</label>
                                </div>
                                <div class="col-xs-6 noLeftPadding noRightPadding">
                                    <input name="prayer_times" type="radio" id="item_prayer_times_v2" class="" value="2" checked>
                                    <label for="item_prayer_times_v2">{{trans('calendar.modal_calendar_edit_prayer_times_radio2_label')}}</label>
                                </div>
                            </div>
                            <div class="col-xs-7 noLeftPadding noRightPadding">
                                <div class="col-xs-3 noLeftPadding noRightPadding">
                                    <label> {{trans('calendar.modal_calendar_edit_prayer_times_city_privince')}}</label>
                                </div>
                                <div class="col-xs-9 noLeftPadding noRightPadding">
                                    <div class="col-xs-6 noLeftPadding noRightPadding">
                                        <select name="province" class="chosen-rtl" size="120" data-h id="province" data-placeholder="{{ trans('calendar.calendar_select_province') }}">
                                            <option value="0">{{trans('calendar.calendar_select_province')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6 noLeftPadding noRightPadding">
                                        <select name="prayer_time_city" class="chosen-rtl" data-placeholder="{{ trans('calendar.calendar_select_city') }}" id="item_prayer_time_city">
                                            <option value="0">{{trans('calendar.calendar_select_city')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-10 line-height-35">
                            <div class="col-xs-2">
                                <label> {{trans("calendar.modal_calendar_edit_beginning_day_field_label")}}</label>
                            </div>
                            <div class="col-xs-4 noLeftPadding noRightPadding">
                                <div class="col-xs-5 noLeftPadding noRightPadding">
                                    <input name="beginning_day" type="radio" id="item_beginning_day_v2" checked value="2">
                                    <label for="item_beginning_day_v2">{{trans('calendar.modal_calendar_edit_beginning_day_radio2_label')}}</label>
                                </div>
                                <div class="col-xs-7 noLeftPadding noRightPadding">
                                    <input name="beginning_day" type="radio" id="item_beginning_day_v1" value="1">
                                    <label for="item_beginning_day_v1">{{trans('calendar.modal_calendar_edit_beginning_day_radio1_label')}}</label>
                                </div>
                            </div>
                            <div class="col-xs-4 noLeftPadding noRightPadding">
                                <div class="col-xs-5 noLeftPadding noRightPadding">
                                    <input name="monasebat" id="monasebat" type="checkbox">
                                    <label for="monasebat">{{trans('calendar.modal_calendar_edit_monasebat_field_label')}}</label>
                                </div>
                                <div class="col-xs-7 noLeftPadding noRightPadding">
                                    <input name="brith_day" id="brith_day" type="checkbox">
                                    <label for="brith_day">{{trans('calendar.modal_calendar_edit_brith_day_field_label')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-10 line-height-35" style="border-top: solid 1px #eee;padding-top:10px;margin-bottom: 20px">
                            <div class="col-xs-2">
                                <label> {{trans("calendar.modal_calendar_edit_hiddentime_field_label")}}</label>
                            </div>
                            <div class="col-xs-10 noLeftPadding noRightPadding" id="hidentime">
                                <div id="hiden_holder">
                                    <div class="col-xs-1 noLeftPadding noRightPadding"><label> {{trans('calendar.calendar_from')}}</label></div>

                                    <div class='col-xs-4 form-horizontal input-group date noLeftPadding noRightPadding pull-right'>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar.calendar_from')}}" name="hidden_from[]" id="hidden_from" aria-describedby="respite_time">
                                    </div>
                                    <div class="col-xs-1 noLeftPadding noRightPadding pull-right"><label> {{trans('calendar.calendar_to')}}</label></div>
                                    <div class='col-xs-4  form-horizontal input-group date noLeftPadding noRightPadding pull-right'>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                        <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar.calendar_to')}}" name="hidden_to[]" id="hidden_to" aria-describedby="respite_time">
                                    </div>
                                    <div class="col-xs-2">
                                        <a class="btn btn-default btn-xs fa fa-clone" href="#" onclick="addNewHideTime();"></a>
                                        <a class="btn btn-default btn-xs fa fa-close" href="#" onclick="removeAllHiddenTime();"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-10 line-height-35" id="sharingSelect" style="padding-top:10px;">
                            <div id="sharingSelect">
                                <table class="table  col-md-12">
                                    <tbody>
                                    <tr>
                                        <td class="col-md-3 noLeftPadding noRightPadding">
                                            <label>
                                                {{trans('calendar.modal_calendar_edit_sharing_calendar_field_label')}}
                                            </label>
                                        </td>
                                        <td class='col-md-2 noLeftPadding noRightPadding'>
                                            <select name="sharing_calendar_list[]" id="sharing_calendar_list" class=" col-xs-6 chosen-rtl"></select>
                                        </td>
                                        <td class='col-md-5 noLeftPadding noRightPadding'>
                                            <div class="col-xs-4 noRightPadding">
                                                <label class="noLeftPadding noRightPadding">
                                                    <span id="no_sharing">{{trans('calendar.modal_calendar_no_sharing')}}</span>
                                                    <input type="radio" name="sharing_type[]" value="no_sharing">
                                                </label>
                                            </div>
                                            <div class="col-xs-3 noLeftPadding noRightPadding">
                                                <label class="noLeftPadding noRightPadding">
                                                    <span id="time_border">{{trans('calendar.modal_calendar_time_border')}}</span>
                                                    <input type="radio" name="sharing_type[]" value="time_border">
                                                </label>
                                            </div>
                                            <div class="col-xs-4 noLeftPadding noRightPadding">
                                                <label class="noLeftPadding noRightPadding">
                                                    <span id="event_detail">{{trans('calendar.modal_calendar_event_detail')}}</span>
                                                    <input type="radio" name="sharing_type[]" value="event_detail">
                                                </label>
                                            </div>
                                        </td>
                                        <td class='col-md-2 noLeftPadding noRightPadding'>
                                            <div class="input-group colorpicker-component sharing-color">
                                                <input type="text" value="" name="sharing-color[]" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>
                                                $(function () {
                                                    $('.sharing-color').colorpicker({
                                                        container: '.sharing-color'
                                                    });
                                                });
                                            </script>
                                        </td>
                                        <td class="col-md-1 noLeftPadding noRightPadding">
                                            <a class="btn btn-default btn-xs fa fa fa-floppy-o"
                                               href="#"
                                               title="{{trans('calendar.save')}}"
                                               alt = "{{trans('calendar.save')}}"
                                               onclick="addNewSharing(this);"></a>
                                            <!-- <a class="btn btn-default btn-xs fa fa-close" href="#"
                                                onclick="removeSharing(this);"></a>-->
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row margin-top-10 line-height-35" id="sharingSelect" style="padding-top:10px;">
                            <div id="lastShring" class="hidden">
                                <table id="" class="table table-inverse">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{trans('calendar.modal_calendar_title_field_label')}}</th>
                                        <th>{{trans('calendar.modal_calendar_share_type_label')}}</th>
                                        <th>{{trans('calendar.modal_calendar_color_field_label')}}</th>
                                        <th>{{trans('calendar.calendar.action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="t2" class="tab-pane fade">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_setting">
                    <form class="form-inline" id="calendar_setting_form">
                        <table class="table table-bordered col-md-12">
                            <tbody>

                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="t3" class="tab-pane fade">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_permission">
                    <form class="form-inline" id="calendar_permission_form">
                        <div class="row line-height-35 margin-top-10">
                            <div class="row col-xs-12">
                                <div class="col-xs-1 noLeftPadding noRightPadding"><label for="interval_title">{{trans("calendar.modal_calendar_setting_title")}}:</label></div>
                                <div class="col-xs-11 noLeftPadding noRightPadding"><input name="interval_title" id="interval_title" class="form-control" placeholder=""></div>
                            </div>
                            <div class="row col-xs-12 line-height-35 margin-top-10">
                                <div class="col-xs-1 noLeftPadding noRightPadding"><label for="">{{trans("calendar.modal_calendar_priod")}}:</label></div>
                                <div class="col-xs-1 noLeftPadding noRightPadding">
                                    <label for="interval_from">{{trans("calendar.modal_calendar_from")}}</label>
                                </div>
                                <div class="col-xs-1 noLeftPadding noRightPadding">
                                    <input name="interval_from" id="interval_from" class="form-control" size="2" placeholder="">
                                </div>
                                <div class="col-xs-1 noLeftPadding noRightPadding">
                                    <label for="interval_until">{{trans("calendar.modal_calendar_until")}}</label>
                                </div>
                                <div class="col-xs-1 noLeftPadding noRightPadding">
                                    <input name="interval_until" id="interval_until" class="form-control" size="2" placeholder="">
                                </div>
                            </div>
                            <div class="row col-xs-12 line-height-35 margin-top-10">
                                <div class="col-xs-1 noLeftPadding noRightPadding"><label for="">{{trans("calendar.modal_calendar_type")}}:</label></div>
                                <div class="col-xs-2 noLeftPadding noRightPadding">
                                    <input name="interval_type" type="radio" id="interval_offline" value="meeting">
                                    <label for="interval_offline">{{trans("calendar.modal_calendar_offline")}}</label>
                                </div>
                                <div class="col-xs-1 noLeftPadding noRightPadding">
                                    <input name="interval_type" type="radio" id="interval_meeting" value="meeting">
                                    <label for="interval_meeting">{{trans("calendar.modal_calendar_meeting")}}</label>
                                </div>
                            </div>
                            <div class="row col-xs-12 line-height-35 margin-top-10" style="border-bottom: solid 1px #ccc;margin-bottom: 10px;padding-bottom: 50px">
                                <div class="col-xs-2 noLeftPadding noRightPadding"><label for="">{{trans("calendar.modal_calendar_announce_start")}}:</label></div>
                                <div class="col-xs-2 noLeftPadding noRightPadding">
                                    <input name="interval_announce_by_events" type="checkbox" id="interval_announce_by_events" value="1">
                                    <label for="interval_announce_by_events">{{trans("calendar.events")}}</label>
                                </div>
                                <div class="col-xs-2 noLeftPadding noRightPadding">
                                    <input name="interval_announce_by_notification" type="checkbox" id="interval_announce_by_notification" value="1">
                                    <label for="interval_announce_by_notification">{{trans("calendar.notification")}}</label>
                                </div>
                                <div class="col-xs-2 noLeftPadding noRightPadding">
                                    <input name="interval_announce_by_sms" type="checkbox" id="interval_announce_by_sms" value="1">
                                    <label for="interval_announce_by_sms">{{trans("calendar.sms")}}</label>
                                </div>
                                <div class="col-xs-2 noLeftPadding noRightPadding">
                                    <input name="interval_announce_by_email" type="checkbox" id="interval_announce_by_email" value="1">
                                    <label for="interval_announce_by_email">{{trans("calendar.email")}}</label>
                                </div>
                                <div class="col-xs-2 noLeftPadding noRightPadding">
                                    <input name="interval_announce_by_execution" type="checkbox" id="interval_announce_by_execution" value="1">
                                    <label for="interval_announce_by_execution">{{trans("calendar.execution")}}</label>
                                </div>
                            </div>
                            <div class="input-group col-xs-12 line-height-35 margin-top-10">
                                <div class="col-xs-1">
                                    <label class="pull-right line-height-35" >{{trans('calendar.modal_calendar_repeate')}}:</label>
                                </div>
                                <div class="col-xs-11">
                                    <div class="col-xs-2 noRightPadding noLeftPadding">
                                        <label class="pull-right line-height-35" >{{trans('tasks.every')}}</label>
                                        <input type="text" id="task_schedul_num" class="form-control" style="width: 40px;" name="task_schedul_num" value="" >
                                    </div>
                                    <div class="col-xs-1 noRightPadding noLeftPadding">
                                        <select id="task_schedul" name="task_schedul" class="form-control line-height-35">
                                            <option value="minute">{{trans('tasks.minute')}}</option>
                                            <option value="hour">{{trans('tasks.hour')}}</option>
                                            <option value="daily">{{trans('tasks.day')}}</option>
                                            <option value="weekly" selected="selected">{{trans('tasks.week')}}</option>
                                            <option value="monthly">{{trans('tasks.month')}}</option>
                                            <option value="seasonly">{{trans('tasks.season')}}</option>
                                            <option value="yearly">{{trans('tasks.year')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-9 div-schedul">
                                        <div class="minute col-xs-12 hidden">
                                        </div>
                                        <div class="hour col-xs-12 hidden">
                                        </div>
                                        <div class="daily col-xs-12 hidden">
                                            {{--                            {!! Form::text('daily_value', null, ['class' => 'form-control TimePicker line-height-35']) !!}--}}
                                        </div>
                                        <div class="weekly row">
                                            @for ($i = 0; $i < 7; $i++)
                                                <div class="input-group pull-right weekly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                                    <input id="weekly_value_{{$i}}" class="" style="width: 22px;" name="weekly_value[]" type="checkbox" value="{{$i}}">
                                                    <label style="line-height: 10px;" for="{{ "weekly_value_$i" }}">{{trans('tasks.array_weekly_weekdays.'.$i)}}</label>
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="monthly hidden">
                                            <div class="input-group pull-right monthly col-xs-12" style="padding: 5px;height: 52px;">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <div class="input-group pull-right monthly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                                        <input id="monthly_value_{{$i}}" class="" style="width: 22px;" name="monthly_value[]" type="checkbox" value="{{$i}}">
                                                        <label style="line-height: 10px;" for="{{ "monthly_value_$i" }}">{{trans('tasks.array_monthly_months.'.$i)}}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="seasonly hidden">
                                            <div class="input-group pull-right seasonly col-xs-12" style="padding: 5px;height: 52px;">
                                                @for ($i = 0; $i < 4; $i++)
                                                    <div class="input-group pull-right seasonly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                                        <input id="seasonly_value_{{$i}}" class="" style="width: 22px;" name="seasonly_value[]" type="checkbox" value="{{$i}}">
                                                        <label style="line-height: 10px;" for="{{ "seasonly_value_$i" }}">{{trans('tasks.array_seasonly_seasons.'.$i)}}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="yearly hidden">
                                            <div class="input-group pull-right yearly col-xs-12" style="padding: 5px;height: 52px;">
                                                @for ($i = 0; $i < 12; $i++)
                                                    <div class="input-group pull-right yearly col-lg-2 col-md-3 col-sm-4 col-xs-4" style="margin: 0 0 5px 5px;">
                                                        <input id="yearly_num_{{$i}}" class="" style="width: 10px;" name="yearly_num[]" type="checkbox" value="{{$i}}">
                                                        <label style="line-height: 10px;" for="{{ "yearly_num_$i" }}">{{trans('tasks.array_yearly_years.'.$i)}}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group col-xs-12 noRightPadding noLeftPadding line-height-35 margin-top-10">
                                <div class="col-xs-1 pull-right">
                                    <label for="r2" class="line-height-35">{{ trans('tasks.begin') }}:</label>
                                </div>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control DatePicker_begin_date" name="schedul_begin_date" aria-describedby="schedul_begin_date" id="schedul_begin_date">
                                </div>
                            </div>
                            <div class="col-xs-12 noRightPadding noLeftPadding line-height-35 margin-top-10">
                                <div class="col-xs-10 noRightPadding noLeftPadding">
                                    <div class="daily col-xs-1">
                                        <label class="line-height-35">{{ trans('tasks.end') }}:</label>
                                    </div>
                                    <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                        <input type="radio" name="schedul_end_date" value="schedul_end_date_none" id="schedul_end_date_none"/>
                                        <label for="schedul_end_date_none">{{ trans('tasks.none') }}</label>
                                    </div>
                                    <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <input type="radio" name="schedul_end_date" value="schedul_end_date_events" id="schedul_end_date_events"/>
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                            <label for="schedul_end_date_events">{{ trans('tasks.after') }}</label>
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <input type="text" id="schedul_end_date_events_" class="form-control" style="width: 40px;" name="schedul_end_num_events" value="" >
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0px; margin: 0px;">
                                            <label for="schedul_end_date_events_">{{ trans('tasks.event') }}</label>
                                        </span>
                                    </div>
                                    <div class="daily col-xs-2" style="margin: 0 0 5px 5px;">
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                            <input type="radio" name="schedul_end_date" value="schedul_end_date_date" id="schedul_end_date_date" checked/>
                                        </span>
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;height: 34px">
                                            <label for="schedul_end_date_date">{{ trans('tasks.in-date') }}</label>
                                        </span>
                                    </div>
                                    <div class="daily col-xs-3" style="margin: 0 0 5px 5px;">
                                        <span class="input-group-addon edited-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                            <input type="text" class="form-control DatePicker_end_date_date" name="schedul_end_date_date" aria-describedby="schedul_end_date_date" id="schedul_end_date_">
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div id="t4" class="tab-pane fade">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_permission">
                    <form class="form-inline" id="calendar_sharing_events_form">
                        <div class="row line-height-35">
                            <div class="col-xs-2 noLeftPadding noRightPadding">
                                <select class="form-control col-xs-8" dir="rtl" name="tab_type[1]">
                                    <option value="sun">{{trans('calendar.modal_setting_jalali')}}</option>
                                    <option value="moon">{{trans('calendar.modal_setting_gergorian')}}</option>
                                    <option value="moon">{{trans('calendar.modal_setting_ghamari')}}</option>
                                </select>
                            </div>
                            <div class="col-xs-2 noLeftPadding noRightPadding">
                                {{trans('calendar.modal_calendar_holiday_year')}}
                            </div>
                            <div class="col-xs-7 noLeftPadding noRightPadding">
                                <input type="checkbox" name="saturday"/>
                                {{trans('calendar.modal_calendar_saturday')}}
                                <input type="checkbox" name="sunday"/>
                                {{trans('calendar.modal_calendar_sunday')}}
                                <input type="checkbox" name="monday"/>
                                {{trans('calendar.modal_calendar_monday')}}
                                <input type="checkbox" name="tuesday"/>
                                {{trans('calendar.modal_calendar_tuesday')}}
                                <input type="checkbox" name="wednesday"/>
                                {{trans('calendar.modal_calendar_wednesday')}}
                                <input type="checkbox" name="thursday"/>
                                {{trans('calendar.modal_calendar_thursday')}}
                                <input type="checkbox" name="friday"/>
                                {{trans('calendar.modal_calendar_friday')}}
                            </div>
                        </div>
                        <div class="row line-height-35 margin-top-10">
                            <div class="col-xs-2 noLeftPadding noRightPadding">
                                <i class="fa fa-angle-double-right pointer"></i>
                                {{trans('calendar.month_one')}}
                                <i class="fa fa-angle-double-left pointer"></i>
                            </div>
                            <div class="col-xs-4 noLeftPadding noRightPadding">
                                <input type="checkbox" name="add_holiday_events"/>
                                {{trans('calendar.modal_calendar_add_holiday_events')}}
                            </div>
                            <div class="col-xs-6 noLeftPadding noRightPadding">
                                <select class="form-control col-xs-8" dir="rtl" name="tab_type[1]">
                                    <option value="sun">تقویم پایه</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="t5">
            <table class="table table-bordered col-xs-12 default-options">
                <thead>
                <tr>
                    <th class="text-center">{{trans('calendar.modal_calendar_setting_show')}} </th>
                    <th class="text-center">{{trans('calendar.modal_calendar_setting_title')}} </th>
                    <th class="text-center">{{trans('calendar.modal_calendar_setting_color')}} </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="jalalai"/></td>
                    <td class="col-xs-6"><label> {{trans('calendar.modal_setting_jalali_event')}}</label></td>
                    <td class="col-xs-5">
                        <div class="input-group colorpicker-component jalalai-color">
                            <input type="text" value="" name="jalalai-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.jalalai-color').colorpicker({
                                container: '.jalalai-color',
                                align: 'left'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="gergorian"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_gergorian_event')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-componen gergorian-color">
                            <input type="text" value="" name="gergorian-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.gergorian-color').colorpicker({
                                container: '.gergorian-color '
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="ghamari"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_ghamari_event')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-component ghamari-color">
                            <input type="text" value="" name="ghamari-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.ghamari-color').colorpicker({
                                container: '.ghamari-color'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="vacation"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_vocation_event')}}</label></td>
                    <td class="col-xs-5">
                        <div class="input-group colorpicker-component vacation-color">
                            <input type="text" value="" name="vacation-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.vacation-color').colorpicker({
                                container: '.vacation-color'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="event"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_event')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-component event-color">
                            <input type="text" value="" name="event-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.event-color').colorpicker({
                                container: '.event-color'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="session"></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_session')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-component session-color">
                            <input type="text" value="" name="session-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $(function () {
                                $('.session-color').colorpicker({
                                    container: '.session-color'
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="invitation"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_invitation')}}</label></td>
                    <td class="col-xs-5">
                        <div id="" class="input-group colorpicker-component invitation-color">
                            <input type="text" value="" name="invitation-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $(function () {
                                $('.invitation-color').colorpicker({
                                    container: '.invitation-color'
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="reminder"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_reminder')}}</label></td>
                    <td class="col-xs-5">
                        <div id="" class="input-group colorpicker-component reminder-color">
                            <input type="text" value="" name="reminder-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $(function () {
                                $('.reminder-color').colorpicker({
                                    container: '.reminder-color'
                                });
                            });
                        </script>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
<script>
    // $('#pan_t2').on('click', function (data) {
    //     setTimeout(function (data) {
    $(document).ready(function () {
        $.ajax({
            url: '{{ URL::route('auto_complete.provinces')}}',
            type: 'POST', // Send post dat
            async: false,
            dataType: 'json',
            success: function (data) {
                $('#province').select2({
                    data: data
                });
            }
        });
        $.ajax({
            url: '{{ URL::route('hamahang.calendar.get_own_calendar' )}}',
            type: 'POST', // Send post dat
            async: false,
            dataType: 'json',
            success: function (data) {
                var data = $.map(data, function (obj) {
                    return {id: obj.id, text: obj.title};
                });
                $('select[name="sharing_calendar_list[]"]').select2({
                    placeholder: '{{trans('app.select_a_option')}}',
                    dir: "rtl",
                    width: '100%',
                    data: data
                }).val(null).trigger('change');
            }
        });
    });
    //     }, 1000);
    // });
    $('#province').change(function () {
        var pid = $('#province').val();
        $.ajax({
            url: '{{ URL::route('auto_complete.cities')}}',
            type: 'Post', // Send post dat
            data: {pId: pid},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#item_prayer_time_city').select2({
                    placeholder: '{{trans('app.select_a_option')}}',
                    dir: "rtl",
                    width: '100%',
                    data: data,

                }).val(null).trigger('change');
            }
        });
    });
    $("select[name='viewPermissions[]']").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
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
    $("select[name='editPermissions[]']").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
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
    $('#pan_t4').on('click', function () {
        //console.log( options);
        setTimeout(function () {
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.get_own_calendar' )}}',
                type: 'POST', // Send post dat
                async: false,
                dataType: 'json',
                success: function (data) {
                    var data = $.map(data, function (obj) {
                        return {id: obj.id, text: obj.title};
                    });
                    $('select[name="sharing_calendar_list[]"]').select2({
                        placeholder: '{{trans('app.select_a_option')}}',
                        dir: "rtl",
                        width: '100%',
                        data: data
                    }).val(null).trigger('change');
                }
            });
        }, 1000);
    });
    $(".DatePicker_begin_date").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });
    $(".DatePicker_end_date_date").persianDatepicker({
        observer: true,
        autoClose: true,
        format: 'YYYY-MM-DD'
    });
    $('#task_schedul').on('change', function() {
        var schedul = $(this).val();
        $('.div-schedul div').addClass('hidden');
        $('.'+schedul).removeClass('hidden');
    });
</script>