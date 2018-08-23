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
<div id="form-content">
    <div class="reminder_errorMsg"></div>
    <form id="reminder_form" role="form" class="form-horizontal">
        <div id="form-user-event-reminder">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#step1" data-toggle="tab">{{trans('calendar_events.ce_modal_session_navbar_define')}}</a>
                </li>
                <li>
                    <a class="disable-tab" style="background: #fff !important;padding: 14px;margin-right: 2px;border: none !important;">{{trans('calendar_events.ce_modal_session_navbar_setting')}}</a>
                </li>
                <li>
                    <a class="disable-tab" style="background: #fff !important;padding: 14px;margin-right: 2px;border: none !important;">{{trans('calendar_events.ce_modal_session_navbar_note')}}</a>
                </li>
            </ul>
            <div class="tab-content" style="overflow: auto;height: 50vh;padding-bottom: 10vh;">
                <div id="step1" class="tab-pane fade in active">
                    <div class="col-md-12">
                        <div class="">
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>
                                        {{--<span class="required">*</span>--}}
                                        {{trans('calendar_events.ce_modal_events_title_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="title" class="form-control" placeholder="" value="{{isset($form_data['htitle']) ? $form_data['htitle'] : ''}}">
{{--                                    <input type="hidden" {{isset($form_data['htitle']) ? 'name=event_id value='.$form_data["id"].'' : ''}}>--}}
                                    <input name="event_type" type="hidden" value="reminder">
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>
                                        {{trans('calendar_events.ce_modal_events_cid_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="cid" class="chosen-rtl">
                                        @if(!empty($form_data['hcid']))
                                            @if(!empty($form_data['hcid']))
                                                @foreach($form_data['hcid'] as $hcid)
                                                    <option selected="selected" value="{{ $hcid->id }}">{{ $hcid->title }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>{{trans('calendar_events.ce_description_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <textarea name="descriotion" class="form-control">{{isset($form_data['description']) ? $form_data['description'] : ''}}</textarea>
                                </div>
                            </div>
                            <div class="row col-lg-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="row col-lg-2 line-height-35">
                                    <label class="form-radio-label" >{{trans('calendar_events.ce_modal_reminder_added')}}</label>
                                </div>
                                <div class="row col-lg-9 noLeftPadding noRightPadding">
                                    <span class="pull-right col-lg-3 noLeftPadding noRightPadding line-height-35">
                                        <input name="reminderType" id="reminderType1" type="radio" class="form-radio-input" value="1" checked/>
                                        <label class="form-radio-label" for="reminderType1" >{{trans('calendar_events.ce_modal_reminder_in_time')}}</label>
                                        <input name="reminderType" id="reminderType2" type="radio" class="form-radio-input" value="2" disabled/>
                                        <label class="form-radio-label" for="reminderType2">{{trans('calendar_events.ce_modal_reminder_before')}}</label>
                                    </span>
                                    <span class="add-reminder-row-firstType pull-right line-height-35 col-lg-6 noLeftPadding noRightPadding" style="display: inline-flex;">
                                        <label class="pull-right" style="height: 33px;line-height: 35px">{{trans('calendar_events.ce_modal_reminder_in_day')}}</label>
                                        <span class="input-group pull-right clsDatePicker pull-right">
                                            <input type="text" class="form-control DatePicker clsDatePicker pull-right" value="{{isset($form_data['in_day'][0]['gregorian']) ? $form_data['in_day'][0]['gregorian'] : ''}}" autocomplete="off" id="in_day"  name="in_day[]" aria-describedby="in_day[]"/>
                                        </span>
                                        <label class="pull-right" style="height: 33px;line-height: 35px">{{trans('calendar_events.ce_hour_label')}}</label>
                                        <span class="input-group pull-right clsDatePicker pull-right">
                                            <input type="text" class="form-control TimePicker clsDatePicker" style="width: 150px" value="{{isset($form_data['firstTyp_term']) ? $form_data['firstTyp_term'][0]['value'] : ''}}" autocomplete="off" id="firstTyp_term" name="firstTyp_term[]" aria-describedby="term">
                                        </span>
                                    </span>
                                    <span class="add-reminder-row-secondType pull-right line-height-35 col-lg-7 noLeftPadding noRightPadding" style="display: inline-flex;">
                                        <label class="pull-right" style="height: 33px;line-height: 35px;white-space:nowrap">{{trans('calendar_events.ce_modal_reminder_befor_of')}}</label>
                                        <select name="befordays[]" class="form-control pull-right">
                                            <option value="0">{{trans('calendar_events.ce_selected')}}</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="1">4</option>
                                            <option value="1">5</option>
                                            <option value="1">6</option>

                                        </select>
                                        <select name="beforType[]" class="form-control pull-right">
                                            <option value="0">{{trans('calendar_events.ce_selected')}}</option>
                                            <option value="1">{{trans('calendar_events.ce_modal_reminder_day')}}</option>
                                            <option value="2">{{trans('calendar_events.ce_modal_reminder_week')}}</option>
                                            <option value="3">{{trans('calendar_events.ce_modal_reminder_month')}}</option>
                                        </select>
                                        <label class="pull-right" style="height: 35px;line-height: 35px;white-space:nowrap">{{trans('calendar_events.ce_modal_reminderin_hour')}}</label>
                                        <span class="input-group pull-right clsDatePicker pull-right">
                                            <input type="text" class="form-control TimePicker clsDatePicker" style="width: 150px" value=" " name="secondType_term[]" aria-describedby="term">
                                        </span>
                                    </span>
                                    <span class="pull-right col-lg-1 noLeftPadding noRightPadding line-height-35">
                                        <i class="btn btn-primary fa fa-plus addReminderTimeBtn"></i>
                                    </span>
                                    <div class="row col-xs-12 noLeftPadding noRightPadding line-height-35">
                                        <div class="row col-xs-12 reminderTimeList noLeftPadding noRightPadding line-height-35 {{isset($form_data['in_day']) ? (count($form_data['in_day'])>1 ? '' : 'hidden') : ''}}">
                                            <div class="row col-xs-12 noLeftPadding noRightPadding line-height-35 margin-top-10">{{trans('calendar_events.ce_modal_reminder_time_list')}}:</div>
                                            @if(isset($form_data['in_day']))
                                                @for($i=1;$i<=(count($form_data['in_day'])-1);$i++)
                                                    <div class='row col-xs-12'>
                                                        <span class='pull-right col-lg-1 noLeftPadding noRightPadding'></span>
                                                        <span class='pull-right line-height-35 col-lg-4 noLeftPadding noRightPadding margin-right-10'>
                                                            <label class='pull-right noLeftPadding noRightPadding margin-right-10'>{{trans('calendar_events.ce_modal_reminder_in_time')}}</label>
                                                            <input type='hidden' value='{{$form_data['in_day'][$i]['value']}}' name='in_day[]'/>
                                                            <input type='hidden' value='{{$form_data['firstTyp_term'][$i]['value']}}' name='firstTyp_term[]'/>
                                                            <label class='pull-right pull-right margin-right-10'>{{$form_data['in_day'][$i]['value']}}</label>
                                                            <label class='pull-right pull-right margin-right-10'>{{$form_data['firstTyp_term'][$i]['value']}}</label>
                                                        </span>
                                                        <span class='pull-right col-lg-1 margin-right-10 removeReminderTimeBtn'><i class='fa fa-remove pointer'></i></span>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">--}}
                                {{--<div class="col-xs-2">--}}

                                    {{--<label--}}
                                            {{--class="form-check-label">{{trans('calendar_events.ce_allday_label')}}--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-10">--}}
                                    {{--<input name="allDay" type="checkbox"--}}
                                           {{--class="form-check-input" value="1">--}}
                                {{--</div>--}}
                            {{--</div>--}}
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
    </form>
</div>
        {{-- </div>
        </div>
        </div>
        </div>--}}
        <script>
            $(document).on('click', '.removeReminderTimeBtn', function () {
                $(this).parent().remove();
            });
            $(".DatePicker").persianDatepicker({

                autoClose: true,
                format: 'YYYY-MM-DD',

            });
            // $(".DatePicker").val('');
            $(".TimePicker").persianDatepicker({
                format: "HH:mm",
                timePicker: {
                    //showSeconds: false,
                },
                onlyTimePicker: true
            });
            // $(".TimePicker").val('');
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