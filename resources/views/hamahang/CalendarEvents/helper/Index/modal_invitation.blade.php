<!--- invitation modal------->
{{--<div class="modal fade" id="add_invitation_dialog">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans('calendar_events.ce_modal_invitation_header_title')}} </span>:
                    <span class="bg-warning"
                          style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
                <ul class='nav nav-wizard'>

                    <li class='active'><a href='#step1'>{{trans('calendar_events.ce_modal_invitation_navbar_nav1')}} </a></li>

                    <li><a href='#step2'>{{trans('calendar_events.ce_modal_invitation_navbar_nav2')}} </a></li>


                </ul>
            </div><!-- end modal header -->
            <div class="modal-body">--}}
<div id="form-content">
    <div id="invitation_errorMsg"></div>
    <form id="invitation_form" role="form" class="form-horizontal">
        <div id="form-session-content">

            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#step1" data-toggle="tab">
                        <span>{{trans("calendar_events.ce_modal_invitation_navbar_nav1")}}</span>
                    </a>
                </li>
                <li >
                    <a href="#step2" data-toggle="tab">
                        <span>{{trans('calendar_events.ce_modal_invitation_navbar_nav2')}}</span>
                    </a>
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
                                    <input name="title" class="form-control"placeholder="">
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label>
                                        <span class="required">*</span>
                                        {{trans('calendar_events.ce_modal_events_cid_field_lable')}}
                                    </label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="cid" class="chosen-rtl"></select>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label class="line-height-30 pull-right">{{trans('calendar_events.ce_startdate_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <div class="col-sm-5 col-xs-5">
                                        <div class="input-group pull-right">
                                            <span class="input-group-addon" id="startdate-session ">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control DatePicker  clsDatePicker col-xs-4" name="startdate" placeholder="{{trans('calendar_events.ce_date_label')}}"
                                                   aria-describedby="startdate-session">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2"></div>
                                    <div class="col-sm-5 col-xs-5">
                                        <div class=' input-group date'>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar_events.ce_hour_label')}}" name="starttime" aria-describedby="starttime">
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
                                            <span class="input-group-addon" id="enddate-session ">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control DatePicker  clsDatePicker col-xs-4" name="enddate"
                                                   placeholder="{{trans('calendar_events.ce_date_label')}}" aria-describedby="enddate-session">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-xs-2"></div>
                                    <div class="col-sm-5 col-xs-5">
                                        <div class=' input-group date'>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar_events.ce_hour_label')}}" name="endtime"
                                                   placeholder=" {{trans('calendar_events.ce_hour_label')}}" aria-describedby="endtime">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-2">
                                    <label class="form-check-label">{{trans('calendar_events.ce_allday_label')}}</label>
                                </div>
                                <div class="col-xs-10">
                                    <input name="allDay" type="checkbox" class="form-check-input" value="1"></label>
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

                <div id="step2" class="tab-pane fade">
                    <div class="panel panel-info col-md-12">
                        <div class="panel-body">
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20 line-height-35">
                                <div class="col-xs-3">
                                    <label>{{trans('calendar_events.ce_modal_invitation_about_field_lable')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <div class="col-xs-6 noLeftPadding noRightPadding ">
                                        <input type="text" class="form-control" name="about"/>
                                    </div>
                                    <div class="col-xs-1"></div>
                                    <div class="col-xs-5">
                                        <label>{{trans('calendar_events.ce_modal_invitation_invitation_type_field_label2')}} <input type="radio" checked name="invitation_type" value="1">
                                        </label>
                                        <label>{{trans('calendar_events.ce_modal_invitation_invitation_type_field_label1')}}<input type="radio" name="invitation_type" value="2"> </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3 line-height-35">
                                    <label>{{trans('calendar_events.ce_modal_invitation_invitationusers')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <select
                                            name="invitationusers[]"
                                            class="chosen-rtl col-xs-12"
                                            data-placeholder="{{trans('calendar_events.ce_selected_users')}}"

                                            multiple>
                                        <option value=""></option>
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3 line-height-35">
                                    <label>{{trans('calendar_events.ce_term_of_session')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <div class='col-md-4 form-horizontal input-group date'>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                        <input type="text" class="form-control TimePicker"
                                               placeholder="ا"
                                               name="term"
                                               aria-describedby="term">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3 line-height-35">
                                    <label>{{trans('calendar_events.ce_modal_invitation_location')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <textarea name="location" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3 line-height-35">
                                    <label>{{trans('calendar_events.ce_modal_invitation_Coordinate_invitation_location')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" name="long" class="form-control col-md-4" placeholder="{{trans('calendar_events.ce_longitute')}}  "/>
                                    <input type="text" name="latt" class="form-control col-md-4" placeholder="{{trans('calendar_events.ce_latitute')}}"/>
                                </div>
                            </div>
                            <div class="col-xs-12 noLeftPadding noRightPadding margin-top-20">
                                <div class="col-xs-3 line-height-35">
                                    <label>{{trans('calendar_events.ce_modal_invitation_allow_inform_invitees')}}</label>
                                </div>
                                <div class="col-xs-9">
                                    <input name="allow_inform_invitees" type="checkbox" class="form-check-input" value="1">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  <div class="btnContent">
                  <button type="button" name="saveSession" id="saveSession"
                          class="btn btn-success pull-left">
                      <i class="glyphicon  glyphicon-save-file bigger-125">
                          <span>{{trans('calendar_events.ce_saved_label')}}</span></i>
                  </button>
              </div>
          </div>--}}
        </div>

    </form>

    {{-- </div>
 </div>
</div>
</div>
</div>--}}

{{--</div>
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
    $("select[name='invitationusers[]']").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
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
    </script>