<!-- Sesssion Modal --->
{{--<div class="modal fade" id="add_seesion_dialog">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans("calendar_events.ce_modal_session_header_title")}}</span>:
                    <span class="bg-warning"
                          style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
                <ul class='nav nav-wizard class="col-md-12"'>

                    <li class='active' class="col-md-6"><a href='#step1'>{{trans("calendar_events.ce_modal_session_navbar_nav1")}}</a></li>

                    <li><a href='#step2' class="col-md-6">{{trans("calendar_events.ce_modal_session_navbar_nav2")}}</a></li>


                </ul>
            </div><!-- end modal header -->
            <div class="modal-body">
                <div class="container table-bordered" style="width: 95%">--}}
                    <ul class='nav nav-wizard class="col-md-12"'>

                        <li class='active' class="col-md-6"><a href='#step1'>{{trans("calendar_events.ce_modal_session_navbar_nav1")}}</a></li>

                        <li><a href='#step2' class="col-md-6">{{trans("calendar_events.ce_modal_session_navbar_nav2")}}</a></li>


                    </ul>
                    <div id="form-content">
                        <div id="sessionMsgBox"></div>
                        <form id="sessionForm" role="form" class="form-horizontal">
                            <div id="form-event-content">
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
                                        <td class="col-md-2">
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

                                            <label class="line-height-30 pull-right">{{trans('calendar_events.ce_startdate_label')}}</label>
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
                                                           placeholder="{{trans('calendar_events.ce_hour_label')}}"
                                                           name="endtime"
                                                           placeholder=" {{trans('calendar_events.ce_hour_label')}}"
                                                           aria-describedby="endtime">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=" col-md-3">
                                            <label class="form-check-label">{{trans('calendar_events.ce_allday_label')}}</label>
                                        </td>
                                        <td class="col-md-9">
                                            <input name="allDay" type="checkbox"
                                                   class="form-check-input" value="1"></label>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=" col-md-2">
                                            <label>{{trans('calendar_events.ce_description_label')}}</label>
                                        </td>
                                        <td class="col-md-10">
                                    <textarea name="descriotion" class="form-control"
                                    ></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" class="col-md-12">

                                        </td>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <div id="form-session-content">

                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#s_form" data-toggle="tab">
                                            <i class="fa fa-edit"></i>
                                            <span>{{trans('calendar_events.ce_modal_session_form')}}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#s_detail" data-toggle="tab">
                                            <i class="fa fa-edit"></i>
                                            <span> {{trans('calendar_events.ce_modal_session_attachs')}}</span>
                                        </a>
                                    </li>

                                </ul>
                                <div class="tab-content" style="overflow: auto;max-height: 300px; ">
                                    <div id="s_form" class="tab-pane fade in active">
                                        <div class="panel panel-info col-md-12">
                                            <div class="panel-body">
                                                <table class="table table-bordered table-striped col-md-12" style="width: 95%">
                                                    <tbody>
                                                    <tr>
                                                        <td class="col-md-2">
                                                            <label>

                                                                <span class="required">*</span>

                                                                <span>{{trans('calendar_events.ce_agenda_label')}}</span>

                                                            </label>
                                                        </td>
                                                        <td class="col-md-10">
                                                            <input type="text" name="agenda" id="agenda" class="col-md--7"/>


                                                            <label> {{trans('calendar_events.ce_modal_session_personal')}}<input type="radio" checked name="session_type" value="1"/> </label>
                                                            <label> {{trans('calendar_events.ce_moda_session_modal_administrative')}}<input type="radio" name="session_type" value="2"/> </label>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <label>{{trans('calendar_events.ce_moda_session_modal_session_chief')}}</label>
                                                        </td>
                                                        <td class="col-md-9">
                                                            <select
                                                                    name="session_chief"
                                                                    class="chosen-rtl col-xs-12"
                                                                    data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_chief')}}"
                                                            >
                                                                <option value=""></option>
                                                                <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <label>{{trans('calendar_events.ce_moda_session_modal_session_secretary')}}</label>
                                                        </td>
                                                        <td class="col-md-9">
                                                            <select
                                                                    name="session_secretary"
                                                                    class="chosen-rtl col-xs-12"
                                                                    data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_secretary')}}"
                                                            >
                                                                <option value=""></option>
                                                                <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">
                                                            <label>{{trans('calendar_events.ce_moda_session_modal_session_facilitator')}}</label>
                                                        </td>
                                                        <td class="col-md-9">
                                                            <select
                                                                    name="session_facilitator"
                                                                    class="chosen-rtl col-xs-12"
                                                                    data-placeholder="{{trans('calendar_events.ce_moda_session_modal_session_facilitator')}}"
                                                            >
                                                                <option value=""></option>
                                                                <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                                            </select>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class=" col-md-3">

                                                            <label>
                                                            {{trans('calendar_events.ce_moda_session_modal_session_voting_users')}}

                                                            </label>
                                                        </td>
                                                        <td class="col-md-9">
                                                            <select
                                                                    name="session_voting_users[]"
                                                                    class="chosen-rtl col-xs-12"
                                                                    data-placeholder="{{trans('calendar_events.ce_selected_users')}}"
                                                                    multiple>
                                                                <option value=""></option>
                                                                <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <td class=" col-md-3">

                                                        <label>ا
                                                            {{trans('calendar_events.ce_moda_session_modal_session_notvoting_users')}}
                                                        </label>
                                                    </td>
                                                    <td class="col-md-9">
                                                        <select
                                                                name="session_notvoting_users[]"
                                                                class="chosen-rtl col-xs-12"
                                                                data-placeholder="{{trans('calendar_events.ce_selected_users')}}"
                                                                multiple>
                                                            <option value=""></option>
                                                            <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                                        </select>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-2">
                                                            <label> {{trans('calendar_events.ce_term_of_session')}} </label>
                                                        </td>
                                                        <td class="col-md-10">
                                                            <div class='col-md-4 form-horizontal input-group date'>
                                                            <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>


                                                                <input type="text" class="form-control TimePicker"
                                                                       placeholder="ا"
                                                                       name="term"
                                                                       aria-describedby="term">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="form-group col-md-2">
                                                            <label>
                                                                <span class="required">*</span>
                                                                {{trans('calendar_events.ce_location')}}
                                                            </label>
                                                        </td>
                                                        <td class="col-md-10">
                                    <textarea name="location" class="form-control"
                                    ></textarea>
                                                        </td>
                                                    </tr>
                                                    <td class="form-group col-md-2">
                                                        <label>
                                                           {{trans('calendar_events.ce_modal_session_Coordinate_sesion_location')}}
                                                        </label>
                                                    </td>
                                                    <td class="col-md-10">
                                                        <input type="text" name="long" class="form-control col-md-4" placeholder="{{trans('calendar_events.ce_longitute')}} "/>
                                                        <input type="text" name="lat" class="form-control col-md-4" placeholder="{{trans('calendar_events.ce_latitute')}} "/>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="col-md-12">
                                                            <div id="map_canvas" class="col-md-12"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">{{trans('calendar_events.ce_modal_session_location_phone')}}</td>
                                                        <td class="col-md-9"><input type="text" class="form-control" name="location_phone"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-3">{{trans('calendar_events.ce_modal_session_coordination_phone_phone')}}</td>
                                                        <td class="col-md-9"><input type="text" class="form-control" name="coordination_phone"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-12" colspan="2">
                                                            <div class="form-check">
                                                                <label class="form-check-label ">{{trans('calendar_events.ce_send_Invitation')}}
                                                                    <input name="send_Invitation" type="checkbox" id="send_Invitation"
                                                                           class="form-check-input" value="1">
                                                                </label>
                                                                <label class="form-check-label ">{{trans('calendar_events.ce_create_session_page')}}
                                                                    <input name="create_session_page" type="checkbox"
                                                                           class="form-check-input" value="1">
                                                                </label>
                                                                <label class="form-check-label ">{{trans('calendar_events.ce_allow_inform_invitees')}}
                                                                    <input name="allow_inform_invitees" type="checkbox"
                                                                           class="form-check-input" value="1">
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="s_detail" class="tab-pane fade">
                                        <div class="panel panel-info col-md-12">
                                            <div class="panel-body">
                                                <table class="table table-bordered table-striped col-md-12">
                                                    <tr>
                                                        <td class="col-md-2">
                                                            <label class="line-height-35">{{trans('calendar_events.ce_attachs')}}</label>
                                                        </td>
                                                        <td class="col-md-10">
                                                            <!--<div class="row-fluid">-->
                                                            <div class="col-md-12 form-inline line-height-25">
                                                                @foreach($HFM_CalendarEvent['Buttons'] as $key => $value)
                                                                    {!! $value !!}
                                                                    {!! $HFM_CalendarEvent['ShowResultArea'][$key] !!}
                                                                @endforeach
                                                            </div>
                                                            <!-- </div>-->
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-12" colspan="2">
                                                            <table id="sessionFilesGrid"
                                                                   class="table table-condensed table-hover table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{trans('calendar_events.ce_rowindex_label')}}</th>
                                                                    <th>{{trans('calendar_events.ce_file_title')}}</th>
                                                                    <th>{{trans('calendar_events.ce_file_type')}}</th>
                                                                    <th>{{trans('calendar_events.ce_file_size')}}</th>
                                                                    <th>
                                                                        عملیات دانلود
                                                                    </th>
                                                                </tr>
                                                                </thead>


                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
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

                        </form>
                    </div>
               {{-- </div>
            </div>
        </div>
    </div>
</div>--}}
{!! $HFM_CalendarEvent['UploadForm'] !!}


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

    $("select[name='session_voting_users[]']").select2({
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


    $("select[name='session_notvoting_users[]']").select2({
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


    $("select[name='session_chief']").select2({
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


    $("select[name='session_secretary']").select2({
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

    $("select[name='session_facilitator']").select2({
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

{!! $HFM_CalendarEvent['UploadForm'] !!}