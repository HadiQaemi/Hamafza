<!--- new Reminder modal-------------->
{{--<div class="modal fade" id="add_reminder_dialog">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">

                </h4>
            </div><!-- end modal header -->
            <div class="modal-body">--}}
                <div class="reminder_errorMsg"></div>
<div class="col-md-12 reminder_add_title" style="text-align: right;margin: 18px;">
    <div class="col-md-3"></div>
    <div class="col-md-4"></div>
    <div class="col-md-1"></div>
    <div class="col-md-4"></div>

</div>
                <div class="container table-bordered" style="width: 95%">

                        <form >

                    <div class="form-reminder-content">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#addR2" data-toggle="tab">{{traNS('calendar_events.ce_modal_reminder_added')}}</a>
                            </li>
                            <li><a href="#listR2" data-toggle="tab">{{traNS('calendar_events.ce_modal_reminder_registerd_list')}}</a>
                            </li>
                        </ul>

                        <div class="clearfixed"></div>
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="addR2">
                                <div class="col-md-12 text-center">
                                    <label class="form-radio-label ">{{trans('calendar_events.ce_modal_reminder_first_type')}}
                                        <input name="reminderType2" type="radio"
                                               class="form-radio-input" value="1" checked>
                                    </label>
                                    <label class="form-radio-label ">{{trans('calendar_events.ce_modal_reminder_second_type')}}
                                        <input name="reminderType2" type="radio"
                                               class="form-radio-input" value="2">
                                    </label>
                                </div>

                                <div class="clearfixed"></div>
                                <div class="add-reminder-row-firstType2 panel panel-primary">
                                    <div class="panel-heading"> <h4 class="panel-title">{{trans('calendar_events.ce_modal_reminder_first_type')}} </h4></div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-striped col-md-12">
                                            <tbody>
                                            <tr>
                                                <td class="col-md-2">
                                                    <label>
                                                        {{trans('calendar_events.ce_modal_reminder_in_day')}}
                                                    </label>
                                                <td class="col-md-4">
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

                                                </td>
                                                <td class="col-md-2">
                                                    <label>{{trans('calendar_events.ce_hour_label')}}</label>
                                                </td>
                                                <td class="col-md-4">
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
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3"><label>{{trans('calendar_events.ce_modal_reminder_notice_type')}}</label></td>
                                                <td class="col-md-9" colspan="2">

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

                                                </td>
                                                <td class="col-md-1">

                                                    <a class="center-block btn btn-info btn-block fa fa-floppy-o "
                                                       href="#"
                                                       style="margin-top:20px;"
                                                       onclick="addFirstType2(this);"> {{trans('calendar_events.saved')}}</a>


                                                   <!-- <a class="center-block btn btn-default btn-xs fa fa-close" href="#"
                                                       style="margin-top:20px;" onclick="removeFirstType(this);"></a>-->

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="add_secondType_nav">

                                </div>
                                <div class="add-reminder-row-secondType2 panel panel-primary">
                                    <div class="panel-heading"> <h4 class="panel-title">{{trans('calendar_events.ce_modal_reminder_second_type')}}</h4> </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered table-striped col-md-12">
                                            <tbody>
                                            <tr>
                                                <td class="col-md-2">
                                                    <label>{{trans('calendar_events.ce_modal_reminder_befor_of')}}</label>
                                                </td>
                                                <td class="col-md-4">

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
                                                </td>
                                                <td class="col-md-2">
                                                    <label>{{trans('calendar_events.ce_modal_reminderin_hour')}}</label>
                                                    </td>
                                                    <td class="col-md-4">
                                                        <div class=' form-horizontal input-group date'>
                                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>


                                                            <input type="text" class="form-control TimePicker"
                                                                   placeholder="ا"
                                                                   name="secondType_term[]"
                                                                   aria-describedby="term">
                                                        </div>
                                                </td>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-2"><label> {{trans('calendar_events.ce_modal_reminder_notice_type')}}</label></td>
                                                <td class="col-md-9" colspan="2">
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
                                                </td>
                                                <td class="col-md-1">


                                                    <a class="center-block btn btn-info btn-block fa fa-floppy-o "
                                                       href="#"
                                                       style="margin-top:20px;" onclick="addSecondType2(this);"> {{trans('calendar_events.saved')}} </a>



                                                    <!--<a class="center-block btn btn-default btn-xs fa fa-close" href="#"
                                                       style="margin-top:20px;" onclick="removeSecondType(this);"></a>-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane active" id="listR2">

                                 <table class=" col-md-12 table table-bordered  " id="reminderList2">
                                    <thead>
                                    <tr>
                                       <th> #</th>
                                       <th> {{trans('calendar_events.ce_date_label')}} </th>
                                        <th> {{trans('calendar_events.ce_hour_label')}} </th>
                                        <th> {{trans('calendar_events.ce_action_label')}} </th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    </table>

                            </div>
                        </div>
                        <!--<div>
                           <button type="button" name="saveReminder"
                                    class="btn btn-success pull-left ">
                                <i class="glyphicon  glyphicon-save-file bigger-125">
                                    <span>ثبت</span></i>
                            </button>

                        </div>-->

                    </div>
                        </form>
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
        dataType:'json',
        success: function (s) {

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